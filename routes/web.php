<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\RolesComponet;
use App\Livewire\PermissionComponent;
use App\Livewire\AsisComponent;
use App\Livewire\UserComponent;
use App\Livewire\LoginComponent;

use App\Livewire\Instituciones\InstitucionesComponent;
use App\Livewire\Medicamentos\MedicamentosComponent;

//use App\Livewire\All;
use App\Livewire\CreateBussines;
use App\Livewire\DocumentsCompanyComponent;
use App\Livewire\HomeComponent;
use App\Livewire\ListCompanyComponent;
use App\Livewire\RegisterComponent;
use App\Livewire\RegisterDistribuidorComponent;
use App\Livewire\RequisitosComponents;
use App\Livewire\FamilyComponent;
use App\Livewire\FichaTecnicaComponent;
use App\Livewire\GroupRequisitosFamily;
use League\CommonMark\Node\Block\Document;

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
//Route::get('/usuarios', UserComponent::class);
Route::get('/fichatecnica', FichaTecnicaComponent::class);

Route::get('/', LoginComponent::class)->name('login');
Route::get('/roles', RolesComponet::class);
Route::middleware(['auth'])->group(function () {

    Route::get('/usuarios', UserComponent::class);
    Route::get('/permisos', PermissionComponent::class);
    Route::get('/asignar/permisos', AsisComponent::class);
    Route::get('/create/bussines', CreateBussines::class);
    Route::get('/logout/user', 'App\Http\Controllers\Controller@logout');
    Route::get('/requisitos', RequisitosComponents::class);
    Route::get('/families/products', FamilyComponent::class);
    Route::get('/family/group', \App\Livewire\GroupFamilyComponent::class);
    Route::get('/rquisitos/group', GroupRequisitosFamily::class);
    //Rutas por Hector
    Route::get('/instituciones', InstitucionesComponent::class);
    Route::get('/medicamentos', MedicamentosComponent::class);
});

Route::get('/home', HomeComponent::class);
Route::get('/register', RegisterComponent::class);
Route::get('/registerDistribuidor', RegisterDistribuidorComponent::class);
Route::get('/listCompany', ListCompanyComponent::class);
Route::get('/DocumentsCompany', DocumentsCompanyComponent::class);
//Route::get('/fichatecnica', FichaTecnicaComponent::class);





//Route::get('/DocumentsValidation', DocumentsValidationComponent::class);


//Route::get('/', function () {
//    return view('welcome');
//});


