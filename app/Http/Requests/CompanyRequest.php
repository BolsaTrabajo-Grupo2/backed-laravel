<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250',
            'surname' => 'required|string|max:250',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'rol' => 'required',
            'CIF' => 'required|string|size:9',
            'company_name' => 'required|string|max:100',
            'address' => 'required|string|max:250',
            'CP' => 'required|string|size:5',
            'phone' => 'required|string|size:9',
            'web' => 'nullable|string|max:100|url',
        ];
    }
}
