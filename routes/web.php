<?php

use App\Events\ChatEvent;
use App\Http\Controllers\APIController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\CotizadorController;
use App\Http\Controllers\ImageProxyController;
use App\Http\Controllers\SellerController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\NotificacionesController;
use App\Http\Controllers\TemporalImageUrlController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/loginEmail', [LoginController::class, 'loginWithLink'])->name('loginWithLink');
Route::get('/loginPunchOut',  [APIController::class, 'loginPunchOut']);
Route::post('/broadcasting/auth', function () {
    return Auth::check() ? Auth::user() : abort(401);
})->middleware('web');


Route::get('/load-external-image', [ImageProxyController::class, 'loadExternalImage']);
Route::post('/temporal-image', [TemporalImageUrlController::class, 'saveImage']);
Route::get('/example-pdf', [CotizacionController::class, 'examplePDF']);

Route::middleware(['auth'])->group(function () {
    Route::get('/', [CotizadorController::class, 'index'])->name('index');
    Route::get('/filter-category/{category}', [CotizadorController::class, 'categoryfilter'])->name('categoryfilter');
    Route::get('/catalogo', [CotizadorController::class, 'catalogo'])->name('catalogo');
    Route::get('/catalogo/{product}', [CotizadorController::class, 'verProducto'])->name('show.product');
    Route::get('/mis-compras', [CotizadorController::class, 'cotizaciones'])->name('compras');
    Route::get('/mis-muestras', [CotizadorController::class, 'muestras'])->name('muestras');
    Route::get('/carrito', [CotizadorController::class, 'cotizacion'])->name('cotizacion');
    Route::get('/carrito/muestra/{id}', [CotizadorController::class, 'procesoMuestra'])->name('procesoMuestra');

    Route::get('/mis-cotizaciones', [CotizadorController::class, 'misCotizaciones'])->name('misCotizaciones');


    Route::get('/compra/{quote}', [CotizadorController::class, 'verCotizacion'])->name('verCotizacion');
    Route::get('/finalizar-compra', [CotizadorController::class, 'finalizar'])->name('finalizar');
    Route::post('/enviar-compra', [CotizadorController::class, 'enviarCompra'])->name('enviar-compra');
    Route::get('/exportUsuarios', [CotizadorController::class, 'exportUsuarios'])->name('exportUsuarios.cotizador');

    Route::get('/eliminar-notificacion', [NotificacionesController::class, 'eliminar_notificaciones'])->name('eliminar_notificaciones');
    Route::get('/cerrar-notificacion/{notificacion_id}', [NotificacionesController::class, 'cerrar_notificacion'])->name('cerrar_notificacion');
    //Route Hooks - Do not delete//
    Route::prefix('administrador')->group(function () {
        Route::get('/', [CotizadorController::class, 'administrador'])->name('administrador');
        Route::get('/compras', [CotizadorController::class, 'administradorcompras'])->name('administradorcompras');
        Route::get('/pedidos', [CotizadorController::class, 'administradorpedidos'])->name('administradorpedidos');
        Route::get('/pagina-anterior', function () {
            return redirect()->back();
        })->name('pagina-anterior');
    });
    Route::prefix('seller')->group(function () {
        Route::get('/', [SellerController::class, 'index'])->name('seller.index');
        Route::get('/content', [SellerController::class, 'content'])->name('seller.content');
        Route::get('/muestras', [SellerController::class, 'muestras'])->name('seller.muestras');
        Route::get('/soporte', [SellerController::class, 'soporte'])->name('seller.soporte');
        Route::get('/pedidos', [SellerController::class, 'pedidos'])->name('seller.pedidos');
        Route::get('/compradores', [SellerController::class, 'compradores'])->name('seller.compradores');
        Route::get('/compradores/{id}', [CotizadorController::class, 'infoperfil'])->name('perfil');
    });
    Route::prefix('admin')->middleware(['role:admin'])->group(function () {
        Route::get('/sa', [CotizadorController::class, 'dashboard'])->name('dashboard');
        Route::get('/', [CotizadorController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/compras', [CotizadorController::class, 'all'])->name('all.cotizacion');
        Route::get('/users/{id}', [CotizadorController::class, 'infoperfil'])->name('infoperfil');
        Route::view('importTechniques', 'livewire.import-techniques.index')->middleware('auth');
        Route::view('materials', 'livewire.materials.index')->middleware('auth');
        Route::view('sizes', 'livewire.sizes.index')->middleware('auth');
        Route::view('prices', 'livewire.prices.index')->middleware('auth');
        Route::view('users', 'livewire.users.index')->middleware('auth');
        // Route::view('muestra', 'livewire.muestras.index')->middleware('auth');
        Route::view('muestras', 'livewire.companies.index')->middleware('auth');
        Route::get('/settings', [CotizadorController::class, 'settings'])->name('settings');
    });
    
    Route::post('/generar-cotizacion', [CotizacionController::class, 'generarPDF'])->name('generarPDF');
    Route::post('/descargar-cotizacion', [CotizacionController::class, 'downloadPDF'])->name('downloadPDF');
});
