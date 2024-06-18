<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;


class AuthController extends Controller
{
    //

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
    public function register(Request $request){
        //dd($request->all());
        $validated = $request->validate([
               'email' => 'required|email|unique:users',
               'password' => 'required|string|min:6',
               'first_name' => 'required|string',
               'last_name' => 'required|string',
               'gender'=>'required',
               'DOB'=>'required|date',
               'github' =>'required',
               'university_id' =>'required|numeric',
               'city_id' =>'required|numeric',
               'salary_id' =>'required|numeric',
       ]);

        $user= User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if($user){
            return $this->login($request);
        }
        return response()->json(["msg"=>"Something went wrong"]);

    }
    
    public function logout(Request $request) {
        $request->user()->tokens()->each(function ($token, $key) {
            $token->delete(); // Properly delete each token
        });
    
        // Optionally, you might want to revoke the token explicitly depending on your setup
        // $token->revoke();
    
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
    
    
}
