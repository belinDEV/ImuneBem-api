<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Resources\PatientResource;
use App\Models\Patient;


class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patient = Patient::all();
        return PatientResource::collection($patient);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validated();
        $patient = Patient::create($data);
        return new PatientResource($patient);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::where('id', $id)->firstOrFail();
        return new PatientResource($patient);
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
