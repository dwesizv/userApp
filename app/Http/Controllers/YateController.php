<?php

namespace App\Http\Controllers;

use App\Models\Yate;
use Illuminate\Http\Request;

class YateController extends Controller {

    function index() {
        $yates = Yate::all();
        return view('yate.index', ['yates' => $yates]);
    }
}