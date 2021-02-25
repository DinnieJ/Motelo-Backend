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
        return [
            'id' => $this->id,
            'address' => $this->address,
            'inn_name' => $this->name,
            'owner_name' => $this->owner->name,
            'owner_id' => $this->owner->id,
            'owner_contact' => $this->getOwnerContact(),
            'water_price' => $this->water_price,
            'electric_price' => $this->electric_price,
            'open_time' => (($this->open_hour) < 10 ? "0" . $this->open_hour : $this->open_hour) . ":" . (($this->open_minute) < 10 ? "0" . $this->open_minute : $this->open_minute),
            'close_time' => (($this->close_hour) < 10 ? "0" . $this->close_hour : $this->close_hour) . ":" . (($this->close_minute) < 10 ? "0" . $this->close_minute : $this->close_minute),
            'features' => $this->getFeatures()
        ];
    }

    private function getOwnerContact()
    {
        $data = array_map(function ($value) {
            return new ContactDetailForRoomResource($value);
        }, $this->owner->contacts->toArray());

        return $data;
    }

    private function getFeatures()
    {
        $data = array_map(function ($value) {
            return new FeaturesDetailForRoomResource($value);
        }, $this->features->toArray());

        return $data;
    }
}
