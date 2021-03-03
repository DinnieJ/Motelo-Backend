<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddFavoriteRoomResponse extends JsonResource
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
            'message' => 'Thêm thành công vào danh sách yêu thích',
            'room_favorite' => [
                'id' => $this->id,
                'room_id' => $this->room_id,
                'tenant_id' => $this->tenant_id,
                'created_at' => $this->created_at->format('d-m-Y'),
                'updated_at' => $this->updated_at->format('d-m-Y')
            ]
        ];
    }
}
