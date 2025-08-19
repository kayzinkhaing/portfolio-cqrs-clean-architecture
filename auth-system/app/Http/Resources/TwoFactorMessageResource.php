<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TwoFactorMessageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
        ];
    }
}
