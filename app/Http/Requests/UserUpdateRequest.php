<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        $userId = $this->route('responsible');
        $user = User::find($userId);

        return [
            'name' => 'required|string|max:250',
            'surname' => 'required|string|max:250',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user)
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
            'name.required' => 'El nombre es obligatorio',
            'surname.required' => 'El apellido es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email no es válido',
            'email.unique' => 'El email ya está registrado',
            'password.min' => 'La contraseña debe tener al menos :min caracteres',
            'password.regex' => 'La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.',
            'confirmPassword.required_with' => 'El campo repetir contraseña es obligatorio cuando se proporciona una contraseña.',
            'confirmPassword.same' => 'La confirmación de la contraseña no coincide con la contraseña proporcionada.',
        ];
    }
}
