<?php

namespace App\Http\Controllers;

use App\Models\Scheduling;
use App\Models\Vaccine;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function index()
    {
        $totalVaccines = Vaccine::count('id');

        $schedolingPendents = Scheduling::where('status_id', 1);
        $pendents = $schedolingPendents->count('id');

        $schedolingAceppts = Scheduling::where('status_id', 2);
        $aceppts = $schedolingAceppts->count('id');

        $schedolingFinal = Scheduling::where('status_id', 3);
        $final = $schedolingFinal->count('id');

        return response()->json([
            'total_vaccines' => $totalVaccines,
            'schedoling_pendents' => $pendents,
            'schedoling_aceppts' => $aceppts,
            'schedoling_final' => $final,
        ]);
    }
}
