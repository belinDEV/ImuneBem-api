<?php

namespace App\Http\Controllers;

use App\Http\Resources\VaccineResource;
use App\Models\User;
use App\Models\Vaccine;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class VaccineController extends Controller
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
            $vaccines = Vaccine::all();
            // Se for cuidador retorna todos os pacientes que estão associados a ele
        } else if ($user->type_user == 1) {
            $vaccines = Vaccine::where('user_id', $userId)->get();
            // Se for usuário retorna o próprio cadastro no sistema
        } else {
            $vaccines = Vaccine::where('id', $userId)->get();
        }
        return VaccineResource::collection($vaccines);
    }

    public function store(Request $request)
    {
        // Pega o id do usuario salvo no token
        $userId = $request->attributes->get('user_id');
        // Pega os dados validados do request
        $data = $request->all();
        // Adiciona o user_id nos dados do funcionario
        $data['user_id'] = $userId;
        Vaccine::create($data);
        return $this->responceService->sendMessage('message', 'Vacina criada com sucesso', 200);
    }

    public function show(string $id)
    {
        $vaccine = Vaccine::findOrFail($id);
        return new VaccineResource($vaccine);
    }

    public function update(Request $request, string $id)
    {
        $userId = $request->attributes->get('user_id');
        $vaccine = Vaccine::findOrFail($id);
        $vaccine->update([
            'name' => $request->name,
            'recommended_age' => $request->recommended_age,
            'doses' => $request->doses,
            'user_id' => $userId,
            'observation' => $request->observation,
            'date_limit' => $request->date_limit,
        ]);
        return $this->responceService->sendMessage('message', 'Vacina atualizada com sucesso', 200);
    }

    public function destroy(string $id)
    {
        $vaccine = Vaccine::where('id', $id)->firstOrFail();
        $vaccine->delete();
        //service que retorna uma mensagem em Json
        return $this->responceService->sendMessage('message', 'Vacina deletado com sucesso', 200);
    }
}
