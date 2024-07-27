<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use App\Admin\Controllers\CardsRecursosController;
use OpenAdmin\Admin\Admin;
// use Illuminate\Support\Facades\Auth;
// use App\Admin\Actions\LogicalDelete;
use OpenAdmin\Admin\Layout\Content;
use OpenAdmin\Admin\Layout\Column;
use OpenAdmin\Admin\Layout\Row;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Show;
use OpenAdmin\Admin\Widgets\Box;
use App\Models\Recurso;

use OpenAdmin\Admin\Grid\Displayers\Actions\DropdownActions;

use Illuminate\Http\Request;

class CursosController extends AdminController
{
    
    public function index(Content $content)
    {
        $resources = Recurso::where('status', 1)->get();
        $maxWords = 5; // Ajusta el número de palabras

        return $content
            ->css_file(asset('css/dashboard.css'))
            ->title('Cursos')
            ->description('Listado de cursos')
            ->row(function (Row $row) use ($resources, $maxWords) {
                foreach ($resources as $resource) {
                    $truncatedName = $this->truncateText($resource->nombre, $maxWords);

                    $boxContent = '<div class="box-image">' .
                                  '<img src="http://127.0.0.1:1080/uploads' . asset($resource->caratula_imagen) . '" alt="Recurso"/>' .
                                  '</div>' .
                                  '<p class="truncate-lines">' .
                                  '<strong>Autor:</strong> ' . $resource->autor_recurso . '<br>' .
                                  '<strong>Fecha de Publicación:</strong> ' . $resource->fecha_publicacion . '<br>' .
                                  '<strong>Tipo de Recurso:</strong> ' . ($resource->tipo_recurso ? $resource->tipo_recurso->name : 'No disponible') .
                                  '</p>'.
                                  '<a href="' . route('admin.recursos.show', $resource->id) . '" class="btn btn-primary">Ver recurso</a>'; // Botón para ver recurso

                    $box = new Box($truncatedName, $boxContent);
                    $box->style('margin-top:20px; border:1px solid #FFAA00; padding: 10px;');

                    $row->column(4, function (Column $column) use ($box) {
                        $column->append($box);
                    });
                }
            });
    }

    protected function detail($id){
        $show = new Show(Recurso::findOrFail($id));
        $show->field('nombre', 'Nombre');
        $show->divider();
        $show->field('caratula_imagen', 'Caratula')->image($base_url='', $width = 200, $height = 200);
        $show->field('autor_recurso', 'Autor');
        $show->field('palabras_clave', 'Palabras Clave');
        $show->field('fecha_publicacion', 'Fecha de publicación');
        $show->field('tipo_recurso_id', 'Tipo de recurso');
        $show->field('resumen', 'Resumen');
        $show->field('file_recurso', 'Archivo')->file($server = '', $download = true);
        return $show;
    }

    protected function form(){
        $form = new form(new Recurso());
        $form->text('nombre', 'Nombre')->placeholder('Ingrese nombre del recurso')->rules('required');
        $form->image('caratula_imagen', 'Caratula del recurso')->placeholder('Ingrese autor del recurso')->rules('required');
        $form->file('file_recurso', 'Archivo')->rules('mimes:pdf')->rules('required');
        $form->text('autor_recurso', 'Autor del recurso')->placeholder('Ingrese autor del recurso')->rules('required');
        $form->text('palabras_clave', 'Palabras clave')->placeholder('Ingrese palabras clave')->rules('required');
        $form->date('fecha_publicacion', 'Fecha de publicación')->placeholder('Ingrese fecha de publicación')->format('d-m-Y');
        $form->select('tipo_recurso_id', 'Tipo de recurso')->options(TipoRecurso::where('tipo_recurso_id', '!=', 2)->pluck('name', 'tipo_recurso_id'))->rules('required');
        $form->textarea('resumen', 'Resumen')->placeholder('Ingrese resumen del articulo')->rules('required');
        
        $form->saving(function (Form $form) {

            $existingtype = Recurso::where('nombre', $form->nombre)->where('status', 1)->first();
            if ($existingtype && $existingtype->id !== $form->model()->id) {
                admin_toastr('Ya existe un registro de este recurso.', 'error');
                return back()->withInput();
            }

            if ($form->isCreating()) {
                $form->model()->author = Auth::user()->name;
                $form->model()->user_id = Auth::user()->id;
                $form->model()->created_at = now();
                $form->model()->status = '1';
            }
        });

        return $form;
    }
    
    private function truncateText($text, $maxWords) {
        $words = explode(' ', $text);
        if (count($words) > $maxWords) {
            $words = array_slice($words, 0, $maxWords);
            return implode(' ', $words) . '...';
        }
        return $text;
    }
}
