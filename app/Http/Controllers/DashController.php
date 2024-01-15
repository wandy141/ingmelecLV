<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\combustible;
use App\Models\sectores;
use App\Models\vehiculos;
use Illuminate\Support\Facades\DB;

class DashController extends Controller
{

function insertarComb(Request $request)  {
    $data = (object)$request;
    $combustible = (object)$data->combustible;

    $objId = combustible::find($combustible->id_combustible); 
    

    if ($objId == null){
        $objId = new combustible();
        $objId->id_combustible = $combustible->id_combustible;
        $objId->descripcion = $combustible->descripcion;
        $objId->precio_galon = $combustible->precio_galon;
     
    
    } else{
        $objId->id_combustible = $combustible->id_combustible;
        $objId->descripcion = $combustible->descripcion;
        $objId->precio_galon = $combustible->precio_galon;
    }

    $resultado = $objId->save();
    return response()->json($resultado);
}


public function eliminar($id)
{
    
    try {
        $recurso = combustible::find($id);
        if (!$recurso) {
            return response()->json(['mensaje' => 0], 404);
        }
        $recurso->delete();
        return response()->json(['mensaje' => 1]);
    } catch (\Exception $e) {
        return response()->json(['mensaje' => 5, 'error' => $e->getMessage()], 500);
    }
}


function sectores()  {

    $consulta = sectores::all();
    return response()->json($consulta);

}



public function insertarSectores(Request $request)  {
    $data = (object)$request;
    $sector = (object)$data->sector;

    $objId = sectores::find($sector->id_sector); 
    

    if ($objId == null){
        $objId = new sectores();
        $objId->id_sector = $sector->id_sector;
        $objId->nombre_sec = $sector->nombre_sec;
    
    } else{
        $objId->nombre_sec = $sector->nombre_sec;
    }

    $resultado = $objId->save();
    return response()->json($resultado);
}







public function insertarVehiculo(Request $request) {
    // Accede correctamente a los datos del request
    $data = $request->all();
    $vehiculoData = $data['vehiculos'];

    // Encuentra el vehículo por la placa
    $objVehiculo = vehiculos::find($vehiculoData['placa']);

    // Si no se encuentra, crea un nuevo vehículo
    if ($objVehiculo == null) {
        $objVehiculo = new vehiculos();
        $objVehiculo->placa = $vehiculoData['placa'];
    }

    // Actualiza o establece los demás datos del vehículo
    $objVehiculo->chasis = $vehiculoData['chasis'];
    $objVehiculo->ficha = $vehiculoData['ficha'];
    $objVehiculo->ano = $vehiculoData['ano'];
    $objVehiculo->marca = $vehiculoData['marca'];
    $objVehiculo->id_tipocomb = $vehiculoData['id_tipocomb'];
    $objVehiculo->consumo_vehiculo = $vehiculoData['consumo_vehiculo'];
    $objVehiculo->kilometraje = $vehiculoData['kilometraje'];
    $objVehiculo->id_sector = $vehiculoData['id_sector'];
    $objVehiculo->seguro = $vehiculoData['seguro'];
    $objVehiculo->polisa = $vehiculoData['polisa'];
    $objVehiculo->estado = $vehiculoData['estado'];

    // Guarda el vehículo
    $resultado = $objVehiculo->save();

    return response()->json($resultado);
}


// public function consumosMensuales(Request $request)
// {
//     $mes = $request->input('mes');

//     $consumos = DB::table('control')
//         ->select(
//             DB::raw('MONTH(fecha) as mes'),
//             DB::raw('SUM(combustible) as totalCombustible'),
//             DB::raw('SUM(precio_galon) as totalPrecioGalon')
//         )
//         ->whereRaw('MONTH(fecha) = ?', [$mes])
//         ->groupBy(DB::raw('MONTH(fecha)'))
//         ->get();

//     return response()->json($consumos);
// }




public function consumosMensuales(Request $request)
{
    $mes = $request->input('mes');

    // Obtener el año actual
    $anoActual = date('Y');

    // Obtener totales por sector
    $totalesPorSector = DB::table('control as c1')
        ->join('sector', 'c1.id_sector', '=', 'sector.id_sector')
        ->select(
            'sector.nombre_sec as nombre_sector',
            DB::raw('MONTHNAME(c1.fecha) as mes'),
            DB::raw('SUM(c1.combustible) as totalCombustible'),
            DB::raw('SUM(c1.precio_galon) as totalPrecioGalon')
        )
        ->whereRaw('YEAR(c1.fecha) = ?', [$anoActual]) // Filtrar por el año actual
        ->when($mes, function ($query, $mes) {
            return $query->whereRaw('MONTH(c1.fecha) = ?', [$mes]);
        })
        ->groupBy('sector.nombre_sec', DB::raw('MONTHNAME(c1.fecha)'));

    // Obtener total general
    $totalGeneral = DB::table('control as c2')
        ->select(
            DB::raw('"Total" as nombre_sector'),
            DB::raw('MONTHNAME(c2.fecha) as mes'),
            DB::raw('SUM(c2.combustible) as totalCombustible'),
            DB::raw('SUM(c2.precio_galon) as totalPrecioGalon')
        )
        ->whereRaw('YEAR(c2.fecha) = ?', [$anoActual]) // Filtrar por el año actual
        ->when($mes, function ($query, $mes) {
            return $query->whereRaw('MONTH(c2.fecha) = ?', [$mes]);
        })
        ->groupBy(DB::raw('MONTHNAME(c2.fecha)'));

    // Unir los resultados
    $resultados = $totalesPorSector->union($totalGeneral)->get();

    return response()->json($resultados);
}



}
