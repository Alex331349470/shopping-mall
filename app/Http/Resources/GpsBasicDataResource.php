<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GpsBasicDataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data =  parent::toArray($request);
        $data['gps_basic_data'] = json_decode($data['gps_basic_data'],true);
        return $data;
    }
}
