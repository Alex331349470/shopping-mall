<?php

namespace App\Http\Resources;

use App\Models\GoodImage;
use Illuminate\Http\Resources\Json\JsonResource;

class GoodImageResource extends JsonResource
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
        $data['image'] = GoodImage::find($request->id)->imageUrl;

        return $data;
    }
}
