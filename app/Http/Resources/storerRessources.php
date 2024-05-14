<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class storerRessources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'name' => $this->name,
            'number' => $this->number,
            'bloc_id' => $this->bloc_id,
            'city' => $this->city,
            'district' => $this->district,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
