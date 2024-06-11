<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class ApiController extends Controller
{
    public function login(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ],404);
        }

        if (!Hash::check($request -> password, $user -> password)){
            return response()->json([
                'message' => 'Invalid credentials'
            ],401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'assess_token' => $token,
            'user' => $user
        ],200);
    } 

    public function register(Request $request){

        $request->validate([
            'name' => 'required',
            'emial' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => $user
        ]);
    }

    public function logout(Request $request) {
        $request->user()->currentAccesToken()->delete();

        return response()->json([
            'message' => 'logged out'
        ],200);
    }

}
