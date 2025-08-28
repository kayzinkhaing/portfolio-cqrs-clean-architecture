<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'skill_category_id' => 'sometimes|required|exists:skill_categories,id',
            'name'              => 'sometimes|required|string|max:255',
            'level'             => 'nullable|integer|min:0|max:100',
            'icon'              => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            // 'description'       => 'nullable|string',
        ];
    }
}
