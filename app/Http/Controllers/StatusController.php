<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index()
    {
        $status = Status::all();
        return $status;
    }


    public function store(Request $request)
    {
        $data = $request->all();
        $status = Status::create($data);
        return $status;
    }
}
