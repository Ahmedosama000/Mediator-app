<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    use HasFactory;

    // protected $table = 'user_posts';


    protected $fillable = [
        'title', 'content','user_id','status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
