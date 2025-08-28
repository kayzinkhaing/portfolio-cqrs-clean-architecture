<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // change if you need auth checks
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'position'  => 'nullable|string|max:255',
            'company'   => 'nullable|string|max:255',
            'testimonial'   => 'required|string',
            'is_active' => 'boolean',

            // image upload validation
            //'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }
}
