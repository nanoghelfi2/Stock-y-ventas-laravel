<?php

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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Rutas del carrito de compras
Route::get('chango/{id}',
            [App\Http\Controllers\ChangoController::class, 
            'paginaPrincipal'])->name('chango');

        //crea un nuevo chango
        Route::get('chango/crearChango/nuevoChango',
        [App\Http\Controllers\ChangoController::class, 
        'nuevoChango'])->name('chango.crear');
        //Agregar producto al chango
        Route::get('chango/agregarProducto/nuevoProducto/{id}',
        [App\Http\Controllers\ChangoController::class, 
        'agregarAlChango'])->name('chango.agregar.producto');
        //Borrar producto del chango
        Route::delete('chango/borrarDelChango/unProducto/{idChango}',
        [App\Http\Controllers\ChangoController::class, 
        'borrarProducto'])->name('chango.borrar.producto');


Route::put('chango/cambioCliente/{id}',    [App\Http\Controllers\ChangoController::class,  'cambiarCliente']) //Cambios de cliente
        ->name('chango.cambiar.cliente');
      

Route::put('chango/lugarTemporal/{id}',    [App\Http\Controllers\ChangoController::class,  'lugarTemporal']) //Lugar temporal
        ->name('chango.cambiar.lugarTemporal');
Route::put('chango/descuento/{id}',    [App\Http\Controllers\ChangoController::class,  'descuento']) //Lugar temporal
        ->name('chango.cambiar.descuento');       

Route::delete('chango/finalizar/{id}',    [App\Http\Controllers\ChangoController::class,  'finalizarVenta']) //Cambios de cliente
        ->name('chango.finalizar.venta');

Route::delete('chango/borrar/{item}',    [App\Http\Controllers\ChangoController::class,  'changoBorrar']) //Borrar un chango
        ->name('chango.borrar');

Route::put('chango/cambioEstado/{id}',    [App\Http\Controllers\ChangoController::class,  'cambioEstado']) //Cambio de estado del chango
        ->name('chango.cambioEstado');        

Route::get('chango/buscar/{idC}/{idP}',    [App\Http\Controllers\ChangoController::class,  'verProdCarrito']) //Cambio de estado del chango
        ->name('buscar.productos');          

        //Modal Carrito
        Route::get('chango/modal/modalNP',    [App\Http\Controllers\ChangoController::class,  'mostrarModal']) //Cambio de estado del chango
        ->name('chango.modalNP'); 


//Rutas del WONDERLIST (Lista de productos)
Route::get('wonderlist',
            [App\Http\Controllers\WonderlistController::class, 
            'allProducts'])->name('wonderlist');

Route::get('wonderlist/filtro/{marca?}',  [App\Http\Controllers\WonderlistController::class,   'allProducts'])
            ->name('wonderlist/filtro');

            //RUTAS DE AGREGAR
Route::get('wonderlist/agregar',  [App\Http\Controllers\WonderlistController::class,   'vistaAgregar'])
            ->name('wonderlist.agregar');

            Route::post('/wonderlist/agregar',    [App\Http\Controllers\WonderlistController::class,     'agregarWonderlist'])
            ->name('agregar.enviar');

            //RUTAS DE EDITAR
Route::get('wonderlist/editar/{item}',    [App\Http\Controllers\WonderlistController::class,  'vistaEditar'])
            ->name('wonderlist.editar');

            Route::put('wonderlist/editar/{item}',    [App\Http\Controllers\WonderlistController::class,  'editarWonderlist'])
            ->name('editar.enviar');

            //RUTAS DE BORRAR
Route::delete('wonderlist/borrar/{item}',    [App\Http\Controllers\WonderlistController::class,  'vistaBorrar'])
            ->name('wonderlist.borrar');

       
Route::get('wonderlist/modal/{id}',
            [App\Http\Controllers\WonderlistController::class, 
            'mostrarModal'])->name('wonderlist/modal');

            //RUTAS VER
Route::get('wonderlist/ver/{id}',
            [App\Http\Controllers\WonderlistController::class, 
            'verProducto'])->name('wonderlist.ver');

Route::get('wonderlist/pruebas/{marca?}/tipos',
            [App\Http\Controllers\WonderlistController::class, 
            'tiposAjax'])->name('wonderlist/pruebas');

            Route::get('wonderlist/productoPorID/{id}',
            [App\Http\Controllers\WonderlistController::class, 
            'traerDatosID'])->name('wonderlist/traerDatosID');
            
        
//RUTAS DE LAS VENTAS
Route::get('ventas', [App\Http\Controllers\VentaController::class, 'vistaVentas'])->name('ventas');
Route::get('ventas/venta/{id}', [App\Http\Controllers\VentaController::class, 'vistaVenta'])->name('venta');
Route::get('ventas/pruebas/ver', [App\Http\Controllers\VentaController::class, 'prueba']);
            

//RUTAS DE LOS CLIENTES
Route::get('clientes', [App\Http\Controllers\ClienteController::class, 'vistaCliente'])->name('clientes');

Route::get('clientes/modal/{id}', [App\Http\Controllers\ClienteController::class, 'modalCliente'])->name('modal');

Route::delete('clientes/borrar/{id}', [App\Http\Controllers\ClienteController::class, 'borrarCliente'])->name('cliente.borrar');
Route::post('clientes/agregar', [App\Http\Controllers\ClienteController::class, 'agregarCliente'])->name('cliente.agregar');
Route::put('clientes/editar/{id}', [App\Http\Controllers\ClienteController::class, 'editarCliente'])->name('cliente.editar');