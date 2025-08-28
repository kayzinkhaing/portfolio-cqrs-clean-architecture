<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'position'  => $this->position,
            'company'   => $this->company,
            'testimonial'   => $this->message,
            'is_active' => $this->is_active,

            // full URL to image
            // 'image'     => $this->image
            //                 ? asset('storage/' . $this->image)
            //                 : null,

            'created_at'=> $this->created_at,
            'updated_at'=> $this->updated_at,
        ];
    }
}
