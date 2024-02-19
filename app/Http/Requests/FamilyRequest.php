<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FamilyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cliteral' => 'required|string|max:100',
            'vliteral' => 'required|string|max:100',
            'depcurt' => 'required|string|max:30',
        ];
    }
    public function messages()
    {
        return [
            'cliteral.required' => 'The cliteral field is required.',
            'cliteral.string' => 'The cliteral field must be a string.',
            'cliteral.max' => 'The cliteral field cannot exceed 100 characters.',

            'vliteral.required' => 'The vliteral field is required.',
            'vliteral.string' => 'The vliteral field must be a string.',
            'vliteral.max' => 'The vliteral field cannot exceed 100 characters.',

            'depcurt.required' => 'The depcurt field is required.',
            'depcurt.string' => 'The depcurt field must be a string.',
            'depcurt.max' => 'The depcurt field cannot exceed 30 characters.',
        ];
    }

}
