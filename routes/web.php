<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\RolesComponet;
use App\Livewire\PermissionComponent;
use App\Livewire\AsisComponent;
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





//Rutas generadas por Henry
Route::get('/roles', RolesComponet::class);
Route::get('/permisos', PermissionComponent::class);
Route::get('/asignar/permisos', AsisComponent::class);




Route::get('/', function () {
    return view('welcome');
});
