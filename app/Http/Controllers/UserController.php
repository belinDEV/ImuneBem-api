<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;


    public function index()
    {
        $user = User::all();
        return UserResource::collection($user);
    }

    public function store(UserRequest $request)
    {
        // Verifica se o usuário autenticado tem tipo 0
        $authenticatedUser = $request->user();
        if ($authenticatedUser->type_user != 0) {
            return response()->json([
                'error' => 'Somente administradores podem criar usuários.'
            ], 403);
        }
        //Pega apenas o que foi validado
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('id', $id)->firstOrFail();
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {

        //Busca o user pelo id
        $user = User::where('id', $id)->firstOrFail();
        //Passa os dados que vão ser atualizados
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'password' => $request->password,
            'type_user' => $request->type_user
        ]);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserRequest $request, string $id)
    {
        $user = Users::find($id);

        $user->delete();

    }
}
