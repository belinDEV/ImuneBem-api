<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\PatientResource;
use App\Models\Patient;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        // Tente encontrar o usuário com o CPF fornecido
        $user = User::where('cpf', $request->cpf)->first();

        if ($user) {
            // Deleta todos os tokens antigos
            $user->tokens()->delete();
            // Gera um token com informações adicionais (claims)
            $token = $user->createToken($request->device_name, ['id' => $user->id, 'type_user' => $user->type]);
            return response()->json([
                'token' => $token->plainTextToken,
                'user' => new UserResource($user),
            ], 200);
        }

        $patient = Patient::where('name', $request->name)->firstOrFail();
        $patient->tokens()->delete();
        $token = $patient->createToken($request->device_name, ['id' => $patient->id]);
        return response()->json([
            'token' => $token->plainTextToken,
            'patient' => new PatientResource($patient),
        ], 200);
    }
}
