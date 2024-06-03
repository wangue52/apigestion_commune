<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class userRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return  [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'type' => $this->type === 'agent' ? 'agent' : ($this->type === 'receveur' ? 'receveur': 'receveur'),
            'phone' => $this->phone,
            'address' => $this->address,
            'avatar' => $this->avatar , // Store avatar if provided
            'matricule' => $this->matricule,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
