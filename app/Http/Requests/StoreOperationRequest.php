<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOperationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'reference_no'   => ['nullable', 'string', 'max:255'],
            'operation_name' => ['required', 'string', 'max:255'],
            'operation_date' => ['required', 'date'],
            'status'         => ['required', 'string', 'max:255'],
            'details'        => ['nullable', 'string'],
        ];
    }
}
