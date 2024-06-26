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
            'professional_name' => optional($this->professional)->name,
            'vaccine_name' => optional($this->vaccines)->name,
            'status' => $this->status->description,
            'date' => $this->date,
            'description' => $this->description,
            'type' => $this->type,
        ];
    }
}
