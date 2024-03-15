<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\RolesComponet;
use App\Livewire\PermissionComponent;
use App\Livewire\AsisComponent;
use App\Livewire\UserComponent;
use App\Livewire\Instituciones\InstitucionesComponent;
use App\Livewire\Allproducts;
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
Route::get('/usuarios', UserComponent::class);

//Rutas por Hector
//Instituciones
Route::get('/instituciones', InstitucionesComponent::class);
Route::get('/products', Allproducts::class);





Route::get('/', function () {
    return view('welcome');
});
