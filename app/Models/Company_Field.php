<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company_Field extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'field_id'
    ];

    protected $table = 'company_field';
    public $timestamps = false;

}
