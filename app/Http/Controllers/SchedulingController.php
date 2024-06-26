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

    protected $responceService;

    public function __construct(ResponseService $responceService)
    {
        $this->responceService = $responceService;
    }

    public function index(Request $request)
    {
        // Obtém o ID do usuário a partir do token
        $userId = $request->user()->id;
        // Recupera o usuário
        $user = User::find($userId);

        // Inicializa a variável $query com os relacionamentos necessários
        $query = Scheduling::query()->with(['patient', 'employee', 'vaccines', 'status']);

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
            $scheduling = $query->get();
        } elseif ($user->type_user == 1) {
            // Ordena pelo status e pela data
            $query = $query->orderBy('status_id', 'asc')->orderBy('date', 'asc');
            // Se for cuidador, retorna os agendamentos associados a ele com os relacionamentos
            $scheduling = $query->where('employee_id', $userId)->get();
        } else {
            // Ordena pelo status e pela data
            $query = $query->orderBy('status_id', 'asc')->orderBy('date', 'asc');
            // Se for usuário normal, retorna apenas seu próprio agendamento com os relacionamentos
            $scheduling = $query->where('patient_id', $userId)->get();
        }
        return SchedulingResource::collection($scheduling);
    }


    // Validação automática ocorre aqui devido ao SchedulingRequest
    public function store(SchedulingRequest $request)
    {
        // Cria um novo agendamento usando os dados validados
        Scheduling::create($request->validated());
        return $this->responceService->sendMessage('message', 'Agendamento criado com sucesso', 200);
    }

    public function show(string $id)
    {
        // Inicializa a variável $query com os relacionamentos necessários
        $query = Scheduling::query()->with(['patient', 'employee', 'vaccines', 'status']);
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
            return $this->responceService->sendMessage('message', 'Usúario sem permição para atualizar um agendamento', 200);
        }
        $scheduling = Scheduling::where('id', $id)->firstOrFail();
        $data = $request->validated();
        $scheduling->update($data);
        return $this->responceService->sendMessage('message', 'Agendamento atualizado com sucesso', 200);
    }

    public function destroy(string $id)
    {
    }
}
