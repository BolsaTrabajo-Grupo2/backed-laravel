<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'name' => 'required|string|min:5',
            'surname' => 'required|string|min:5',
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'rol' => 'required',
            'idUser' => 'required|integer|unsigned',
            'address' => 'required|string|max:100',
            'CVlink' => 'required|string|max:75',
            'accept' => 'required|boolean',
        ];
    }
}