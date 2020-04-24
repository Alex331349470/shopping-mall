<?php

namespace App\Http\Requests\Api;


class ReplyImageRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => 'required|image',
            'order_id' => 'required|numeric',
            'good_id' => 'required|numeric'
        ];
    }
}
