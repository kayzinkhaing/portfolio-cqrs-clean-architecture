<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTechnologyRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:technologies,slug,' . $this->route('id'),
            'icon' => 'nullable|string|max:255',
            'meta' => 'nullable|array',
        ];
    }
}
