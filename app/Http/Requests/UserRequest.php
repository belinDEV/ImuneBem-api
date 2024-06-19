<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:30',
            'email' => 'required|string|email|max:30|unique:users,email,' . $this->route('user'),
            'cpf' => 'required|string|max:11|unique:users,cpf,' . $this->route('user'),
            'password' => 'required|string|max:45',
            'type_user' => 'required|integer|in:0,1,2',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, mixed>
     */
    public function messages(): array
    {
        return [
            'email.unique' => 'O email já cadastrado.',
            'cpf.unique' => 'O CPF já cadastrado.',
            'name.max' => 'O nome não pode ter mais que 30 caracteres.',
            'email.max' => 'O email não pode ter mais que 30 caracteres.',
            'cpf.max' => 'O CPF não pode ter mais que 11 caracteres.',
            'type_user.in' => 'O tipo de usuário deve ser 0, 1 ou 2.',
        ];
    }
}
