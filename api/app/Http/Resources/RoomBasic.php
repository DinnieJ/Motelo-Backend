<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomBasic extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'name' => $this['title'],
            'room_type' => $this['room_type_id'],
            'gender' => $this['gender_type_id'],
            'price' => $this['price'],
            'acreage' => $this['acreage'],
            'image' => isset($this['first_image']) ? $this['first_image']['image_url'] : null,
            'verified' => $this['verified'],
            'available' => $this['available'],
            'num_favorited' => count($this['favorites']),
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at']
        ];
    }
}
