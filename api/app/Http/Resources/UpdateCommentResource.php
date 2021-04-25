<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
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
                'time_context' => $this->getTimeContext(),
            ]
        ];
    }

    private function getTimeContext()
    {
        $strUpdated = $this->updated_at->setTimezone(\Config::get('app.timezone'))->format('H:i d-m-Y');
        return "Sửa lúc $strUpdated";
    }
}
