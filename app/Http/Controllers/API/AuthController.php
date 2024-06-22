<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // Debugging the request data
        //dd($request->all());

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            // Debugging the authenticated user
            dd($user);
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token, 'user' => $user], 200);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = Auth::user();
        return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
    }

    public function register(Request $request)
    {
        // Debugging the request data
        dd($request->all());
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'gender' => 'required',
            'DOB' => 'required|date',
            'github' => 'required',
            'university_id' => 'required|numeric',
            'city_id' => 'required|numeric',
            'salary_id' => 'required|numeric',
        ]);

        // Debugging the validated data
        dd($validated);

        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Debugging the created user
        dd($user);

        if ($user) {
            return $this->login($request);
        }
        return response()->json(["msg" => "Something went wrong"], 500);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); // Properly delete each token
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function updateProfile(Request $request)
    {
        // Implement profile update logic
    }

    public function changePassword(Request $request)
    {
        // Implement password change logic
    }
}
