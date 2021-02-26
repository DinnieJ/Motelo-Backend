<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

class RoomCommentForRoomResource extends JsonResource
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
            'tenant_id' => $this['tenant_id'],
            'tenant_name' => $this['tenant_name'],
            'room_id' => $this['room_id'],
            'comment' => $this['comment'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at']
        ];
    }
}
