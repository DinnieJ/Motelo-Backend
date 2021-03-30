<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InnDetailForRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $location = unpack('x/x/x/x/corder/Ltype/dlat/dlon', $this['location']);
        return [
            'id' => $this['id'],
            'address' => $this['address'],
            'inn_name' => $this['name'],
            'owner_name' => $this['owner']['name'],
            'owner_id' => $this['owner']['id'],
            'owner_contact' => $this->getOwnerContact(),
            'water_price' => $this['water_price'],
            'electric_price' => $this['electric_price'],
            'wifi_price' => $this['wifi_price'],
            'open_time' => (($this['open_hour']) < 10 ? "0" . $this['open_hour'] : $this['open_hour']) . ":" . (($this['open_minute']) < 10 ? "0" . $this['open_minute'] : $this['open_minute']),
            'close_time' => (($this['close_hour']) < 10 ? "0" . $this['close_hour'] : $this['close_hour']) . ":" . (($this['close_minute']) < 10 ? "0" . $this['close_minute'] : $this['close_minute']),
            'location' => [
                'lat' => $location['lat'],
                'lng' => $location['lon']
            ],
            'features' => array_column($this['features'], 'inn_feature_id')
        ];
    }

    private function getOwnerContact()
    {
        $data = array_map(function ($value) {
            return new ContactDetailForRoomResource($value);
        }, $this['owner']['contacts']);

        return $data;
    }
}
