<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $primaryKey = 'nim';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nim',
        'name',
        'password',
        'profile',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'role' => 'mahasiswa'
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Fungsi untuk mengecek apakah user adalah mahasiswa
    public function isMahasiswa()
    {
        return $this->role === 'mahasiswa';
    }
}