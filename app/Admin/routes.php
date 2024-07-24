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
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('gestionar-docentes', DocentesController::class);
    $router->resource('gestionar-estudiante', EstudiantesController::class);
});
