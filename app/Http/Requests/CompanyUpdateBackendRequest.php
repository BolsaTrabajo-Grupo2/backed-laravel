<?php

namespace App\Http\Requests;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyUpdateBackendRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = $this->route('company');
        $companyBD = Company::where('id_user', $companyId)->firstOrFail();
        return [
            'name' => 'required|string|max:250',
            'surname' => 'required|string|max:250',
            'CIF' => [
                'required',
                'string',
                'size:9',
                Rule::unique('companies', 'CIF')->ignore($companyBD)],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($companyBD->user)
            ],
            'company_name' => 'required|string|max:100',
            'address' => 'required|string|max:250',
            'CP' => 'required|string|size:5',
            'phone' => 'required|string|size:9',
            'web' => 'nullable|string|max:100|url',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*\d).{8,}$/'
            ],
            'confirmPassword' => [
                'required_with:password',
                'same:password',
            ],
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
            'CIF.unique' => 'El CIF ya está en uso.',

            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El campo email debe ser una dirección de correo electrónico válida.',
            'email.unique' => 'El email ya está en uso.',

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

            'password.nullable' => 'El campo contraseña debe ser una cadena de texto o nulo.',
            'password.string' => 'El campo contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos una letra mayúscula y un dígito.',

            'confirmPassword.required_with' => 'El campo repetir contraseña es obligatorio cuando se proporciona una contraseña.',
            'confirmPassword.same' => 'La confirmación de la contraseña no coincide con la contraseña proporcionada.',
        ];
    }

}
