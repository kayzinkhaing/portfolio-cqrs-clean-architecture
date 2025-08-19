<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TwoFactorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'success' => true,
            'qr_code' => $this->qr_code,
            'secret'  => $this->secret,
        ];
    }
}
