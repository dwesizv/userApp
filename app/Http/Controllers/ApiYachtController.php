<?php

namespace App\Http\Controllers;

use App\Models\Yate;
use Illuminate\Http\Request;

class ApiYachtController extends Controller {

    //api       -> csrf no existe, tampoco existen las sesiones
    //recurso   -> no se usan los métodos create, edit
    //respuesta -> json, y código de respuesta http
    //peticion  -> content-type : json, accept: json
    //cuerpo    -> json (get no puede tener cuerpo)
    //model     -> no es conveniente que la conversión al objeto la realice laravel,
    //             debido a que si falla, se produce un redirect
    //redirect  -> no se puede hacer
    
    //https://laravel.com/docs/9.x/passport

    function __construct() {
        $this->middleware('auth:api')->except(['show']);
    }

    public function index() {
        return response()->json(['yates' => Yate::all()]);
    }

    public function store(Request $request) {
        try {
            $yate = Yate::create($request->all());
            $result = $yate->id;
        } catch(\Exception $e) {
            $result = 0;
        }
        return response()->json(['result' => $result]);
    }

    public function show($id) {
        $yate = Yate::find($id);
        return response()->json(['yate' => $yate]);
    }

    public function update(Request $request, $id) {
        $yate = Yate::find($id);
        $result = false;
        if($yate) {
            try {
                $result = $yate->update($request->all());
            } catch(\Exception $e) {
            }
        }
        return response()->json(['result' => $result]);
    }

    public function destroy($id) {
        $yate = Yate::find($id);
        $result = false;
        if($yate) {
            try {
                $result = $yate->delete();
            } catch(\Exception $e) {
            }
        }
        return response()->json(['result' => $result]);
    }
}