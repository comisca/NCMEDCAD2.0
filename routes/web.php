<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\RolesComponet;
use App\Livewire\PermissionComponent;
use App\Livewire\AsisComponent;
use App\Livewire\UserComponent;
use App\Livewire\LoginComponent;

use App\Livewire\Instituciones\InstitucionesComponent;
//use App\Livewire\All;
use App\Livewire\CreateBussines;

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

Route::get('/', LoginComponent::class)->name('login');
Route::middleware(['auth'])->group(function () {

    Route::get('/usuarios', UserComponent::class);
    Route::get('/roles', RolesComponet::class);
    Route::get('/permisos', PermissionComponent::class);
    Route::get('/asignar/permisos', AsisComponent::class);
    Route::get('/create/bussines', CreateBussines::class);
    Route::get('/logout/user', 'App\Http\Controllers\Controller@logout');



    //Rutas por Hector
    //Instituciones
    Route::get('/instituciones', InstitucionesComponent::class);


});







//Route::get('/', function () {
//    return view('welcome');
//});
