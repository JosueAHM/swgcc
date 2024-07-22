<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Admin\Actions\LogicalDelete;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\User;

class UsersController extends AdminController
{
    protected $title = 'Docentes';

    // Mostramos la data en tablas
    protected function grid(){
        $grid = new Grid(new User());

        $grid->model()->where('status', 1)->where('id_admin_role', 2);

        $grid->column('cedula', __('Cedula'));
        $grid->column('name', __('Nombres'));
        $grid->column('phone', __('Teléfono'));
        $grid->column('email', __('Correo'));
        $grid->column('id_admin_role', __('Rol'));

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->add(new LogicalDelete);
        });
        return $grid;
    }
    
    protected function detail($id){
        $show = new Show(User::findOrFail($id));
        $show->field('cedula', 'Cedula');
        $show->field('name', 'Nombres');
        $show->field('phone', 'Telefono');
        $show->field('email', 'Correo');

        return $show;
    }

    protected function form(){
        $form = new form(new User());
        $form->text('cedula', 'Cédula')->placeholder('Ingrese cédula del docente')->rules('required|numeric|digits_between:1,10');
        $form->html('<script>
            document.addEventListener("DOMContentLoaded", function() {
                var cedulaInput = document.querySelector("input[name=\'cedula\']");
                cedulaInput.addEventListener("input", function() {
                    this.value = this.value.replace(/[^0-9]/g, "").slice(0, 10);
                });
            });
        </script>');
        $form->text('name', 'Nombre')->placeholder('Ingrese nombre del docente')->rules('required');
        $form->phonenumber('phone','Teléfono')->options(['mask' => '9999999999']);
        $form->email('email', __('Correo electrónico'))->placeholder('Ingrese correo electrónico')->rules('required');
        $form->password('password', __('Contraseña'))->placeholder('Ingrese contraseña')->rules('required');

        $form->saving(function (Form $form) {
            if ($form->isCreating()) {
                $form->model()->author = Auth::user()->name;
                $form->model()->created_at = now();
                $form->model()->id_admin_role = '2';
                $form->model()->status = '1';
            }
        });

        return $form;
    }
}
