<?php

namespace App\Http\Requests\Api;


class OrderReceiveReuqest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'no' => 'required|string'
        ];
    }
}
