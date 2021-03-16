<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BasicInnDetail extends JsonResource
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
            'name' => $this->name,
            'owner_id' => $this->owner_id,
            'water_price' => $this->water_price,
            'electric_price' => $this->electric_price,
            'open_time' => (($this->open_hour) < 10 ? "0" . $this->open_hour : $this->open_hour) . ":" . (($this->open_minute) < 10 ? "0" . $this->open_minute : $this->open_minute),
            'close_time' => (($this->close_hour) < 10 ? "0" . $this->close_hour : $this->close_hour) . ":" . (($this->close_minute) < 10 ? "0" . $this->close_minute : $this->close_minute),
            'description' => $this->description,
            'address' => $this->address,
            'location' => $this->latitude . " " . $this->longitude,
            'status' => $this->status,
            'features' => array_column($this->features->toArray(), 'inn_feature_id'),
            'created_at' => $this->created_at->format('d-m-Y'),
            'updated_at' => $this->updated_at->format('d-m-Y')
        ];
    }
}
