<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\AdminRoleUsers;

class AdminUsers extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'id',
        'cedula',
        'username',
        'name',
        'avatar',
        'phone',
        'email',
        'status',
        'author'
    ];

    // filtro por rol_id
    public function roles() {
        return $this->belongsTo(AdminRoleUsers::class, 'id', 'user_id');
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
