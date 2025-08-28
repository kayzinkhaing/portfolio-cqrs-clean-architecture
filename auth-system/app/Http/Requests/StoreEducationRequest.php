<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEducationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // You can apply policies if needed
    }

    public function rules(): array
    {
        return [
            'institution' => 'required|string|max:255',
            'degree'      => 'required|string|max:255',
            'location'    => 'nullable|string|max:255',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'is_current'  => 'boolean',
            'details'     => 'nullable|string',
        ];
    }
}
