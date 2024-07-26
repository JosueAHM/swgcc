<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    protected $table = 'recurso'; // Especifica la tabla correcta

    protected $fillable = [
        'id',
        'nombre',
        'caratula_imagen',
        'file_recurso',
        'autor_recurso',
        'palabras_clave',
        'fecha_publicacion',
        'tipo_recurso_id',
        'resumen',
        'user_id',
        'status',
        'author'
    ];

    // filtro por 
    // public function roles() {
    //     return $this->belongsTo(AdminRoleUsers::class, 'id', 'user_id');
    // }

    public function tipo_recurso()
    {
        return $this->hasOne(TipoRecurso::class, 'tipo_recurso_id', 'tipo_recurso_id');
    }
}
