<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UtilityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this['id'],
            'type' => $this['utility_type_id'],
            'title' => $this['title'],
            'description' => $this['description'],
            'address' => $this['address'],
            'location' => $this->getLocation(),
            'image_url' => $this['image']['image_url'] ?? null
        ];
    }

    private function getLocation()
    {
        $decodeLocation = unpack('x/x/x/x/corder/Ltype/dlat/dlong', $this['location']);

        return $decodeLocation['lat'] . " " . $decodeLocation['long'];
    }
}
