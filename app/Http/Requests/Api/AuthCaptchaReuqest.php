<?php

namespace App\Http\Requests\Api;


class AuthCaptchaReuqest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => [
                'required',
                'string'
            ]
        ];
    }
}
