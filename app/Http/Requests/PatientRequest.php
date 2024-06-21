<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'register' => 'required|string|max:20|unique:patients,register,' . $this->route('patient'),
            'age' => 'required|integer|min:0',
            // 'user_id' => 'required|integer|exists:users,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string' => 'O nome deve ser uma string.',
            'name.max' => 'O nome não pode ter mais que 30 caracteres.',

            'register.required' => 'O registro é obrigatório.',
            'register.string' => 'O registro deve ser uma string.',
            'register.max' => 'O registro não pode ter mais que 20 caracteres.',
            'register.unique' => 'O registro já está cadastrado.',

            'age.required' => 'A idade é obrigatória.',
            'age.integer' => 'A idade deve ser um número inteiro.',
            'age.min' => 'A idade deve ser um número positivo.',

            // 'user_id.required' => 'O campo user_id é obrigatório.',
            // 'user_id.integer' => 'O campo user_id deve ser um número inteiro.',
            // 'user_id.exists' => 'O user_id fornecido não existe.',
        ];
    }
}
