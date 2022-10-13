<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;

class PersonaController extends Controller
{
    public function getAll()
    {
        $response = new \stdClass();

        $personas = Persona::all();

        $response->success = true;
        $response->data = $personas;

        return response()->json($response, 200);
    }

    public function getItem($id)
    {
        $response = new \stdClass();

        $persona = Persona::find($id);

        $response->success = true;
        $response->data = $persona;

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $response = new \stdClass();

        $sector = new Persona();
        $sector->codigo = mb_strtoupper($request->codigo);
        $sector->dni = $request->dni;
        $sector->nombres = mb_strtoupper($request->nombres);
        $sector->apellidos = mb_strtoupper($request->apellidos);
        $sector->fecha_nacimiento = $request->fecha_nacimiento;
        $sector->lugar_vivienda = mb_strtoupper($request->lugar_vivienda);
        $sector->pais = $request->pais;

        $sector->save();

        $response->success = true;
        $response->data = $sector;

        return response()->json($response, 200);
    }

    public function updatePut(Request $request, $id)
    {
        $response = new \stdClass();
        $sector = Persona::find($id);
        $sector->codigo = mb_strtoupper($request->codigo);
        $sector->dni = $request->dni;
        $sector->nombres = mb_strtoupper($request->nombres);
        $sector->apellidos = mb_strtoupper($request->apellidos);
        $sector->fecha_nacimiento = $request->fecha_nacimiento;
        $sector->lugar_vivienda = mb_strtoupper($request->lugar_vivienda);
        $sector->pais = $request->pais;

        $sector->save();

        $response->success = true;
        $response->data = $sector;

        return response()->json($response, 200);
    }


    public function delete($id)
    {
        $response = new \stdClass();

        $sector = Persona::find($id);
        $sector->delete();

        $response->success = true;

        return response()->json($response, 200);
    }
}
