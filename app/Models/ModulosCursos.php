<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulosCursos extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 
        'curso_id', 
        'title', 
        'description', 
        'recurso_curso', 
        'author', 
        'status', 
        'created_at',
        'updated_at'
    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }
}
