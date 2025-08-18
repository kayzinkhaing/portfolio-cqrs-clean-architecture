<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TownshipUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $townshipId = $this->route('id'); // get route parameter

        return [
            'name' => 'required|string|max:255|unique:townships,name,' . $townshipId,
        ];
    }
}
