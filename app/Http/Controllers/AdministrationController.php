<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdministrationController extends Controller {

    function __construct() {
        $this->middleware('admin');
    }

    function create() {
        return view('admin.create', ['types' => self::getTypes()]);
    }

    public function destroy(User $user) {
        $message = 'User ' . $user->name . ' has not been removed.';
        if($user->email != Auth::user()->email) {
            $name = $user->name;
            if($user->deleteUser()) {
                $message = 'User ' . $name . ' has been removed.';
                return redirect('admin')->with(['message' => $message]);
            }
        }
        return redirect('admin')->withErrors(['message' => $message]);
    }

    public function edit(User $user) {
        return view('admin.edit', ['user' => $user, 'types' => self::getTypes()]);
    }

    private static function getTypes() {
        return [
            'admin' => 'Administrator',
            'advanced' => 'Advanced User',
            'user' => 'User',
        ];
    }

    function index() {
        $users = User::all();
        return view('admin.index', ['users' => $users]);
    }

    public function show(User $user) {
        return view('admin.show');
    }

    public function store(Request $request) {
        $user = new User($request->all());
        $user->password = Hash::make($user->password);
        $user->email_verified_at = Carbon::parse(Carbon::now());
        if($user->storeUser()) {
            $message = 'User has been created.';
        } else {
            return back()
                ->withInput()
                ->withErrors(['message' => 'An unexpected error occurred while creating.']);
        }
        return redirect('admin')->with('message', $message);
    }

    public function update(Request $request, User $user) {
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->type = $request->input('type');
        if($request->input('password') != null) {
            $user->password = Hash::make($request->input('password'));
        }
        if($user->updateUser()) {
            $message = 'User has been updated.';
        } else {
            return back()
                    ->withInput()
                    ->withErrors(['message' => 'An unexpected error occurred while updating.']);
        }
        return redirect('admin')->with('message', $message);
    }

}