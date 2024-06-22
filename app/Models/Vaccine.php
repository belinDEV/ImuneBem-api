<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'recommended_age',
        'doses',
        'observation',
        'date_limit',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schedulings()
    {
        return $this->hasMany(Scheduling::class);
    }
}
