<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use OpenAdmin\Admin\Facades\Admin;
use App\Admin\Controllers\DocentesController;
use App\Admin\Controllers\EstudiantesController;
use App\Admin\Controllers\ArchivosController;
use App\Admin\Controllers\TipoRecursoController;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('gestionar-docentes', DocentesController::class);
    $router->resource('gestionar-estudiante', EstudiantesController::class);
    $router->get('/gestionar-mis-archivos', 'ArchivosController@index')->name('Recursos');
    $router->resource('tipos-recursos', TipoRecursoController::class);
    // $router->get('/gestionar-cursos', 'CursosController@index')->name('Cursos');
    $router->resource('gestionar-cursos', CursosController::class);

    // $router->get('/gestionar-cursos', function () {
    //     return view('cursos');
    // })->name('cursos');
});
