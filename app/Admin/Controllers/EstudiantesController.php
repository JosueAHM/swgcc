<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Admin\Actions\LogicalDelete;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\AdminUsers;

class EstudiantesController extends AdminController
{
    protected $title = 'Estudiantes';

    // Mostramos la data en tablas
    protected function grid(){
        $grid = new Grid(new AdminUsers());
        $grid->model()->whereHas('roles', function($query) {
            $query->where('role_id', 3);
        })->where('status', 1);

        $grid->column('cedula', 'Cedula');
        $grid->column('name', 'Nombres');
        $grid->column('phone', __('Teléfono'));
        $grid->column('email', __('Correo'));
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->add(new LogicalDelete);
        });
        return $grid;
    }
    
    protected function detail($id){
        $show = new Show(AdminUsers::findOrFail($id));
        $show->field('cedula', 'Cedula');
        $show->field('name', 'Nombres');
        $show->field('phone', 'Telefono');
        $show->field('email', 'Correo');

        return $show;
    }

    protected function form(){
        $form = new form(new AdminUsers());
        $form->text('cedula', 'Cédula')->placeholder('Ingrese cédula del docente')->rules('required|numeric|digits:10');
        $form->html('<script>
            window.addEventListener("load", function() {
                var cedulaInput = document.querySelector("input[name=\'cedula\']");
                if (cedulaInput) {
                    cedulaInput.addEventListener("input", function() {
                        this.value = this.value.replace(/[^0-9]/g, "").slice(0, 10);
                    });
                }
            });
        </script>');
        $form->text('name', 'Nombre')
            ->placeholder('Ingrese nombre del docente')
            ->rules('required');
        $form->image('avatar', __('Avatar'));

        $form->phonenumber('phone','Teléfono')
            ->options(['mask' => '9999999999']);
        $form->email('email', __('Correo electrónico'))
            ->placeholder('Ingrese correo electrónico')
            ->rules('required');
        $form->password('password', __('Contraseña'))
            ->placeholder('Ingrese contraseña')
            ->rules('required');

        $form->saving(function (Form $form) {

            $existingUser = AdminUsers::where('cedula', $form->cedula)->first();
            if ($existingUser && $existingUser->id !== $form->model()->id) {
                admin_toastr('Ya existe un docente registrado con este número de cédula.', 'error');
                return back()->withInput();
            }
            // Hashing antes de guardar
            if ($form->password && $form->model()->password !== $form->password) {
                $form->password = Hash::make($form->password);
            }

            $form->model()->username = $form->cedula;

            if ($form->isCreating()) {
                $form->model()->author = Auth::user()->name;
                $form->model()->created_at = now();
                $form->model()->status = '1';
            }
        });
        $form->saved(function (Form $form) {
            // Guardar en otra tabla
            \App\Models\AdminRoleUsers::create([
                'role_id' => 3,
                'user_id' => $form->model()->id,
                'status' => 1,
                'author' => $form->model()->author = Auth::user()->name,
            ]);
        });

        return $form;
    }
}
