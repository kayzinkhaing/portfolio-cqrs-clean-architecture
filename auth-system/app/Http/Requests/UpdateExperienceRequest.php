<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExperienceRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return (new StoreExperienceRequest())->rules();
    }
}
