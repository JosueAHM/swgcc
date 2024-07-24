<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminRoleUsers extends Model
{
    // protected $table = 'admin_role_users'; // Especifica la tabla correcta
    protected $fillable = [
        'role_id', 
        'user_id', 
        'author', 
        'status', 
        'created_at',
        'updated_at'
    ];
    

}
