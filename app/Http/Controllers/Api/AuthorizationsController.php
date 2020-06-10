<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AuthorizationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserInfo;
use GuzzleHttp\Client;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthorizationsController extends Controller
{
    public function store(AuthorizationRequest $request, UserInfo $userInfo)
    {
        $code = $request->code;
        //获取小程序实例
        $miniProgram = \EasyWeChat::miniProgram();
        //获取小程序当前用户session信息
        $data = $miniProgram->auth->session($code);
        //如果有错误则抛出异常
        if (isset($data['errcode'])) {
            throw new AuthenticationException('code不正确');
        }
        //搜索库中用户信息
        $user = User::where('open_id', $data['openid'])->first();
        //如果没有用户则解密数据进行新用户创建
        if (!$user) {
            $decryptedData = $miniProgram->encryptor->decryptData($data['session_key'], $request->iv, $request->encryptedData);

            $attributes['session_key'] = $data['session_key'];
            $attributes['name'] = $decryptedData['nickName'];
            $attributes['avatar'] = $decryptedData['avatarUrl'];
            $attributes['open_id'] = $decryptedData['openId'];
            $user = User::create($attributes);

            $userInfo->user_id = $user->id;
            //获取cookie中存在的parent_id而后保存到用户信息当中确定上下级关系
            if (!empty($request->user_id) && $request->user_id != 'null') {
                $userInfo->parent_id = $request->user_id;
            }
            //打印用户相关数据
            \Log::info("request_id = " . $request->user_id);
            \Log::info(getType($request->user_id));
            \Log::info($userInfo);
            //用户数据
            $userInfo->save();
            //获取用户token
            $token = auth('api')->login($user);
            return $this->respondWithToken($token)->setStatusCode(201);
        } else {
            //如果有客户信息则更新session_key
            $user->update(['session_key' => $data['session_key']]);

            $token = auth('api')->login($user);
            return $this->respondWithToken($token)->setStatusCode(201);
        }
    }
    //用户个人信息
    public function me(Request $request)
    {
        $user = User::query()->where('id', $request->user()->id)->with('userInfo')->first();
        return new UserResource($user);
    }

    //token值刷新
    public function update()
    {
        $token = auth('api')->refresh();
        return $this->respondWithToken($token);
    }

    //token值销毁
    public function destroy()
    {
        auth('api')->logout();
        return response(null, 204);
    }

    //获取当前系统access_token
    public function getAccessToken(Client $client)
    {
        $response = $client->get('https://api.weixin.qq.com/cgi-bin/token', [
            'query' => [
                'grant_type' => 'client_credential',
                'appid' => env('WECHAT_MINI_PROGRAM_APPID'),
                'secret' => env('WECHAT_MINI_PROGRAM_SECRET')
            ]
        ]);

        return $response;
    }

    //token值的json返回格式
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
