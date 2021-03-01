<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use function Symfony\Component\Translation\t;

class UpdateCommentResource extends JsonResource
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
            'message' => 'Cập nhật comment thành công',
            'comment' => [
                'id' => $this->id,
                'tenant_id' => $this->tenant_id,
                'tenant_name' => $this->tenant_name,
                'room_id' => $this->room_id,
                'comment' => $this->comment,
                'created_at' => $this->created_at->format('d-m-Y'),
                'updated_at' => $this->updated_at->format('d-m-Y')
            ]
        ];
    }
}
