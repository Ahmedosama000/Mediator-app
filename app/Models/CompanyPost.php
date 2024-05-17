<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'company_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s', 
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $table = 'cm_posts';


    public function company(){

        return $this->belongsTo(Company::class,'company_id');
    }

}
