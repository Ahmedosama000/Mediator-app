<?php

namespace App\Http\Controllers\company\auth;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\traits\ApiTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\company\CodeRequest;

class VerficationController extends Controller
{
    use ApiTrait;

    public function SendCode(Request $request){

        // 1- Get token 
        $token = $request->header('Authorization');
        $authenticated = Auth::guard('sanctum')->user();
        // 2- Gen code 
        $code = rand(1000,9999);
        // 3- Gen expiration date 
        $expiration = date('Y-m-d H:i:s',strtotime('+10 minutes'));
        // 4- Save code and date in db
        $company = Company::find($authenticated->id);
        $company->code = $code ;
        $company->code_expired_at = $expiration;
        $company->save();
        $company->token = $token;

        return $this->Data(compact('company'),"",200);
    }

    public function CheckCode(CodeRequest $request){

        $token = $request->header('Authorization');
        $authenticated = Auth::guard('sanctum')->user();

        $company = Company::find($authenticated->id);
        $now =  date('Y-m-d H:i:s');

        if ($company->code == $request->code && $company->code_expired_at > $now){
            $company->email_verified_at = $now ;
            $company->save();
            $company->token = $token;

            return $this->Data(compact('company'),"User Verified Successfully",200);
        }
        else {
            return $this->ErrorMessage(["code"=>"Code Invalid"],"Failed attempt",401);
        }

    }
    
}
