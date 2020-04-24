<?php

namespace App\Http\Requests\Api;


class UserAddressRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'province'      => 'required',
            'city'          => 'required',
            'district'      => 'required',
            'address'       => 'required',
            'zip'           => 'required|numeric',
            'contact_name'  => 'required',
            'contact_phone' => 'required',
        ];
    }
}
