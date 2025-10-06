<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePreOperativeChecklistRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'item'           => ['required', 'string', 'max:255'],
            'status'         => ['required', 'string', 'max:255'],
            'date_completed' => ['nullable', 'date'],
            'completed_by'   => ['nullable', 'string', 'max:255'],
            'notes'          => ['nullable', 'string'],
        ];
    }
}
