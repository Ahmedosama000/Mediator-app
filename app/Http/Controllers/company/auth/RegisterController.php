<?php

namespace App\Http\Controllers\company\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\company\RegisterRequest;
use App\Http\traits\ApiTrait;
use App\Models\Company;
use App\Models\Company_Field;
use App\Models\Field;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use ApiTrait;

    public function show(){

        $service = Service::all();
        $field = Field::all();

        $data = compact('service','field');
        return $this->Data($data,'',200);
    }

    public function register(RegisterRequest $request){
        $data = $request->except('password');
        $data['password'] = Hash::make($request->password);
        $Input_Field_id = $data['field_id'];
        $ids = [];
        $errors = [];

        if (str_contains($Input_Field_id, ',')) { 
            $fields_id = explode(',',$Input_Field_id);
            foreach ($fields_id as $field_id){
                if (Field::find($field_id)){
                    $ids[] = $field_id;
                }
                else {
                    $errors[] = "ID $field_id Not Found";
                }
            }
        }
        else {
            if (Field::find($Input_Field_id)){
                $ids[] = $Input_Field_id;
            }
            else {
                $errors[] = "ID $Input_Field_id Not Found";
            }
        }
        if ($errors){
            return $this->ErrorMessage($errors , " ",404);
        }
        else if (! $errors){

            $company = Company::create($data);
            $company_id = $company->id; 
            $company->token = "Bearer ".$company->createToken($request->password)->plainTextToken;
            foreach ($ids as $field_id){
                Company_Field::create(compact('company_id','field_id'));
            }
            return $this->Data(compact('company'),"User Created Successfully",201);
        }
    }
}
    