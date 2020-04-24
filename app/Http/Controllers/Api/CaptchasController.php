<?php

namespace App\Http\Controllers\Api;

use Gregwar\Captcha\PhraseBuilder;
use  Illuminate\Support\Str;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use App\Http\Requests\Api\CaptchaRequest;

class CaptchasController extends Controller
{
    public function store(CaptchaRequest $request)
    {
        //创建图片验证码key
        $key = 'captcha-' . Str::random(15);
        $phone = $request->phone;
        //通过captcha轮子进行验证码数字验证设置
        $phraseBuilder = new PhraseBuilder(5, '0123456789');

        $captcha = new CaptchaBuilder(null, $phraseBuilder);
        //创建验证码
        $captcha->build();
        $expiredAt = now()->addMinutes(5);
        //缓存验证码信息
        \Cache::put($key, ['phone' => $phone, 'code' => $captcha->getPhrase()], $expiredAt);

        $result = [
            'captcha_key' => $key,
            'expired_at' => $expiredAt->toDateTimeString(),
            'captcha_image_content' => $captcha->inline()
        ];
        //返回验证码信息
        return response()->json($result)->setStatusCode(201);
    }
}