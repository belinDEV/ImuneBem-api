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
        $query = Scheduling::query()->with(['patient', 'employee', 'vaccine', 'status']);

        // Lógica para retornar os agendamentos de acordo com o tipo de usuário
        if ($user->type_user == 0) {
            // Se for admin, retorna todos os agendamentos com os relacionamentos
            $scheduling = $query->get();
        } elseif ($user->type_user == 1) {
            // Se for cuidador, retorna os agendamentos associados a ele com os relacionamentos
            $scheduling = $query->where('employee_id', $userId)->get();
        } else {
            // Se for usuário normal, retorna apenas seu próprio agendamento com os relacionamentos
            $scheduling = $query->where('patient_id', $userId)->get();
        }

        // Retorna a coleção de agendamentos formatada como resource
        return SchedulingResource::collection($scheduling);
    }

    // Validação automática ocorre aqui devido ao SchedulingRequest
    public function store(SchedulingRequest $request)
    {
        // Cria um novo agendamento usando os dados validados
        Scheduling::create($request->validated());
        return $this->responceService->sendMessage('message', 'Agendamento criado com sucesso', 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
