<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'slug'        => $this->slug,
            'description' => $this->description,

            // Eager-loaded status
            'status' => $this->whenLoaded('status', function () {
                return [
                    'id'   => $this->status->id,
                    'name' => $this->status->name,
                ];
            }),

            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date,
            'is_featured' => $this->is_featured,

            // Eager-loaded technologies
            'technologies' => \App\Http\Resources\TechnologyResource::collection(
                $this->whenLoaded('technologies')
            ),

            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
            'deleted_at' => $this->deleted_at,  
        ];
    }
}
