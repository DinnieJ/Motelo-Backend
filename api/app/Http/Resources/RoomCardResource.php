<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'name' => $this['title'],
            'room_type' => $this['room_type_id'],
            'gender' => $this['gender_type_id'],
            'acreage' => $this['acreage'],
            'address' => $this['inn']['address'],
            'inn_name' => $this['inn']['name'],
            'verified' => $this['verified'],
            'available' => $this['available']
        ];
    }
}
