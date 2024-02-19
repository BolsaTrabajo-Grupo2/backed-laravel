<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferUpdateBackendRequest extends FormRequest
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
            'responsibleName' => 'string|max:100',
        ];
    }
    public function messages()
    {
        return [
            'description.required' => 'La descripción es obligatoria.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.max' => 'La descripción no puede superar los 200 caracteres.',

            'duration.required' => 'La duración es obligatoria.',
            'duration.string' => 'La duración debe ser una cadena de texto.',
            'duration.max' => 'La duración no puede superar los 50 caracteres.',

            'responsibleName.string' => 'El nombre del responsable debe ser una cadena de texto.',
            'responsibleName.max' => 'El nombre del responsable no puede superar los 100 caracteres.',
        ];
    }

}
