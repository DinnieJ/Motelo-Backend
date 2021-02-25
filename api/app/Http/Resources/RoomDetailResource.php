<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomDetailResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->title,
            'room_type_id' => $this->room_type_id,
            'price' => $this->price,
            'acreage' => $this->acreage,
            'description' => $this->description,
            'verified' => $this->verified,
            'verified_at' => $this->verified_at->format('d-m-Y'),
            'available' => $this->available,
            'status' => $this->status,
            'inn_detail' => new InnDetailForRoomResource($this->inn),
            'comments' => $this->comments,
            'created_at' => $this->created_at->format('d-m-Y'),
            'updated_at' => $this->updated_at->format('d-m-Y')
        ];
    }
}
