<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoRecurso extends Model
{
    protected $table = 'tipo_recurso'; // Especifica la tabla correcta

    protected $fillable = [
        'tipo_recurso_id',
        'name',
        'author',
        'status',
        'author',
        'created_at',
        'updated_at'
    ];

    // filtro por rol_id
    // public function roles() {
    //     return $this->belongsTo(AdminRoleUsers::class, 'id', 'user_id');
    // }


}
