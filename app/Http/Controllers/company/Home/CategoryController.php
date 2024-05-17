<?php

namespace App\Http\Controllers\company\Home;

use App\Models\User;
use App\Models\Skill;
use App\Models\UserSkill;
use Illuminate\Http\Request;
use App\Http\traits\ApiTrait;
use App\Http\Controllers\Controller;
use App\Models\UserPost;

class CategoryController extends Controller
{
    use ApiTrait;

    public function ShowSkills(){

        $data = Skill::all();
        return $this->Data(compact('data'),"",200);

    }

    public function GetUsersBySkill($id){

        try {

            $check = UserSkill::where('skill_id',$id)->get()[0];
            $data = UserSkill::with('user:users.id,first_name,last_name','skill:skills.id,name')->where('skill_id',$id)->get();
            return $this->Data(compact('data'),"",200);

        } 

        catch (\Throwable $th) {

            return $this->ErrorMessage(['ID' => 'ID Not Found'],"ID not found",404);
        }
    }

    public function GetAllPosts(){

        try {

            $data = UserPost::with('user:users.id,first_name,last_name')->get();
            return $this->Data(compact('data'),"",200);
        } 

        catch (\Throwable $th) {

            return $this->ErrorMessage(['ID' => 'ID Not Found'],"ID not found",404);
        }

    }
}
