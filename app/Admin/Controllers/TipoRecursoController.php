<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Admin\Actions\LogicalDelete;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\TipoRecurso;

class TipoRecursoController extends AdminController
{
    protected $title = 'Tipos de recursos';
    
    protected function grid(){
        $grid = new Grid(new TipoRecurso());
        $grid->model()->where('status', 1);
        $grid->column('tipo_recurso_id', 'ID');
        $grid->column('name', 'Nombre');
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->add(new LogicalDelete);
        });
        return $grid;
    }

    protected function detail($id){
        $show = new Show(TipoRecurso::findOrFail($id));
        $show->field('cedula', 'Cedula');
        $show->field('name', 'Nombre');
        return $show;
    }

    protected function form(){
        $form = new form(new TipoRecurso());
        $form->text('name', 'Nombre')->placeholder('Ingrese nombre del tipo de recurso')->rules('required');
        
        $form->saving(function (Form $form) {

            $existingtype = TipoRecurso::where('name', $form->name)->first();
            if ($existingtype && $existingtype->id !== $form->model()->id) {
                admin_toastr('Ya existe un registro de este tipo de recurso.', 'error');
                return back()->withInput();
            }

            if ($form->isCreating()) {
                $form->model()->author = Auth::user()->name;
                $form->model()->created_at = now();
                $form->model()->status = '1';
            }
        });

        return $form;
    }
}
