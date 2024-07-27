<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use Illuminate\Http\Request;
use OpenAdmin\Admin\Widgets\Box;

use App\Models\Recurso;

class CardsRecursosController extends AdminController
{
    public static function userResources()
    {
        // $resources = Recurso::where('status', 1)
        //                     ->where('user_id', auth()->id())
        //                     ->get();

        $html = '';
        foreach ($resources as $resource) {
            $boxContent = '<strong>Nombre:</strong> ' . $resource->nombre . '<br>' .
                          '<strong>Autor:</strong> ' . $resource->autor_recurso . '<br>' .
                          '<strong>Fecha de Publicación:</strong> ' . $resource->fecha_publicacion . '<br>' .
                          '<strong>Tipo de Recurso:</strong> ' . ($resource->tipo_recurso ? $resource->tipo_recurso->name : 'No disponible') . '<br>' .
                          '<strong>Resumen:</strong> ' . $resource->resumen . '<br>';

            $box = '<div class="card" style="margin-bottom: 20px; border: 1px solid #FFAA00; padding: 15px;">' . 
                   '<h3>' . $resource->nombre . '</h3>' . 
                   $boxContent . 
                   '</div>';

            $html .= $box;
        }

        return $html;
    }

    public static function anotherCard()
    {
        $boxContent = 'Contenido de otra card';
        $box = new Box('Otra Card', $boxContent);
        $box->collapsable();
        $box->removable();
        $box->style('margin-top:20px; border:1px solid #FFAA00;');

        return $box;
    }
}
