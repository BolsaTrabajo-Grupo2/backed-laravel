<?php

namespace App\Http\Requests;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class CompanyUpdateRequest extends FormRequest
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
            'CIF' => 'required|string|size:9',
            'company_name' => 'required|string|max:100',
            'address' => 'required|string|max:250',
            'CP' => 'required|string|size:5',
            'phone' => 'required|string|size:9',
            'web' => 'nullable|string|max:250|url',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El campo nombre es obligatorio.',
            'name.string' => 'El campo nombre debe ser una cadena de texto.',
            'name.max' => 'El campo nombre no puede superar los 250 caracteres.',

            'surname.required' => 'El campo apellidos es obligatorio.',
            'surname.string' => 'El campo apellidos debe ser una cadena de texto.',
            'surname.max' => 'El campo apellidos no puede superar los 250 caracteres.',

            'CIF.required' => 'El campo CIF es obligatorio.',
            'CIF.string' => 'El campo CIF debe ser una cadena de texto.',
            'CIF.size' => 'El campo CIF debe tener 9 caracteres.',

            'company_name.required' => 'El campo nombre de la empresa es obligatorio.',
            'company_name.string' => 'El campo nombre de la empresa debe ser una cadena de texto.',
            'company_name.max' => 'El campo nombre de la empresa no puede superar los 100 caracteres.',

            'address.required' => 'El campo dirección es obligatorio.',
            'address.string' => 'El campo dirección debe ser una cadena de texto.',
            'address.max' => 'El campo dirección no puede superar los 250 caracteres.',

            'CP.required' => 'El campo CP es obligatorio.',
            'CP.string' => 'El campo CP debe ser una cadena de texto.',
            'CP.size' => 'El campo CP debe tener 5 caracteres.',

            'phone.required' => 'El campo teléfono es obligatorio.',
            'phone.string' => 'El campo teléfono debe ser una cadena de texto.',
            'phone.size' => 'El campo teléfono debe tener 9 caracteres.',

            'web.nullable' => 'El campo web debe ser una cadena de texto o nulo.',
            'web.string' => 'El campo web debe ser una cadena de texto.',
            'web.max' => 'El campo web no puede superar los 100 caracteres.',
            'web.url' => 'El campo web debe ser una URL válida.',

        ];
    }
}
