<?php

namespace App\Http\Controllers;

use App\Models\Vaccine;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index()
    {
        $totalVaccines = Vaccine::sum('id');
        return response()->json([
            'total_vaccines' => $totalVaccines,
        ]);
    }
}
