<?php

namespace App\Http\Requests\Api;


class ReplyRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'good_id' => 'required|numeric',
            'order_id' => 'required|numeric',
            'replyContent' => 'required|string',
        ];
    }
}
