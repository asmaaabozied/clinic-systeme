<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOpdPatientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => ['required', 'string'],
            'second_name' => ['nullable', 'string'],
            'third_name' => ['nullable', 'string'],
            'family_name' => ['nullable', 'string'],
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'dob_hijri' => ['required', 'string'],
            'date_of_birth' => ['required', 'date'],
            'nationality' => ['required', 'string'],
            'document_type' => ['required', 'string'],
            'document_id' => $this->documentIdRules(),
            'phone' => ['required', 'unique:patients,phone'],
            'marital_status' => ['sometimes', 'string', 'in:single,married,divorced,widowed,Single,Married,Divorced,Widowed'],
            'gender' => ['required', 'string', 'in:male,female,Male,Female'],
            'blood_group' => ['sometimes', 'string', 'in:A+,A-,B+,B-,O+,O-,AB+,AB-'],
            'preferred_language' => ['sometimes', 'string'],
            'remarks' => ['sometimes', 'nullable', 'string'],
            'addresses' => ['sometimes', 'array'],
            'addresses.*.street' => ['required', 'string'],
            'addresses.*.city' => ['required', 'string'],
            'addresses.*.postal_code' => ['nullable', 'string'],
        ];
    }

    private function documentIdRules(): array
    {
        $rules = ['required', 'string'];
        $type = $this->input('document_type');
        if ($type === 'National Card') {
            $rules[] = 'regex:/^1\d{9}$/';
        } elseif ($type === 'Iqama') {
            $rules[] = 'regex:/^2\d{9}$/';
        }
        return $rules;
    }
}
