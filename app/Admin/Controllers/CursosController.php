<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
// use OpenAdmin\Admin\Admin;
use Illuminate\Support\Facades\Auth;
use App\Admin\Actions\LogicalDelete;
// use OpenAdmin\Admin\Layout\Content;
// use OpenAdmin\Admin\Layout\Column;
// use OpenAdmin\Admin\Layout\Row;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Show;
use OpenAdmin\Admin\Grid;
// use OpenAdmin\Admin\Widgets\Box;
use App\Models\Cursos;
use App\Models\ModulosCursos;

// use OpenAdmin\Admin\Grid\Displayers\Actions\DropdownActions;

use Illuminate\Http\Request;

class CursosController extends AdminController
{
    
    // public function index(Content $content)
    // {
    //     $resources = Recurso::where('status', 1)->get();
    //     $maxWords = 5; // Ajusta el número de palabras

    //     return $content
    //         ->css_file(asset('css/dashboard.css'))
    //         ->title('Cursos')
    //         ->description('Listado de cursos');
    // }

    protected $title = 'Cursos';

     protected function grid(){
        $grid = new Grid(new Cursos());
        // $grid->model()->where('status', 1)->where('user_id', Auth::user()->id);
        
        $grid->column('name', 'Nombre')->width(200);
        $grid->column('image')->image();
        $grid->column('decription', 'Descripción')->downloadable();
        $grid->column('autor_recurso', 'Autor')->width(200);
        $grid->column('palabras_clave', __('Palabras Clave'))->width(200);
        $grid->column('fecha_publicacion', __('Fecha de publicación'))->width(200);
        $grid->column('author', __('Autor'))->width(200);
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->add(new LogicalDelete);
        });
        return $grid;
    }

    protected function detail($id){
        $show = new Show(Cursos::findOrFail($id));
        // $show->field('nombre', 'Nombre');
        // $show->divider();
        // $show->field('caratula_imagen', 'Caratula')->image($base_url='', $width = 200, $height = 200);
        // $show->field('autor_recurso', 'Autor');
        // $show->field('palabras_clave', 'Palabras Clave');
        // $show->field('fecha_publicacion', 'Fecha de publicación');
        // $show->field('tipo_recurso_id', 'Tipo de recurso');
        // $show->field('resumen', 'Resumen');
        // $show->field('file_recurso', 'Archivo')->file($server = '', $download = true);
        return $show;
    }

    protected function form()
{
    $form = new Form(new Cursos());

    $form->text('name', 'Nombre del curso')
        ->placeholder('Ingrese nombre del curso')
        ->rules('required');

    $form->image('image', 'Portada del recurso')
        ->help('Agrega una carátula para visualizar tu curso.')
        ->rules('required');

    $form->text('description', 'Descripción del curso')
         ->placeholder('Ingrese descripción del curso')
         ->rules('required');

    // Formulario de añadir sección para el curso
    $form->html('
        <div class="container mt-4" style="border: 2px solid #c3c3c3; border-radius: 10px; padding: 20px; background-color: #f8f9fa;">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <h3 class="mb-4">Añadir Secciones</h3>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="d-flex justify-content-end mb-3">
                        <button type="button" class="btn btn-secondary" id="addSectionBtn">Añadir lección</button>
                    </div>
                </div>
            </div>
            <!-- Contenedor donde se agregarán los formularios -->
            <div id="sectionsContainer">
                <!-- El primer formulario ya está aquí -->
                <div class="card mb-3 section-card" style="padding: 1px; background-color: #f8f9fa;">
                    <div class="card-header" style="background-color: #f8f9fa;">
                        <h5>Nueva Sección o Taller</h5>
                    </div>
                    <div class="card-body" style="padding: 0px;">
                        <div class="mb-3">
                            <label for="sectionName0" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="sectionName0" required>
                        </div>
                        <div class="mb-3">
                            <label for="sectionDescription0" class="form-label">Descripción</label>
                            <textarea class="form-control" id="sectionDescription0" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="sectionFile0" class="form-label">Añadir archivo</label>
                            <input class="form-control" type="file" id="sectionFile0">
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-danger removeSectionBtn" disabled>Quitar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Campo oculto para datos de secciones -->
            <input type="hidden" id="sectionsData" name="sectionsData">
        </div>
    ');

    $form->html('
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let formCount = 1;

                document.getElementById("addSectionBtn").addEventListener("click", function() {
                    if (formCount >= 5) {
                        alert("Se ha alcanzado el máximo número de secciones (5).");
                        return;
                    }

                    const formHtml = `
                        <div class="card mb-3 section-card" style="padding: 1px; background-color: #f8f9fa;">
                            <div class="card-header" style="background-color: #f8f9fa;">
                                <h5>Nueva Sección o Taller</h5>
                            </div>
                            <div class="card-body" style="padding: 0px;">
                                <div class="mb-3">
                                    <label for="sectionName${formCount}" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="sectionName${formCount}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="sectionDescription${formCount}" class="form-label">Descripción</label>
                                    <textarea class="form-control" id="sectionDescription${formCount}" rows="3" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="sectionFile${formCount}" class="form-label">Añadir archivo</label>
                                    <input class="form-control" type="file" id="sectionFile${formCount}">
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-danger removeSectionBtn">Quitar</button>
                                </div>
                            </div>
                        </div>
                    `;

                    document.getElementById("sectionsContainer").insertAdjacentHTML("beforeend", formHtml);
                    formCount++;

                    // Enable remove button for the first section
                    const firstSectionRemoveBtn = document.querySelector("#sectionsContainer .section-card:first-child .removeSectionBtn");
                    if (firstSectionRemoveBtn) {
                        firstSectionRemoveBtn.disabled = false;
                    }
                });

                document.getElementById("sectionsContainer").addEventListener("click", function(event) {
                    if (event.target.classList.contains("removeSectionBtn")) {
                        if (document.querySelectorAll("#sectionsContainer .section-card").length > 1) {
                            event.target.closest(".card").remove();
                            formCount--;
                        } else {
                            alert("Debe haber al menos una sección.");
                        }
                    }
                });

                document.querySelector("form").addEventListener("submit", function(event) {
                    // Collect section data and put it in the hidden field
                    const sections = [];
                    document.querySelectorAll("#sectionsContainer .card").forEach((card) => {
                        const name = card.querySelector(\'[id^="sectionName"]\').value;
                        const description = card.querySelector(\'[id^="sectionDescription"]\').value;
                        const file = card.querySelector(\'[id^="sectionFile"]\').files[0];
                        
                        sections.push({
                            nombre: name,
                            descripcion: description,
                            archivo: file ? file.name : null,
                        });
                    });

                    document.getElementById("sectionsData").value = JSON.stringify(sections);
                });
            });
        </script>
    ');

    // $form->saving(function (Form $form) {
    //     // Guardar los datos del curso
    //     $existingtype = Cursos::where('name', $form->name)->where('status', 1)->first();
    //     if ($existingtype && $existingtype->id !== $form->model()->id) {
    //         admin_toastr('Ya existe un registro de este curso.', 'error');
    //         return back()->withInput();
    //     }

    //     if ($form->isCreating()) {
    //         $form->model()->author = Auth::user()->name;
    //         $form->model()->user_id = Auth::user()->id;
    //         $form->model()->created_at = now();
    //         $form->model()->status = '1';
    //     }
    // });

    $form->saved(function (Form $form) {
        // Obtener los datos de las secciones desde el campo oculto
        $sectionsData = $form->sectionsData;

        dd($sectionsData);
        // Verificar que $sectionsData no sea null y sea un array
        // if (is_array($sectionsData)) {
        //     // Guardar las secciones
        //     foreach ($sectionsData as $sectionData) {
        //         ModulosCursos::create([
        //             'curso_id' => $form->model()->id,
        //             'nombre' => $sectionData['nombre'],
        //             'descripcion' => $sectionData['descripcion'],
        //             'archivo' => $sectionData['archivo'],
        //             'status' => 1,
        //             'author' => Auth::user()->name,
        //         ]);
        //     }
        // }
    });

    return $form;
}

    



    
}
