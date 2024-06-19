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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
