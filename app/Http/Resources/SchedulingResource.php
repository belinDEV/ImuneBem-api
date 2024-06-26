<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchedulingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'patient_name' => $this->patient->name,
            'professional_id' => optional($this->professional)->id,
            'professional_name' => optional($this->professional)->name,
            'vaccine_name' => optional($this->vaccines)->name,
            'status_id' => $this->status_id,
            'status_name' => $this->status->description,
            'date' => $this->date,
            'description' => $this->description,
            'type' => $this->type,
        ];
    }
}
