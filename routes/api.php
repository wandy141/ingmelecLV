<?php

use App\Http\Controllers\alquiler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentaController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\TipoVehiculoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\RecibirController;
use App\Http\Controllers\RegistrarseController;
use App\Http\Controllers\ControlController;

use App\Http\Controllers\usuarioToken;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


route::get('/getDepartamento', [ControlController::class, 'getDepartamento']);


route::get('/empleado', [ControlController::class, 'getChoferes']);
route::post('/getControl', [ControlController::class, 'getEditReportes']);
route::post('/editarReportes', [ControlController::class, 'editarReportes']);
route::post('/peticion', [ControlController::class, 'metodoDelControlador']);
route::post('/control', [ControlController::class, 'insertarControl']);
 route::post('/vehiculoid', [ControlController::class, 'vehiculoId']);
 route::post('/vehiculofi', [ControlController::class, 'vehiculoFi']);
 route::post('/vehiculoPlaca', [ControlController::class, 'vehiculoPlaca']);
 route::post('/vehiculoFicha', [ControlController::class, 'vehiculoFicha']);
 route::post('/buscarUsuariosId', [ControlController::class, 'buscarUsuarios']);
 route::post('/buscarEmpleados', [ControlController::class, 'buscarEmpleados']);
 route::post('/insertarUsuario', [ControlController::class, 'insertarUsuario']);
 route::post('/insertarEmpleado', [ControlController::class, 'insertarEmpleado']);
 

 route::post('/login', [LoginController::class, 'login']);

 route::post('/filtroBrigada', [ReporteController::class, 'buscarPorBrigada']);
 route::post('/filtroFecha', [ReporteController::class, 'buscarPorRangoDeFechas']);
 route::post('/filtroBrigadano', [ReporteController::class, 'buscarPorBrigadaNo']);
 route::post('/filtroFechano', [ReporteController::class, 'buscarPorRangoDeFechasNo']);
 route::post('/filtroPlaca', [ReporteController::class, 'filtrarPlaca']);
 Route::post('/filtroFechaPlaca', [ReporteController::class, 'filtroFechaPlaca']);

 route::get('/todoReporte', [ReporteController::class, 'getReportes']);
 route::get('/combustible', [ReporteController::class, 'combustibles']);

 route::get('/sectores', [DashController::class, 'sectores']);

 route::post('/insertarSectores', [DashController::class, 'insertarSectores']);
 route::post('/consumosMensuales', [DashController::class, 'consumosMensuales']);
 route::post('/inserComb', [DashController::class, 'insertarComb']);
 route::post('/insertarVehiculo', [DashController::class, 'insertarVehiculo']);
 Route::delete('/eliminar/{id}', [DashController::class, 'eliminar']);

 
 


 



















// route::post('/nombreUser', [usuarioToken::class, 'getNombre']);

// route::post('/login', [RentaController::class, 'login']);
// route::post('/users', [RentaController::class, 'usuarios']);
// route::post('/users/id', [RentaController::class, 'usuarioid']);
// route::post('/storeUser', [RentaController::class, 'storeUser']);
// route::post('/tokenExpiration', [RentaController::class, 'expira']);
// route::delete('/eliminarUser/{usuarioid}', [RentaController::class, 'destroyUser']);

// route::post('/storeVehiculos', [VehiculoController::class, 'storeVehiculo']);
// route::get('/allVehiculo', [VehiculoController::class, 'mostrarVehiculo']);
// route::post('/idVehiculo', [VehiculoController::class, 'idVehiculo']);

// route::get('/tipoEconomico', [VehiculoController::class, 'economico']);
// route::get('/tipoLujo', [VehiculoController::class, 'lujo']);
// route::get('/tipoCompacto', [VehiculoController::class, 'compacto']);
// route::get('/tipoNormal', [VehiculoController::class, 'normal']);
// route::get('/tipoPremium', [VehiculoController::class, 'premium']);
// route::get('/tipoCamion', [VehiculoController::class, 'camion']);
// route::get('/vehiculoInactivo', [VehiculoController::class, 'vehiculoInactivo']);
// route::get('/vehiculoMantenimiento', [VehiculoController::class, 'vehiculoMantenimiento']);


// route::get('/bajoPrecio', [VehiculoController::class, 'bajoPrecio']);
// route::get('/medioPrecio', [VehiculoController::class, 'medioPrecio']);
// route::get('/mayorPrecio', [VehiculoController::class, 'mayorPrecio']);

// route::post('/tipoVehiculos', [TipoVehiculoController::class, 'tipoVehiculo']);
// route::post('/tipoId', [TipoVehiculoController::class, 'tipoid']);
// route::post('/tipoAll', [TipoVehiculoController::class, 'todoTipo']);

// route::post('/alquiler', [alquiler::class, 'alquiler']);
// route::get('/todoAlquiler', [alquiler::class, 'todoAlquiler']);
// route::get('/vencieron', [alquiler::class, 'vencieron']);
// route::get('/casiUno', [alquiler::class, 'casiUno']);
// route::get('/casiDo', [alquiler::class, 'casiDo']);
// route::get('/casiTre', [alquiler::class, 'casiTre']);
// route::get('/carrosActivos', [alquiler::class, 'carrosActivos']);
// route::get('/bajoPrecioAc', [alquiler::class, 'bajoPrecio']);
// route::get('/medioPrecioAc', [alquiler::class, 'medioPrecio']);
// route::get('/mayorPrecioAc', [alquiler::class, 'mayorPrecio']);
// route::get('/AlquilerActivo', [alquiler::class, 'AlquilerActivo']);
// route::delete('/eliminarAlquiler/{idalquiler}', [alquiler::class, 'destroyAlquiler']);

// route::post('/cliente', [ClienteController::class, 'cliente']);
// route::post('/clienteId', [ClienteController::class, 'clienteId']);
// route::get('/todoCliente', [ClienteController::class, 'todoCliente']);


// route::post('/Imagen', [VehiculoController::class, 'Imagen']);

// route::post('/InsertEntrega', [EntregaController::class, 'entregaInsert']);



// route::post('/InsertRecibir', [RecibirController::class, 'RecibirInsert']);
// route::get('/todoRecibir', [RecibirController::class, 'todoRecibir']);

// route::get('/todoMantenimiento', [MantenimientoController::class, 'todoMantenimiento']);
// route::post('/insertarMantenimiento', [MantenimientoController::class, 'insertarMantenimiento']);

// route::post('/ActivarCarro', [MantenimientoController::class, 'ActivarCarro']);


// route::post('/insertarRegistro', [RegistrarseController::class, 'InsertarRegistro']);

// Route::post('/verificarUsuarioExistente', [RegistrarseController::class, 'verificarUsuarioExistente']);
// route::post('/buscarAutosDisponibles', [VehiculoController::class, 'buscarAutosDisponibles']);
// route::post('/economicoWeb', [VehiculoController::class, 'economicoWeb']);
// route::post('/compactoWeb', [VehiculoController::class, 'compactoWeb']);
// route::post('/premiumWeb', [VehiculoController::class, 'premiumWeb']);
// route::post('/lujoWeb', [VehiculoController::class, 'lujoWeb']);
// route::post('/normalWeb', [VehiculoController::class, 'normalWeb']);
// route::post('/camionWeb', [VehiculoController::class, 'camionWeb']);

// route::post('/insertarPago', [PagoController::class, 'insertarPago']);
