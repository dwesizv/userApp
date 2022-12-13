<?php

namespace App\Http\Controllers;

use App\Models\Yate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class YateController extends Controller {

    const ORDER_BY = 'nombre';
    const ORDER_TYPE = 'asc';

    private function getOrder($orderArray, $order, $default) {
        $value = array_search($order, $orderArray);
        if(!$value) {
            return $default;
        }
        return $value;
    }

    private function getOrderBy($order) {
        return $this->getOrder($this->getOrderBys(), $order, self::ORDER_BY);
    }

    private function getOrderBys() {
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

    private function getOrderType($order) {
        return $this->getOrder($this->getOrderTypes(), $order, self::ORDER_TYPE);
    }

    private function getOrderTypes() {
        return [
            'asc'  => 't1',
            'desc' => 't2',
        ];
    }
    
    private function getOrderUrls($oBy, $oType) {
        $urls = [];
        $orderBys = $this->getOrderBys();
        $orderTypes = $this->getOrderTypes();
        foreach($orderBys as $indexBy => $by) {
            foreach($orderTypes as $indexType => $type) {
                if($oBy == $indexBy && $oType == $indexType) {
                    $urls[$indexBy][$indexType] = url()->full() . '#';
                } else {
                    $urls[$indexBy][$indexType] = route('yate.index',[
                                                        'orderby' => $by,
                                                        'ordertype' => $type]);
                }
            }
        }
        return $urls;
    }

    function index(Request $request) {
        //orden
        $orderby = $this->getOrderBy($request->input('orderby'));
        $ordertype = $this->getOrderType($request->input('ordertype'));

        //datos
        $yate = new Yate();
        $yate = $yate->orderBy($orderby, $ordertype);
        if($orderby != self::ORDER_BY) {
            $yate = $yate->orderBy('nombre', 'asc');
        }
        $yates = $yate->get();

        //vista
        return view('yate.index', ['order'  => $this->getOrderUrls($orderby, $ordertype),
                                    'yates' => $yates]);
    }

}