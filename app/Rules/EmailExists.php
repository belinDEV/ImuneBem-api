<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class EmailExists implements Rule
{
    public function __construct()
    {
        //
    }

    public function passes($attribute, $value)
    {
        return DB::table('users')->where('email', $value)->exists();
    }

    public function message()
    {
        return 'O email fornecido não existe.';
    }
}
