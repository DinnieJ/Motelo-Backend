<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class RoomCardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $location = unpack('x/x/x/x/corder/Ltype/dlat/dlon', $this['inn']['location']);
        return [
            'id' => $this['id'],
            'name' => $this['title'],
            'room_type' => $this['room_type_id'],
            'gender' => $this['gender_type_id'],
            'price' => $this['price'],
            'acreage' => $this['acreage'],
            'address' => $this['inn']['address'],
            'inn_name' => $this['inn']['name'],
            'location' => [
                'lat' => $location['lat'],
                'lng' => $location['lon']
            ],
            'image' => $this['first_image']['image_url'],
            'verified' => $this['verified'],
            'available' => $this['available'],
            'favorited' => isset($this['favorites']) && count($this['favorites'])
        ];
    }
}
