<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250',
            'surname' => 'required|string|max:250',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'rol' => 'required',
            'CIF' => 'required', 'string', 'size:9',
            'address' => 'required', 'string', 'max:100',
            'phone' => 'required', 'string', 'max:9',
            'web' => 'nullable', 'string', 'max:100', 'url',
        ];
    }
}
