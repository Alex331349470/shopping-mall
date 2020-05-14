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

        $miniProgram = \EasyWeChat::miniProgram();
        $data = $miniProgram->auth->session($code);

        if (isset($data['errcode'])){
            throw new AuthenticationException('code不正确');
        }

        $user = User::where('open_id',$data['openid'])->first();

        if (!$user) {
            $decryptedData = $miniProgram->encryptor->decryptData($data['session_key'], $request->iv, $request->encryptedData);

            $attributes['session_key'] = $data['session_key'];
            $attributes['name'] = $decryptedData['nickName'];
            $attributes['avatar'] = $decryptedData['avatarUrl'];
            $attributes['open_id'] = $decryptedData['openId'];
            $user = User::create($attributes);

            $userInfo->user_id = $user->id;

            if (!empty($request->user_id)) {
                $userInfo->parent_id = $request->user_id;
            }

            $userInfo->save();

            $token = auth('api')->login($user);
            return $this->respondWithToken($token)->setStatusCode(201);
        } else {
            $user->update(['session_key' => $data['session_key']]);

            $token = auth('api')->login($user);
            return $this->respondWithToken($token)->setStatusCode(201);
        }
    }

    public function me(Request $request)
    {
        $user = User::query()->where('id',$request->user->id)->with('userInfo')->first();
        return new UserResource($user);
    }

    public function update()
    {
        $token = auth('api')->refresh();
        return $this->respondWithToken($token);
    }

    public function destroy()
    {
        auth('api')->logout();
        return response(null, 204);
    }

    public function getAccessToken(Client $client)
    {
        $response = $client->get('https://api.weixin.qq.com/cgi-bin/token',[
            'query' => [
                'grant_type' => 'client_credential',
                'appid' => env('WECHAT_MINI_PROGRAM_APPID'),
                'secret' => env('WECHAT_MINI_PROGRAM_SECRET')
            ]
        ]);

       return $response;
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
