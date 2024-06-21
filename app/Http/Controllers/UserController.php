<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\ResponseService;

class UserController extends Controller
{
    protected $responceService;

    public function __construct(ResponseService $responceService)
    {
        $this->responceService = $responceService;
    }

    public function index()
    {
        $user = User::all();
        return UserResource::collection($user);
    }

    public function store(UserRequest $request)
    {
        //Pega apenas o que foi validado
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);
        return new UserResource($user);
    }

    public function show(string $id)
    {
        $user = User::where('id', $id)->firstOrFail();
        return new UserResource($user);
    }

    public function update(UserRequest $request, string $id)
    {
        //Busca o user pelo id
        $user = User::where('id', $id)->firstOrFail();
        //Passa os dados que vão ser atualizados
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'password' => bcrypt($request->password),
            'type_user' => $request->type_user
        ]);
        return new UserResource($user);
    }

    public function destroy(string $id)
    {
        $user = User::where('id', $id)->firstOrFail();
        $user->delete();
        return $this->responceService->sendMessage('message', 'Usuário deletado com sucesso', 200);
    }
}
