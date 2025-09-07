<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BuildingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'address.city' => $this->address['city'],
            'address.street' => $this->address['street'],
            'address.house' => $this->address['house'],
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'organizations' => $this->whenLoaded('organizations')
        ];
    }
}
