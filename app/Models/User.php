<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'type_user'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function vaccines()
    {
        return $this->hasMany(Vaccine::class);
    }
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
    protected static function booted()
    {
        //Cria um Cuidador/Familiar automaticamente sempre que um usario do tipo 1 for criado
        static::created(function ($user) {
            if ($user->type_user === 1) {
                \App\Models\Employee::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'description' => 'Cuidador/Familiar gerado automaticamente',
                ]);
            }
        });
    }
}
