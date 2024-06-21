<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        // Tente encontrar o usuário com o CPF fornecido
        $user = User::where('cpf', $request->cpf)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Dados inválidos'
            ], Response::HTTP_UNAUTHORIZED);
        }

        // Deleta todos os tokens antigos
        $user->tokens()->delete();
        // Gera um token com informações adicionais (claims)
        $token = $user->createToken(
            'ImuneBem',
            ['*'],
            now()->addHours(2),
            ['user_id' => $user->id, 'type_user' => $user->type_user]
        );
        return response()->json([
            'token' => $token->plainTextToken,
            'user' => new UserResource($user),
        ], 200);
    }
}
