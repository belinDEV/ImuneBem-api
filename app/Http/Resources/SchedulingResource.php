<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchedulingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient_name' => $this->patient->name,
            'employee_name' => $this->employee->name,
            'vaccine_name' => optional($this->vaccine)->name,
            'status' => $this->status->description,
            'date' => $this->date,
            'description' => $this->description,
        ];
    }
}
