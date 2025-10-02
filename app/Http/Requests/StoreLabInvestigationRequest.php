<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabInvestigationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'test_name' => ['required', 'string', 'max:255'],
            'test_date' => ['required', 'date'],
            'lab' => ['nullable', 'string', 'max:255'],
            'sample_collected_at' => ['nullable', 'date'],
            'expected_date' => ['nullable', 'date'],
            'status' => ['required', 'string', 'max:255'],
        ];
    }
}
