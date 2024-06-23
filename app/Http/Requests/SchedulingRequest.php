<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class SchedulingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'patient_id' => 'required|exists:patients,id',
            'employee_id' => 'exists:employees,id',
            'date' => 'required|date',
            'description' => 'required|string|max:60',
            'type' => 'required|in:0,1',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['employee_id'] = 'required|exists:employees,id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'patient_id.exists' => 'O paciente selecionado não existe.',
            'employee_id.exists' => 'O funcionário selecionado não existe.',
            'employee_id.required' => 'O campo funcionário é obrigatório ao atualizar.',
            'vaccines_id.exists' => 'A vacina selecionada não existe.',
            'type.in' => 'O campo tipo deve ser 0 ou 1.',
        ];
    }

    protected function withValidator(Validator $validator)
    {
        $validator->sometimes('vaccines_id', 'required|exists:vaccines,id', function ($input) {
            return $input->type == 0;
        });
    }
}
