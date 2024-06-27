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
            'professional_id' => 'exists:users,id',
            'date' => 'required|date',
            'description' => 'required|string',
            'type' => 'required|in:0,1',
        ];

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['professional_id'] = 'required|exists:users,id';
            $rules['status_id'] = 'required|exists:statuses,id';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'patient_id.exists' => 'O paciente selecionado não existe.',
            'professional_id.exists' => 'O profissional selecionado não existe.',
            'professional_id.required' => 'O campo profissional é obrigatório ao atualizar.',
            'vaccines_id.exists' => 'A vacina selecionada não existe.',
            'type.in' => 'O campo tipo deve ser 0 ou 1.',
            'status_id.exists' => 'O status selecionado não existe.',
            'status_id.required' => 'O campo status é obrigatório ao atualizar.',
        ];
    }

    protected function withValidator(Validator $validator)
    {
        //Cria uma regra para deixar o codigo da vacina como obrigatorio caso o tipo do agendamento for 0, ou seja solicitaçaõ de vacina
        $validator->sometimes('vaccines_id', 'required|exists:vaccines,id', function ($input) {
            return $input->type == 0;
        });

        //Cria uma regra que verifica se o codigo do usuario é do tipo 0, na hora de inserir o professional_id deve ser selecionado somento os usuarios do tipo 0
        $validator->after(function ($validator) {
            if ($this->input('professional_id')) {
                $professional = \App\Models\User::find($this->input('professional_id'));
                if (!$professional || $professional->type_user !== 0) {
                    $validator->errors()->add('professional_id', 'O profissional selecionado deve ser um usuário com type_user igual a 0.');
                }
            }
        });
    }
}
