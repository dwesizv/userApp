<?php

namespace App\Http\Controllers;

use App\Models\Yate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YateController extends Controller {

    private function getOrderBy() {
        return [
            'id'            => 'c1',
            'nombre'        => 'c2',
            'idtipo'        => 'c3',
            'iduser'        => 'c4',
            'idastillero'   => 'c5',
            'descripcion'   => 'c6',
            'precio'        => 'c7',
        ];
    }

    private function getOrderType() {
        return [
            'asc'  => 't1',
            'desc' => 't2',
        ];
    }

    function index(Request $request) {
        $orderby = $this->orderBy($request->input('orderby'));
        $ordertype = $this->orderType($request->input('ordertype'));
        $yates = new Yate();
        $yates = $yates->orderBy($orderby, $ordertype);
        $yates = $yates->orderBy('nombre', 'asc')->get();
        return view('yate.index', ['orderby'    => $this->getOrderBy(),
                                    'ordertype' => $this->getOrderType(),
                                    'yates'     => $yates]);
    }

    private function order($orderArray, $order, $default) {
        $value = array_search($order, $orderArray);
        if(!$value) {
            return $default;
        }
        return $value;
    }

    private function orderBy($order) {
        return $this->order($this->getOrderBy(), $order, 'nombre');
    }

    private function orderType($order) {
        return $this->order($this->getOrderType(), $order, 'asc');
    }
}