<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules(): array
    {
        // dd($this->all());
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status_id' => 'nullable|exists:statuses,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_featured' => 'boolean',

            // Pivot field validation
            'technology_ids' => 'nullable|array',
            'technology_ids.*' => 'exists:technologies,id',
        ];
    }

}
