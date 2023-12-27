<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'status' => 400], 400);
        }


        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // // Optionally, you may want to automatically log in the user after registration
        // Auth::login($user);

        // // Generate a new access token for the user
        // $token = $user->createToken('registration_token')->accessToken;


        // Return a response
        return response()->json(['message' => "Register SuccessFully",  'status' => true], 200);
    }

    public function login(Request $request)
    {
        $input = $request->all();
        Auth::attempt($input);
        $user = Auth::user();
        $token = $user->createToken('permission_token')->accessToken;
        return response()->json(['status' => 200, 'token' => $token], 200);
    }


    public function logout()
    {
        if (Auth::guard('api')->check()) {
            Auth::guard('api')->user()->token()->revoke(); // Revoke the access token
            return response()->json(['status' => 200, 'message' => 'Successfully logged out'], 200);
        }
        return response()->json(['status' => 401, 'message' => 'Unauthenticated'], 401);
    }


    public function getUser()
    {
        if (Auth::guard('api')->check()) {
            $users = User::all();
            return response()->json(['data' => $users, 'status' => 200], 200);
        }
        return response()->json(['data' => "Unautherized User", 'status' => false], 400);
    }
}
