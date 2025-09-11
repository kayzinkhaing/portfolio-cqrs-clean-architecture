<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * You can implement your auth logic here (e.g., admin only).
     */
    public function authorize(): bool
    {
        return true; // Change if you need authorization checks
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'is_read' => ['required', 'boolean'],
        ];
    }

    /**
     * Customize error messages (optional)
     */
    public function messages(): array
    {
        return [
            'is_read.required' => 'The read status is required.',
            'is_read.boolean' => 'The read status must be true or false.',
        ];
    }
}
