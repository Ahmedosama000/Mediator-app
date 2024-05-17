<?php

namespace App\Http\Controllers\company\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\company\LoginRequest;
use App\Http\traits\ApiTrait;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use ApiTrait;

    public function login(LoginRequest $request){

        $company = Company::where('email',$request->email)->first();
        if (! Hash::check($request->password,$company->password)){
            return $this->ErrorMessage(["email"=>"The email or password not correct"],"",401);
        }
        $company->token = "Bearer ".$company->createToken($request->password)->plainTextToken;
        if (is_null($company->email_verified_at)){
            return $this->Data(compact('company'),"User Not Verified",401);
        }
        return $this->Data(compact('company'),"",200);
    }

    public function logout(Request $request){
        
        $token = $request->header('Authorization');
        $authenticated = Auth::guard('sanctum')->user();

        $IdWithBearer = explode('|',$token)[0];
        $TokenId = explode(' ',$IdWithBearer)[1];

        $authenticated->token()->where('id',$TokenId)->delete();
        return $this->SuccessMessage("User logged out Successfully",200);

    }

    public function AllLogout(){

        $authenticated = Auth::guard('sanctum')->user();
        $authenticated->tokens()->delete();
        return $this->SuccessMessage("User logged out from all devices",200);
    }
}
