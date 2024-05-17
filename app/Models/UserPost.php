<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s', 
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $table = 'users_posts';


    public function user(){

        return $this->belongsTo(User::class,'user_id');
    }

}
