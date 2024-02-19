<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentBackendRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
            ],
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
            'rol' => 'required',
            'address' => 'required|string|max:100',
            'CVLink' => 'string|max:75',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.string' => 'The name field must be a string.',
            'name.max' => 'The name field cannot exceed 250 characters.',

            'surname.required' => 'The surname field is required.',
            'surname.string' => 'The surname field must be a string.',
            'surname.max' => 'The surname field cannot exceed 250 characters.',

            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',

            'password.nullable' => 'The password must be a string.',
            'password.string' => 'The password field must be a string.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.regex' => 'The password must contain at least one uppercase letter and one digit.',

            'confirmPassword.required_with' => 'The confirmation password field is required when a password is present.',
            'confirmPassword.same' => 'The confirmation password and password must match.',

            'address.required' => 'The address field is required.',
            'address.string' => 'The address field must be a string.',
            'address.max' => 'The address field cannot exceed 100 characters.',

            'CVLink.string' => 'The CVLink field must be a string.',
            'CVLink.max' => 'The CVLink field cannot exceed 75 characters.',
        ];
    }
}
