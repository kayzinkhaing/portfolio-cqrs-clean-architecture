<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'email'      => $this->email,
            'township'   => $this->whenLoaded('township', function () {
                return [
                    'id'   => $this->township->id,
                    'name' => $this->township->name,
                ];
            }),
            'ward'       => $this->whenLoaded('ward', function () {
                return [
                    'id'   => $this->ward->id,
                    'name' => $this->ward->name,
                ];
            }),
            'created_at' => $this->created_at,
        ];
    }
}
