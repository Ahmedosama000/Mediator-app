<?php

namespace App\Http\Controllers\company\auth;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\traits\ApiTrait;
use App\Models\PasswordReset;
use App\Http\Requests\ResetRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ResetController extends Controller
{
    
    use ApiTrait;

    public function CheckMail($email){
        $email_list = [];
        $user = Company::where('email',$email)->first();
        if ($user){
            $email_list['email'] = $email;
            return $this->Data(compact('email'),"Email is exists",200);
        }
        else {
            return $this->ErrorMessage(['email'=>'email not found'],"Email not found",404);
        }
    }

    public function ResetPassword(ResetRequest $request){
        $token = $request->token;
        $email = PasswordReset::where('token',$token)->first()->email;
        $new_password = Hash::make($request->password);

        $user = Company::where('email',$email)->first();
        $user->password = $new_password;
        $user->save();

        PasswordReset::where('email',$email)->delete();

        return $this->SuccessMessage("Password has been changed successfully",200);
    }
}
