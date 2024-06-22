<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Models\User;
use App\Services\ResponseService;

class PatientController extends Controller
{
    protected $responceService;

    public function __construct(ResponseService $responceService)
    {
        $this->responceService = $responceService;
    }

    public function index(Request $request)
    {
        // Pega o id do usuario salvo no token
        $userId = $request->attributes->get('user_id');
        // Recupera o usuário
        $user = User::find($userId);
        // Se for admin retorna todos os pacientes
        if ($user->type_user == 0) {
            $patients = Patient::all();
            // Se for cuidador retorna todos os pacientes que estão associados a ele
        } else if ($user->type_user == 1) {
            $patients = Patient::where('user_id', $userId)->get();
            // Se for usuário retorna o próprio cadastro no sistema
        } else {
            $patients = Patient::where('id', $userId)->get();
        }

        return PatientResource::collection($patients);
    }

    public function store(Request $request)
    {
        // Pega o id do usuario salvo no token
        $userId = $request->attributes->get('user_id');
        // Recupera o usuário
        $user = User::find($userId);
        //Verifica se o usuário e do tipo comum
        if ($user->type_user == 2) {
            return $this->responceService->sendMessage('message', 'Usuário sem permição para criar um paciente', 404);
        }
        // Pega os dados validados do request
        $data = $request->all();
        // Adiciona o user_id nos dados do paciente
        $data['user_id'] = $userId;
        // Cria o paciente com os dados atualizados
        Patient::create($data);
        // Retorna o recurso do paciente criado
        return $this->responceService->sendMessage('message', 'Paciente criado com sucesso', 200);;
    }

    public function show(string $id)
    {
        $patient = Patient::where('id', $id)->firstOrFail();
        return new PatientResource($patient);
    }

    public function update(Request $request, string $id)
    {
        $userId = $request->attributes->get('user_id');
        $patient = Patient::where('id', $id)->firstOrFail();
        $patient->update([
            'name' => $request->name,
            'age' => $request->age,
            'register' => $request->register,
            'user_id' => $userId,
        ]);
        return $this->responceService->sendMessage('message', 'Paciente atualizado com sucesso', 200);
    }

    public function destroy(string $id)
    {
        //firstOrFail (ELe retorna um erro 404 caso n encontre o id do patient (Paciente em pt-br))
        $patient = Patient::where('id', $id)->firstOrFail();
        $patient->delete();
        //service que retorna uma mensagem em Json
        return $this->responceService->sendMessage('message', 'Paciente deletado com sucesso', 200);
    }
}
