<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Http\Requests\GuardarPacienteRequest;
use App\Http\Requests\ActualizarPacienteRequest;
use App\Http\Resources\PacienteResource;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return PacienteResource::collection(Paciente::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GuardarPacienteRequest $request)
    {
        /*Paciente::create($request->all());

        return response()->json([
            'res' => true,
            'msg' => 'Paciente Guardado Correctamente'
        ],200);*/

        return (new PacienteResource(Paciente::create($request->all())))->additional(['msg'=>'Paciente Guardado Correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Paciente $paciente)
    {
        /*return response()->json([
            'res' => true,
            'paciente' => $paciente
        ],200);*/


        return new PacienteResource($paciente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActualizarPacienteRequest $request, Paciente $paciente)
    {
       

        /*
        return response()->json([
            'res'=>true,
            'mensaje'=>'Paciente actualizado correctamente'
        ],200);*/
        $paciente->update($request->all());
        return (new PacienteResource($paciente))->additional(['msm'=>'paciente actualizado']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Paciente $paciente)
    {
        

        /*return response()->json([

            'res' => true,
            'mensaje' => 'Paciente eliminado correctamente'
        ]);*/
        $paciente->delete();
        return new PacienteResource($paciente);
    }
}
