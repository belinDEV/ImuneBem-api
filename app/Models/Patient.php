<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Patient extends Model

{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'linked_email',
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
