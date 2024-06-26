<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchedulingRequest;
use App\Http\Resources\SchedulingResource;
use App\Models\Scheduling;
use App\Models\User;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class SchedulingController extends Controller
{
    protected $responseService;

    public function __construct(ResponseService $responseService)
    {
        $this->responseService = $responseService;
    }

    public function index(Request $request)
    {
        // Obtém o ID do usuário a partir do token
        $userId = $request->user()->id;
        // Recupera o usuário
        $user = User::find($userId);

        // Inicializa a variável $query com os relacionamentos necessários
        $query = Scheduling::query()->with(['patient', 'professional', 'vaccines', 'status']);

        // Filtra pelo status, se fornecido
        if ($request->has('status')) {
            $status = $request->query('status');
            $query->where('status_id', $status);
        }

        // Lógica para retornar os agendamentos de acordo com o tipo de usuário
        if ($user->type_user == 0) {
            // Ordena pela data
            $query = $query->orderBy('date', 'asc');
            // Se for admin, retorna todos os agendamentos com os relacionamentos
            $schedulings = $query->get();
        } else {
            //SELECT para listar os agendamentos refernete ao usuario logado
            $schedulings = Scheduling::whereIn('patient_id', function ($query) use ($userId) {
                $query->select('id')
                    ->from('patients')
                    ->where('user_id', $userId)
                    ->orderBy('status_id', 'asc')->orderBy('date', 'asc');
            })->get();
        }

        return SchedulingResource::collection($schedulings);
    }

    // Validação automática ocorre aqui devido ao SchedulingRequest
    public function store(SchedulingRequest $request)
    {
        // Cria um novo agendamento usando os dados validados
        Scheduling::create($request->validated());
        return $this->responseService->sendMessage('message', 'Agendamento criado com sucesso', 200);
    }

    public function show(string $id)
    {
        // Inicializa a variável $query com os relacionamentos necessários
        $query = Scheduling::query()->with(['patient', 'professional', 'vaccines', 'status']);
        $scheduling = $query->where('id', $id)->firstOrFail();
        return new SchedulingResource($scheduling);
    }

    public function update(SchedulingRequest $request, string $id)
    {
        // Obtém o ID do usuário a partir do token
        $userId = $request->user()->id;
        // Recupera o usuário
        $user = User::find($userId);
        if ($user->type_user != 0) {
            return $this->responseService->sendMessage('message', 'Usuário sem permissão para atualizar um agendamento', 200);
        }
        $scheduling = Scheduling::where('id', $id)->firstOrFail();
        $data = $request->validated();
        $scheduling->update($data);
        return $this->responseService->sendMessage('message', 'Agendamento atualizado com sucesso', 200);
    }

    public function destroy(string $id)
    {
    }
}
