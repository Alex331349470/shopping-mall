<?php

namespace App\Http\Requests\Api;


class GpsBasicDataRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'gps_basic_data' => 'required|json',
            'area_num' => 'required|numeric',
            'project_code' => 'required|numeric'
        ];
    }
}
