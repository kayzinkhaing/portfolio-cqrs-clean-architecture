<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    public function toArray($request): array
    {
        $user = $this->user;

        $userData = null;
        if ($user) {
            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'township' => $user->township ? [
                    'id' => $user->township->id,
                    'name' => $user->township->name,
                ] : null,
                'ward' => $user->ward ? [
                    'id' => $user->ward->id,
                    'name' => $user->ward->name,
                    'township_id' => $user->ward->township_id,
                ] : null,
            ];
        }

        return [
            'id' => $this->id,
            'user' => $userData,
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
