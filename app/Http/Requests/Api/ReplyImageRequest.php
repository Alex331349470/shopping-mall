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
            'image' => 'required|mimes:jpeg,bmp,png,gif',
            'order_id' => 'required|numeric',
            'good_id' => 'required|numeric'
        ];
    }
}
