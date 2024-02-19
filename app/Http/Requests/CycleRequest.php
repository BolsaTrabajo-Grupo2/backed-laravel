<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CycleRequest extends FormRequest
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
            'cycle' => 'required|string|max:50',
            'title' => 'nullable|string|max:100',
            'idFamily' => 'required|integer|unsigned',
            'idResponsible' => 'required|integer|unsigned',
            'vliteral' => 'required|string|max:150',
            'cliteral' => 'required|string|max:150',
        ];
    }

    public function messages()
    {
        return [
            'cycle.required' => 'The cycle field is required.',
            'cycle.string' => 'The cycle field must be a string.',
            'cycle.max' => 'The cycle field cannot exceed 50 characters.',

            'title.string' => 'The title field must be a string.',
            'title.max' => 'The title field cannot exceed 100 characters.',

            'idFamily.required' => 'The idFamily field is required.',
            'idFamily.integer' => 'The idFamily field must be an integer.',
            'idFamily.unsigned' => 'The idFamily field must be an unsigned integer.',

            'idResponsible.required' => 'The idResponsible field is required.',
            'idResponsible.integer' => 'The idResponsible field must be an integer.',
            'idResponsible.unsigned' => 'The idResponsible field must be an unsigned integer.',

            'vliteral.required' => 'The vliteral field is required.',
            'vliteral.string' => 'The vliteral field must be a string.',
            'vliteral.max' => 'The vliteral field cannot exceed 150 characters.',

            'cliteral.required' => 'The cliteral field is required.',
            'cliteral.string' => 'The cliteral field must be a string.',
            'cliteral.max' => 'The cliteral field cannot exceed 150 characters.',
        ];
    }

}
