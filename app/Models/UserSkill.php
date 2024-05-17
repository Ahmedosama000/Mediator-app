<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'skill_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s', 
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $table = 'skill_user';


    public function user(){

        return $this->belongsTo(User::class,'user_id');
    }

    public function skill(){

        return $this->belongsTo(Skill::class,'skill_id');
    }

}
