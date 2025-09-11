<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class TestimonialCacheService extends MongoCacheService
{
    public function __construct()
    {
        parent::__construct('testimonials'); // Mongo collection name
    }

    protected function mapDocument($doc): array
    {
        $doc = json_decode(json_encode($doc), true);

        return [
            'id'         => $doc['id'] ?? (string)($doc['_id'] ?? ''),
            'name'       => $doc['name'] ?? null,
            'position'   => $doc['position'] ?? null,
            'company'    => $doc['company'] ?? null,
            'testimonial'=> $doc['testimonial'] ?? null,
            'is_active'  => $doc['is_active'] ?? true,
            'created_at' => $doc['created_at'] ?? null,
            'updated_at' => $doc['updated_at'] ?? null,
        ];
    }
}
