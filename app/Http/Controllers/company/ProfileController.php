<?php

namespace App\Http\Controllers\company;

use App\Models\User;
use App\Models\UserPost;
use App\Models\UserSkill;
use Illuminate\Http\Request;
use App\Http\traits\ApiTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddPostrequest;
use App\Models\CompanyPost;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    use ApiTrait;

    public function ShowUserProfile($id){
        
        $check = User::find($id);        
        if ($check){
            
            $data = User::with('city:cities.id,name','university:universities.id,name')->find($id);
            return $this->Data(compact('data'),"",200);
        
        }
        return $this->ErrorMessage(['ID' => 'ID Not Found'],"ID not found",404);
    }

    public function GetUserSkills($id){

        try {

            $check = UserSkill::where('skill_id',$id)->get()[0];
            $data = UserSkill::with('user:users.id,first_name,last_name','skill:skills.id,name')->where('user_id',$id)->get();
            return $this->Data(compact('data'),"",200);

        } 
        catch (\Throwable $th) {

            return $this->ErrorMessage(['ID' => 'ID Not Found'],"ID not found",404);
        }
    }

    public function GetUserPosts($id){

        try {

            $data = UserPost::with('user:users.id,first_name,last_name')->where('user_id',$id)->get();
            return $this->Data(compact('data'),"",200);

        } 
        catch (\Throwable $th) {

            return $this->ErrorMessage(['ID' => 'ID Not Found'],"ID not found",404);
        }
    }

    public function AddNewPost(AddPostrequest $request){

        $token = $request->header('Authorization');
        $authenticated = Auth::guard('sanctum')->user();

        if ($authenticated){

            $data = [

                'content' => $request->content,
                'company_id' => $authenticated->id,
            ];

            $post = CompanyPost::create($data);
            return $this->Data(compact('post'),"Post Added Successfully",200);
        }
        return $this->ErrorMessage(['token'=>'token invalid'],"Please check token",404);

    }
}
