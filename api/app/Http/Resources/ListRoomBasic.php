<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ListRoomBasic extends JsonResource
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
            'current_page' => $this['current_page'],
            'total_page' => $this['last_page'],
            'prev_page_url' => $this['prev_page_url'],
            'next_page_url' => $this['next_page_url'],
            'total_items' => $this['total'],
            'data' => array_map(function ($value) {
                return new RoomBasic($value);
            }, $this['data']),
        ];
    }
}
