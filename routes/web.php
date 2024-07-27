<?php

use Illuminate\Support\Facades\Route;
use App\Admin\Controllers\CursosController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//Funciones para llamar elementos de un controller de open admin 
Route::get('admin/recursos/{id}', [CursosController::class, 'detail'])->name('admin.recursos.show');