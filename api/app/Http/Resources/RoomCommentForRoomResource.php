<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

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
            'time_context' => $this->getTimeContext()
        ];
    }

    private function getTimeContext()
    {
        $created =  Carbon::create($this['created_at']);
        $updated = Carbon::create($this['updated_at']);

        $diff = $created->diffInHours($updated);

        if ($created->diffInSeconds($updated) == 0) {
            $diffFromCurrent = Carbon::now()->diffInHours($created);
            if ($diffFromCurrent < 1) {
                return 'Vừa đăng';
            } elseif ($diffFromCurrent >= 1 && $diffFromCurrent < 24) {
                return "$diffFromCurrent giờ trước";
            } elseif ($diffFromCurrent >= 24) {
                $daysDiff = \round($diffFromCurrent / 24, 0);
                return "$daysDiff ngày trước";
            }
        } else {
            $strUpdated = $updated->setTimezone(\Config::get('app.timezone'))->format('H:i d-m-Y');
            return "Sửa lúc $strUpdated";
        }
    }
}
