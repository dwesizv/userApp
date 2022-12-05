<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdministrationController extends Controller
{
    
    function __construct() {
        $this->middleware('admin');
    }

    public function index() {
        $users = User::all();
        return view('admin.index', ['users' => $users]);
    }

    public function create() {
        $types = [
            'admin' => 'Administrator',
            'advanced' => 'Advanced User',
            'user' => 'User',
        ];
        return view('admin.create', ['types' => $types]);
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

    public function show(User $user) {
        return view('admin.show');
    }

    public function edit(User $user) {
        $types = [
            'admin' => 'Administrator',
            'advanced' => 'Advanced User',
            'user' => 'User',
        ];
        return view('admin.edit', ['user' => $user, 'types' => $types]);
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

    public function destroy(User $user) {
        $message = 'User ' . $user->name . ' has not been removed.';
        if($user->email != Auth::user()->email) {
            $name = $user->name;
            $result = $user->deleteUser();
            if($result) {
                $message = 'User ' . $name . ' has been removed.';
            }
        }
        return redirect('admin')->withErrors(['message' => $message]);
    }

}