<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function Auth(Request $request)
    {

        $user = User::where('cpf', $request->cpf)->firstOrFail();
        //Deleta todos os tokens antigos
        $user->tokens()->delete();
        // Gera um token com informações adicionais (claims)
        $token = $user->createToken($request->device_name, ['id' => $user->id, 'type_user' => $user->type]);
        return response()->json([
            'token' => $token->plainTextToken,
            'user' => new UserResource($user),
        ], 200);
    }
}
