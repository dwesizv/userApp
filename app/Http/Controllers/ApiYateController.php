<?php

namespace App\Http\Controllers;

use App\Models\Yate;
use Illuminate\Http\Request;

class ApiYateController extends Controller {

    function __construct() {
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
        $this->middleware('user')->only(['update', 'destroy']);
    }
    
    public function index() {
        return response()->json(['yates' => Yate::all()]);
    }

    public function store(Request $request) {
        try {
            $yate = new Yate($request->all());
            $yate->save();
            return response()->json(['yate' => $yate], 201);
        } catch(\Exception $e) {
            return response()->json(['yate' => null], 418);
        }
    }

    public function show($id) {
        $yate = Yate::find($id);
        return response()->json(['yate' => $yate], 200);
    }

    public function update(Request $request, $id) {
        $yate = Yate::find($id);
        try {
            $yate->update($request->all());
            return response()->json(['yate' => $yate], 200);
        } catch(\Exception $e) {
            return response()->json(['yate' => $yate], 418);
        }
    }

    public function destroy($id) {
        $result = Yate::destroy($id);
        return response()->json(['result' => $result], 200);
    }
}