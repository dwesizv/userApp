<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuthController extends Controller {

    function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Access Token');
        $token = $tokenResult->token;
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($token->expires_at)->toDateTimeString()
        ]);
    }

    function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logged out']);
    }

    function register(Request $request) {
        $request->validate([
            'email' => 'required|string|email|unique:users',
            'name' => 'required|string',
            'password' => 'required|string'
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        return response()->json(['message' => 'User created'], 201);
    }

    function user(Request $request) {
        return response()->json($request->user());
    }
}