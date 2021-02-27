<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'comment' => $this['comment'],
            'created_at' => $this['created_at'],
            'updated_at' => $this['updated_at']
        ];
    }
}
