<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250',
            'surname' => 'required|string|max:250',
            'address' => 'required|string|max:100',
            'CVLink' => 'nullable|string|max:75|url',
            'observations' => 'nullable|string|max:250',
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
    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede superar los 250 caracteres.',

            'surname.required' => 'Los apellidos son obligatorios.',
            'surname.string' => 'Los apellidos deben ser una cadena de texto.',
            'surname.max' => 'Los apellidos no pueden superar los 250 caracteres.',

            'address.required' => 'La dirección es obligatoria.',
            'address.string' => 'La dirección debe ser una cadena de texto.',
            'address.max' => 'La dirección no puede superar los 100 caracteres.',

            'CVLink.string' => 'El enlace del curriculum debe ser una cadena de texto.',
            'CVLink.max' => 'El enlace del curriculum no puede superar los 75 caracteres.',
            'CVLink.url' => 'El enlace del curriculum debe ser una URL válida.',

            'observations.string' => 'Las observaciones deben ser una cadena de texto.',
            'observations.max' => 'Las observaciones no pueden superar los 250 caracteres.',

            'password.nullable' => 'La contraseña debe ser una cadena de texto.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.regex' => 'La contraseña debe contener al menos una letra mayúscula y un número.',

            'confirmPassword.required_with' => 'La confirmación de la contraseña es obligatoria cuando se proporciona una contraseña.',
            'confirmPassword.same' => 'La confirmación de la contraseña no coincide con la contraseña.',
        ];
    }

}
