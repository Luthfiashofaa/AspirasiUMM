<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengaduan_id', 
        'user_id',     
        'isi_komentar', 
        'is_admin',    
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function complaint()
    {
        return $this->belongsTo(Complaint::class, 'pengaduan_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'nim');
    }
}
