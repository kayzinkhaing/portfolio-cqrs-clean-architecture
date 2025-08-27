<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        $id = $this->route('status') ?? $this->route('id');

        return [
            'name' => 'required|string|max:191',
            'slug' => 'nullable|string|max:191|unique:statuses,slug,' . $id,
        ];
    }
}
