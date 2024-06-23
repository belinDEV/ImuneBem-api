<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\EmailExists;

class PatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:30',
            'age' => 'required|integer|min:0',
            'linked_email' => ['required', 'string', 'email', 'max:60', 'exists:users,email'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais que 30 caracteres.',
            'age.required' => 'A idade é obrigatória.',
            'age.integer' => 'A idade deve ser um número inteiro.',
            'age.min' => 'A idade deve ser um número positivo.',
            'linked_email.required' => 'O email é obrigatório.',
            'linked_email.string' => 'O email deve ser uma string.',
            'linked_email.email' => 'O email deve ser um endereço de email válido.',
            'linked_email.max' => 'O email não pode ter mais que 60 caracteres.',
            'linked_email.exists' => 'O email fornecido não existe.',
        ];
    }
}
