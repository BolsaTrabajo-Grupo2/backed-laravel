<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Company;

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
            'CIF' => [
                'required',
                'string',
                'size:9',
                'regex:/^[A-Z]\d{8}$/',
                Rule::unique('companies', 'CIF'),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'company_name' => 'required|string|max:100',
            'address' => 'required|string|max:250',
            'CP' => 'required|string|size:5',
            'phone' => 'required|string|size:9',
            'web' => 'nullable|string|max:100|url',
            'password' => [
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*\d).{8,}$/'
            ],
            'rol' => 'required',
            'aceptar' => 'required'
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

            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El campo email debe ser una dirección de correo electrónico válida.',
            'email.exists' => 'El email proporcionado no existe en nuestra base de datos.',

            'password.required' => 'El campo contraseña es obligatorio.',
            'password.string' => 'El campo contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.',

            'rol.required' => 'El campo rol es obligatorio.',

            'CIF.required' => 'El campo CIF es obligatorio.',
            'CIF.string' => 'El campo CIF debe ser una cadena de texto.',
            'CIF.size' => 'El campo CIF debe tener 9 caracteres.',
            'CIF.regex' => 'El CIF debe tener el formato correcto (una letra seguida de ocho números).',
            'CIF.exists' => 'El CIF proporcionado no existe en nuestra base de datos.',

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

            'aceptar.required' => 'Tienes que aceptar los terminos y condiciones'
        ];
    }
}
