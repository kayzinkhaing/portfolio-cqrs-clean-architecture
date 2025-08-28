<?php

namespace App\Repositories;

use Illuminate\Http\UploadedFile;

class TestimonialRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(modelName: 'Testimonial');
    }

    public function createWithRelations(array $data)
    {
        // handle image upload
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('testimonials', 'public');
        }

        return parent::create($data);
    }

    public function updateWithRelations(int $id, array $data)
    {
        // handle image upload
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $data['image']->store('testimonials', 'public');
        }

        return parent::update($id, $data);
    }
}
