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

    public function getItem($tipo_documento, $documento)
    {

        $response = new \stdClass();

        $persona = Persona::where([
            ['tipo_documento', $tipo_documento],
            ['documento', $documento]
        ])->get()->last();

        $response->success = true;
        $response->data = $persona;

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $response = new \stdClass();
        $persona = new Persona();

        $existe = Persona::where([
            ['tipo_documento', $request->tipo_documento],
            ['documento', $request->documento]
        ])->get()->last();

        if ($existe != null) {
            $response->verificacion = 'EXISTE';
        } else {

            $persona->tipo_documento = $request->tipo_documento;
            $persona->documento = $request->documento;
            $persona->nombres = mb_strtoupper($request->nombres);
            $persona->apellidos = mb_strtoupper($request->apellidos);
            $persona->fecha_nacimiento = $request->fecha_nacimiento;
            $persona->lugar_vivienda = mb_strtoupper($request->lugar_vivienda);
            $persona->pais = $request->pais;

            $persona->save();
            $id = $persona->id;

            $año = substr($request->fecha_nacimiento, 0, 4);
            $codigo =  $año . (str_pad(strval(intval($id)), 4, "0", STR_PAD_LEFT));
            $persona->codigo = $codigo;
            Persona::where('id', $id)->update(['codigo' => $codigo]);

            $response->verificacion = null;
        }

        $response->success = true;
        $response->data = $persona;

        return response()->json($response, 200);
    }

    public function updatePut(Request $request, $id)
    {
        $response = new \stdClass();

        $existe = Persona::where([
            ['id', '<>', $id],
            ['tipo_documento', $request->tipo_documento],
            ['documento', $request->documento],
        ])->get()->last();

        if ($existe != null) {
            $response->verificacion = 'EXISTE';
        } else {
            $persona = Persona::find($id);
            $persona->tipo_documento = $request->tipo_documento;
            $persona->documento = $request->documento;
            $persona->nombres = mb_strtoupper($request->nombres);
            $persona->apellidos = mb_strtoupper($request->apellidos);
            $persona->fecha_nacimiento = $request->fecha_nacimiento;
            $persona->lugar_vivienda = mb_strtoupper($request->lugar_vivienda);
            $persona->pais = $request->pais;

            $persona->save();

            $año = substr($request->fecha_nacimiento, 0, 4);
            $codigo =  $año . (str_pad(strval(intval($id)), 4, "0", STR_PAD_LEFT));
            $persona->codigo = $codigo;
            Persona::where('id', $id)->update(['codigo' => $codigo]);

            $response->verificacion = null;
        }


        $response->success = true;
        $response->data = $persona;

        return response()->json($response, 200);
    }


    public function delete($id)
    {
        $response = new \stdClass();

        $persona = Persona::find($id);
        $persona->delete();

        $response->success = true;

        return response()->json($response, 200);
    }
}
