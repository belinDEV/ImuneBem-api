<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
    ];

    public function schedulings()
    {
        return $this->hasMany(Scheduling::class);
    }
}
