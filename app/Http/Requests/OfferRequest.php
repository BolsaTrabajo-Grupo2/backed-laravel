<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfferRequest extends FormRequest
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
            'description.required' => 'The description is required.',
            'description.string' => 'The description must be a string.',
            'description.max' => 'The description cannot exceed 200 characters.',

            'duration.required' => 'The duration is required.',
            'duration.string' => 'The duration must be a string.',
            'duration.max' => 'The duration cannot exceed 50 characters.',

            'responsibleName.string' => 'The responsible name must be a string.',
            'responsibleName.max' => 'The responsible name cannot exceed 100 characters.',
        ];
    }

}
