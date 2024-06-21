<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $responceService;

    public function __construct(ResponseService $responceService)
    {
        $this->responceService = $responceService;
    }
    public function index()
    {
        $employee = Employee::all();
        return EmployeeResource::collection($employee);
    }

    public function store(Request $request)
    {
        // Pega o id do usuario salvo no token
        $userId = $request->attributes->get('user_id');
        // Pega os dados validados do request
        $data = $request->all();
        // Adiciona o user_id nos dados do funcionario
        $data['user_id'] = $userId;
        // Cria o funcionario com os dados atualizados
        $employee = Employee::create($data);
        // Retorna o recurso do funcionario criado
        return new EmployeeResource($employee);
    }

    public function show(string $id)
    {
        $employee = Employee::where('id', $id)->firstOrFail();
        return new EmployeeResource($employee);
    }

    public function update(Request $request, string $id)
    {
        $userId = $request->attributes->get('user_id');
        $employee = Employee::where('id', $id)->firstOrFail();
        $employee->update([
            'name' => $request->name,
            'register' => $request->register,
            'user_id' => $userId,
        ]);
        return $this->responceService->sendMessage('message', 'Funcionário atualizado com sucesso', 200);
    }

    public function destroy(string $id)
    {
        $employee = Employee::where('id',$id)->firstOrFail();
        $employee->delete();
        return $this->responceService->sendMessage('message', 'Funcionário deletado com sucesso', 200);
    }
}
