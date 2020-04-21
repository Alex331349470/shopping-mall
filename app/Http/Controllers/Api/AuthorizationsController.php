<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AuthorizationRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthorizationsController extends Controller
{
    public function store(AuthorizationRequest $request)
    {
        $code = $request->code;

        $miniProgram = \EasyWeChat::miniProgram();
        $data = $miniProgram->auth->session($code);

        if (isset($data['errcode'])){
            throw new AuthenticationException('code不正确');
        }

        $user = User::where('open_id',data['openid'])->first();

        if (!$user) {
            $attributes['session_key'] = $data['session_key'];
            $decryptedData = $miniProgram->encryptor->decryptData($data['session_key'], $request->iv, $request->encryptedData);
            $attributes['name'] = $decryptedData['nickName'];
            $attributes['avatar'] = $decryptedData['avatarUrl'];
            $attributes['open_id'] = $decryptedData['openId'];
            $user = User::create($attributes);

            $token = auth('api')->login($user);
            return $this->respondWithToken($token)->setStatusCode(201);
        } else {
            $user->update(['session_key' => $data['session_key']]);

            $token = auth('api')->login($user);
            return $this->respondWithToken($token)->setStatusCode(201);
        }
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

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
