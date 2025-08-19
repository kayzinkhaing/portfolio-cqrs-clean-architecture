<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user()->id,
            'password' => 'nullable|string|min:6|confirmed',
            'township_id' => 'required|exists:townships,id',
            'ward_id' => 'required|exists:wards,id',
        ];
    }
}

