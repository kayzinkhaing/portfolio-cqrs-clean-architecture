<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'sometimes|required|string|max:255',
            'position'  => 'nullable|string|max:255',
            'company'   => 'nullable|string|max:255',
            'testimonial'   => 'sometimes|required|string',
            'is_active' => 'boolean',

           // 'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }
}
