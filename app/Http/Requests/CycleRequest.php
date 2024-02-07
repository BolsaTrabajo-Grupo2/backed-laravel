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
}
