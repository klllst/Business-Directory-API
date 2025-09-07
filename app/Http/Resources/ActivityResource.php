<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'organizations' => OrganizationResource::collection($this->whenLoaded('organizations')),
            'parent' => new ActivityResource($this->whenLoaded('parent')),
            'children' => ActivityResource::collection($this->whenLoaded('children')),
        ];
    }
}
