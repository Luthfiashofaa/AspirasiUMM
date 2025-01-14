<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; 
class Faq extends Model
{
    use HasFactory; 
    /** 
* fillable 
* 
* @var array 
*/ 
protected $fillable = [ 
    'question', 
    'answer', 
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}
