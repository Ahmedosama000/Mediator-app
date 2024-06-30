<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json([
            'data' => [
                'id' => $user->id,
                'name' => $user->first_name,
                'email' => $user->email,
                'skills'=>$user->skills,
                'created_at' => $user->created_at->toDateTimeString(),
                'updated_at' => $user->updated_at->toDateTimeString(),
                // Add any other fields you want to include in the profile
            ]
        ]);
    }
}
