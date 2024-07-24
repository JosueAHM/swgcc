<?php

use Illuminate\Routing\Router;
use App\Admin\Controllers\DocentesController;
use App\Admin\Controllers\EstudiantesController;
use Illuminate\Support\Facades\Route;
use OpenAdmin\Admin\Facades\Admin;

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
});
