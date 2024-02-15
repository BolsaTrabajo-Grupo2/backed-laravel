<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Company;


class OfferBackendRequest extends FormRequest
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
            'description' => 'required|string|max:200',
            'duration' => 'required|string|max:50',
            'responsible_name' => 'required|string|max:100',
            'inscription_method' => 'nullable|boolean',
            'observations' => 'nullable|string|max:250',
            'CIF' => [
                'required',
                'string',
                'size:9',
                'regex:/^[A-Z]\d{8}$/',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'description.required' => 'La descripción es obligatoria.',
            'description.string' => 'La descripción debe ser un texto.',
            'description.max' => 'La descripción no puede exceder los :max caracteres.',

            'duration.required' => 'La duración es obligatoria.',
            'duration.string' => 'La duración debe ser un texto.',
            'duration.max' => 'La duración no puede exceder los :max caracteres.',

            'responsible_name.required' => 'El nombre del responsable es obligatorio.',
            'responsible_name.string' => 'El nombre del responsable debe ser un texto.',
            'responsible_name.max' => 'El nombre del responsable no puede exceder los :max caracteres.',

            'inscription_method.boolean' => 'El método de inscripción debe ser un valor booleano.',

            'observations.string' => 'Las observaciones deben ser un texto.',
            'observations.max' => 'Las observaciones no pueden exceder los :max caracteres.',

            'CIF.required' => 'El CIF es obligatorio.',
            'CIF.string' => 'El CIF debe ser un texto.',
            'CIF.size' => 'El CIF debe tener exactamente :size caracteres.',
            'CIF.regex' => 'El CIF debe tener el formato correcto (una letra seguida de ocho números).',
            'CIF.exists' => 'El CIF proporcionado no existe en nuestra base de datos.',
        ];
    }
}
