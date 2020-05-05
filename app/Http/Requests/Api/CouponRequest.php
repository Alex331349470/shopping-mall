<?php

namespace App\Http\Requests\Api;


class CouponRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|numeric',
        ];
    }
}
