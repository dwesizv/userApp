<?php

namespace App\Http\Controllers;

use App\Models\Yate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('home', ['user' => Auth::user()]);
    }

    function sql() {
        // select * from yate;
        // select * from yate where id = 1 or id = 3;
        // select * from yate where nombre > 'j' order by descripcion desc limit 3;
        
        //eloquent
        $yatesEloquent1 = Yate::all();
        $yatesEloquent2 = Yate::find([1, 3]);
        $yatesEloquent3 = Yate::where('nombre', '>', 'j')->orderBy('descripcion', 'desc')->take(3)->get();
        
        //db
        $yatesDb1 = DB::table('yate')->get();
        $yatesDb2 = DB::table('yate')->where('id', 1)->orWhere('id', 3)->get();
        $yatesDb3 = DB::table('yate')->where('nombre', '>', 'j')->orderBy('descripcion', 'desc')->take(3)->get();
        
        //pdo
        $pdo = DB::connection()->getPdo();
        $sql = 'select * from yate';
        $sentencia = $pdo->prepare($sql);
        $sentencia->execute();
        $yatesPdo1 = $sentencia->fetchAll();
        
        $sql = 'select * from yate where id = :id1 or id = :id2';
        $sentencia = $pdo->prepare($sql);
        $sentencia->bindValue('id1', 1);
        $sentencia->bindValue('id2', 3);
        $sentencia->execute();
        $yatesPdo2 = $sentencia->fetchAll();
        
        $sql = 'select * from yate where nombre > :letra order by descripcion desc limit 3';
        $sentencia = $pdo->prepare($sql);
        $sentencia->bindValue('letra', 'j');
        $sentencia->execute();
        $yatesPdo3 = $sentencia->fetchAll();
        
        /*dd([
            'eloquent1' => $yatesEloquent1,
            'eloquent2' => $yatesEloquent2,
            'eloquent3' => $yatesEloquent3,
            'db1'       => $yatesDb1,
            'db2'       => $yatesDb2,
            'db3'       => $yatesDb3,
            'pdo1'      => $yatesPdo1,
            'pdo2'      => $yatesPdo2,
            'pdo3'      => $yatesPdo3,
        ]);*/
        
        $e1 = $yatesEloquent3[0];
        $d1 = $yatesDb3[0];
        $p1 = $yatesPdo3[0];
        
        dd([
            'tipo1'  => gettype($e1),
            'tipo2'  => gettype($d1),
            'tipo3'  => gettype($p1),
            'clase1' => get_class($e1),
            'clase2' => get_class($d1),
            'clase3' => 'sin clase',
        ]);
    }
    
    function sql2() {
        //eloquent
        $yates1 = Yate::take(3)->get();

        //DB
        $yates2 = DB::table('yate')->take(3)->get();

        //pdo
        $pdo = DB::connection()->getPdo();
        $sql = "select * from yate limit 3";
        $sentencia = $pdo->prepare($sql);
        $sentencia->execute();
        $yates3 = $sentencia->fetchAll(); //\PDO::FETCH_ASSOC

        //dd([$yates1, $yates2, $yates3] );
        dd(gettype($yates1[0]), get_class($yates1[0]),
            gettype($yates2[0]), get_class($yates2[0]),
            gettype($yates3[0]),
            $yates1[0], $yates2[0], $yates3[0]);
    }

    function update(Request $request) {
        $validatedData = $this->validateInput($request);
        $message = 'User data has been updated.';
        $sendEmail = false;
        $user = Auth::user();
        $user->name = $request->name;
        if($request->password != null && Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->input('password'));
        } elseif($request->password != null) {
            return back()->withInput()->withErrors([
                                                'message' => 'User hasn\'t been updated',
                                                'old_password' => 'Old password does not match password.']);
        }
        if($request->email != $user->email) {
            $user->email = $request->email;
            $user->email_verified_at = null;
            $sendEmail = true;
        }
        if (!$user->updateUser($sendEmail)) {
            return back()
                     ->withInput()
                     ->withErrors(['message' => 'An unexpected error occurred while updating.']);
        }
        if($sendEmail) {
            $user->sendEmailVerificationNotification();
        }
        return redirect('home')->with('message', $message);
    }

    private function validateInput(Request $request) {
        return $request->validate([
            'email'         => 'required|email',
            'name'          => 'required|min:2|max:100',
            'old_password'  => 'nullable|min:8',
            'password'      => 'nullable|min:8|confirmed',
        ]);
    }
}