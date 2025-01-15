<?php

use App\Livewire\DocumentsValidationComponent;
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


Route::get('/', LoginComponent::class)->name('login');
Route::get('/roles', RolesComponet::class);

Route::middleware(['auth'])->group(function () {
    Route::get('/usuarios', UserComponent::class);
    Route::get('/permisos', PermissionComponent::class);
    Route::get('/asignar', AsisComponent::class);
    Route::get('/create/bussines', CreateBussines::class);
    Route::get('/logout/user', 'App\Http\Controllers\Controller@logout');
    Route::get('/requisitos', RequisitosComponents::class);
    Route::get('/families/products', FamilyComponent::class);
    Route::get('/family/group', \App\Livewire\GroupFamilyComponent::class);
    Route::get('/rquisitos/group', GroupRequisitosFamily::class);
    //Rutas por Hector
    Route::get('/instituciones', InstitucionesComponent::class);
    Route::get('/medicamentos', MedicamentosComponent::class);
    Route::get('/listCompany', ListCompanyComponent::class);
    Route::get('/configuracion/ficha/tecnica', \App\Livewire\ConfigRequisitos::class);
    Route::get('/configuracion/ficha/admin', \App\Livewire\FichaAdminComponent::class);
    Route::get('/event/config', \App\Livewire\EventsConfig::class);
    //    Route::get('/companies/dashboard', \App\Livewire\DashboardCompanies::class);
});

Route::middleware(['auth:company'])->group(function () {
    // Your routes here

    Route::get('/companies/dashboard', \App\Livewire\DocumentsCompanyComponent::class);
    Route::get('/fichatecnica', FichaTecnicaComponent::class);
    Route::get('/precalificacion/company', \App\Livewire\PreCalificacionTecnica::class);
});

Route::get('/documents/validation/{id}', \App\Livewire\PreCalificacionTecnicaDetail::class);
Route::get('/recepcion/doc/eval/{id}/{idCompany}', \App\Livewire\RecepDocumentsDetailComponent::class);
Route::get('/documents/validation/pre/admin/{id}', \App\Livewire\DetailPrecaAdminComponent::class);

Route::get('/precalificacion/company/admin/{id}', \App\Livewire\PreCalificacionAdministrativa::class);
Route::get('/pre/calificacion/tecnica', \App\Livewire\ApplicationAdmin::class);
Route::get('/pre/calificacion/Administrativas', \App\Livewire\ListPrecAdminComponent::class);
Route::get('/recepcion/doc/list', \App\Livewire\RecepDocumentsListComponent::class);
Route::get('/companie/info/{id}', \App\Livewire\CompaniesDetailsComponents::class);


Route::get('/home', HomeComponent::class);
Route::get('/register', RegisterComponent::class);
Route::get('/registerDistribuidor', RegisterDistribuidorComponent::class);

//Route::get('/DocumentsCompany', DocumentsCompanyComponent::class);

Route::get('/messeger/success', \App\Livewire\MessagessSucces::class);


//Route::get('/fichatecnica', FichaTecnicaComponent::class);


//Route::get('/DocumentsValidation', DocumentsCompanyComponent::class);


//Route::get('/', function () {
//    return view('welcome');
//});
