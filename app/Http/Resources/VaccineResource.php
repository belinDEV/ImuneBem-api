<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VaccineResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'recommended_age' => $this->recommended_age,
            'doses' => $this->doses,
            'observation' => $this->observation,
            'date_limit' => $this->date_limit,
        ];
    }
}
