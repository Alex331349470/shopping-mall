<?php

namespace App\Http\Requests\Api;


class UserRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required|string',
            'encryptedData' => 'required|string',
            'iv' => 'required|string'
        ];
    }
}
