<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cursos extends Model
{
    protected $table = 'cursos'; // Especifica la tabla correcta
    protected $fillable = [
        'cursos_id', 
        'name', 
        'description', 
        'image', 
        'user_id', 
        'author', 
        'status', 
        'created_at',
        'updated_at'
    ];
    

}
