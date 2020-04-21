<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserRequest;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $code = $request->code;

        $miniProgram = \EasyWeChat::miniProgram();
        $data = $miniProgram->auth->session($code);

        if (isset($data['errcode'])) {
            throw new AuthenticationException('code不正确');
        }

        $decryptedData = $miniProgram->encryptor->decryptData($data['session_key'], $request->iv, $request->encryptedData);

        dd($decryptedData);
    }
}
