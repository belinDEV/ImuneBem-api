<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheduling extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'professional_id',
        'vaccines_id',
        'status_id',
        'date',
        'description',
        'type'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Relacionamento com os usuarios
    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function vaccines()
    {
        return $this->belongsTo(Vaccine::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
