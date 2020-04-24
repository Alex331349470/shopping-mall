<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserInfoRequest;
use App\Http\Requests\Api\UserPasswordRequest;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Image;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

class UsersController extends Controller
{
    public function store(UserRequest $request, User $user, UserInfo $userInfo)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            abort(403, '验证码失效');
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            throw new AuthenticationException('验证码不正确');
        }

        if (!hash_equals($verifyData['phone'], $request->phone)) {
            throw new AuthenticationException('手机号错误');
        }

        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => bcrypt($request->password),
        ]);

        $userInfo->user_id = $user->id;
        $userInfo->save();
        \Cache::forget($request->verification_key);

        return new UserResource($user);
    }

    public function me(Request $request)
    {
        $user = User::whereId($request->user()->id)->with('userInfo')->first();
        return new UserResource($user);

    }

    public function retryPassword(UserPasswordRequest $request)
    {
        $verifyData = \Cache::get($request->verification_key);

        if (!$verifyData) {
            abort(403, '验证码失效');
        }

        if (!hash_equals($verifyData['code'], $request->verification_code)) {
            throw new AuthenticationException('验证码不正确');
        }

        $user = User::where('phone', $verifyData['phone'])->first();

        $user->password = bcrypt($request->password);

        $user->save();

        return new UserResource($user);
    }

    public function update(UserInfoRequest $request)
    {
        $user = $request->user();
        $user->name = $request->name;
        $user->save();
        if ($image = Image::whereUserId($user->id)->first()) {
            $user->avatar = $image->path;
            $user->save();
        }
        $data['real_name'] = $request->real_name;

        $data['gender'] = $request->gender;

        $user->userInfo()->update($data);
        $user = User::whereId($user->id)->with('userInfo')->first();
        return new UserResource($user);
    }
}
