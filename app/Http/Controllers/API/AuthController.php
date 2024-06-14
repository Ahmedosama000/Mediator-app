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
    //

    public function login(Request $request){
        try{
            $rules = [
                'email' => 'required|string',
                'password' => 'required',
            ];
            $validator = Validator::make($request->all(),$rules);
            if ($validator->fails()){ 
                return response()->json($validator->errors(), 422);
                //$code = $this->returnCodeAccordingToInput($validator);
                //return $this->returnValidationError($validator, $code);
            }
            $credentials =  $request->only(['email','password']);
            $token = Auth::guard("api")->attempt($credentials);
            if(!$token){
                return response()->json(['msg'=>"Invalid Email or Password"],401);
            }
            $user = Auth::guard("api")->user();
            $user->token = $token;
            return response()->json([
                "user"=>$user]);

        }catch (\Exception $e) {
            // Log the error for internal use
            \Log::error($e->getMessage());
        
            // Return a generic error message to the client
            return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
        }
        
        return response()->json(['msg'=>"Invalid Email or Password"],401);

    }
    public function register(Request $request){
        //dd($request->all());
        $validated = $request->validate([
               'email' => 'required|email',
               'password' => 'required',
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
            'name' => $request->name ,
            'email' => $request->email, 
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        if($user){
            return $this->login($request);
        }
        return response()->json(["msg"=>"Something went wrong"]);

    }
    
    public function logout(Request $request) {
        $token = $request->user()->token();
        Auth::guard('api')->logout();
    
        // Optionally, you might want to revoke the token explicitly depending on your setup
        $token->revoke();
    
        return response()->json(['message' => 'Successfully logged out'], 200);
    }
    
    
}
