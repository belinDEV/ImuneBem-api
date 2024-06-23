<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'age' => $this->age,
            'user_id' => $this->user_id,
            'linked_email' => $this->linked_email,
            'created' => Carbon::make($this->created_at)->format('d/m/Y - H:i:s'),
        ];
    }
}
