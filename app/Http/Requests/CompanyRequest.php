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
            'CIF' => 'required', 'string', 'max:9',
            'idUser' => 'required', 'integer', 'exists:users,id',
            'address' => 'required', 'string', 'max:100',
            'phone' => 'required', 'string', 'max:9',
            'web' => 'nullable', 'string', 'max:100', 'url',
        ];
    }
}
