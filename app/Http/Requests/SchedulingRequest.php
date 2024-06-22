<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SchedulingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'patient_id' => 'required|exists:patients,id',
            'employee_id' => 'required|exists:employees,id',
            'vaccines_id' => 'required|exists:vaccines,id',
            'date' => 'required|date',
            'description' => 'required|string|max:60',
        ];
    }

    public function messages()
    {
        return [
            'patient_id.exists' => 'O paciente selecionado não existe.',
            'employee_id.exists' => 'O funcionário selecionado não existe.',
            'vaccines_id.exists' => 'A vacina selecionada não existe.',
        ];
    }
}
