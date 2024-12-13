<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    public function index() {
        
        return view('auth.login');

    }

    public function prosesLogin(Request $request) {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:5'
        ]);
    
        $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Email atau Password salah'], 401);
            }
    
            $user = Auth::user();
            $role = $user->roles->first()->name;
            
            return response()->json([
                'user' => $user,
                'token' => $token
            ], 200);
            
        
}


    public function logout() {

        Auth::logout();

        return redirect()->route('login')->with('success', 'Berhasil Logout');

    }

    
}
