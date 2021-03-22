<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\ImageHelper;

class RoomDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    use ImageHelper;

    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'name' => $this['title'],
            'room_type_id' => $this['room_type_id'],
            'price' => $this['price'],
            'acreage' => $this['acreage'],
            'description' => $this['description'],
            'verified' => $this['verified'],
            'verified_at' => $this['verified_at'],
            'available' => $this['available'],
            'status' => $this['status'],
            'favorited' => $this['favorited'],
            'gender_type_id' => $this['gender_type_id'],
            'inn_detail' => new InnDetailForRoomResource($this['inn']),
            'images' => $this->getImages($this['images']),
            'comments' => $this->getRoomComment(),
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at']
        ];
    }

    private function getRoomComment()
    {
        $data = array_map(function ($value) {
            return new RoomCommentForRoomResource($value);
        }, $this['comments']);

        return $data;
    }

}

