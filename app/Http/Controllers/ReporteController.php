<?php

namespace App\Http\Controllers;
use App\Models\all;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\control;
use App\Models\combustible;

class ReporteController extends Controller
{



    //     public function getReportes()
    //  {
    //     $carros = control::where('estado',1);

    //     return response()->json($carros);
    //  }


     public function buscarPorBrigada(Request $datai)
     {
    
 
     
        $brigada = $datai->input('id_sector');
        $orden = $datai->input('orden');
        $dias_anteriores = $datai->input('dias_anteriores');
  
        $query = control::where('id_sector', $brigada)->where('estado', 1)
        ->orderBy('combustible', $orden);
    
        if ($dias_anteriores !== null) {
            $fechaLimite = now()->subDays($dias_anteriores);
            $query->whereDate('fecha', '>=', $fechaLimite);
        }
    
        $resultado = $query->get();
    
        return response()->json($resultado);
     }



function combustibles()  {
   
$consulta = combustible::all();
return response()->json($consulta);


}

public function buscarPorRangoDeFechas(Request $datai)
{
    $brigada = $datai->input('id_sector');
    $orden = $datai->input('orden');
    $fechaInicio = $datai->input('fechaIni');
    $fechaFin = $datai->input('fechaFin');

   $query = Control::where('id_sector', $brigada)->where('estado', 1)
    ->orderBy('combustible', $orden);

if ($fechaInicio !== null && $fechaFin !== null) {
    $fechaInicio = Carbon::parse($fechaInicio);
    $fechaFin = Carbon::parse($fechaFin);

    // Filtrar por rango de fechas
   $query->where(function ($query) use ($fechaInicio, $fechaFin) {
        $query->whereDate('fecha', '>=', $fechaInicio)
            ->whereDate('fecha', '<=', $fechaFin);
    });
}


$resultado = $query->get();
$fechaInicioFormateada = $fechaInicio->format('d/m/Y');
$fechaFinFormateada = $fechaFin->format('d/m/Y');

   return response()->json(['fechaInicio' => $fechaInicioFormateada, 'fechaFin' => $fechaFinFormateada, 'resultado' => $resultado]);
}



public function buscarPorRangoDeFechasNo(Request $datai)
{
    $brigada = $datai->input('id_sector');
    $orden = $datai->input('orden');
    $fechaInicio = $datai->input('fechaIni');
    $fechaFin = $datai->input('fechaFin');

   $query = Control::where('id_sector', $brigada)
    ->orderBy('combustible', $orden);

if ($fechaInicio !== null && $fechaFin !== null) {
    $fechaInicio = Carbon::parse($fechaInicio);
    $fechaFin = Carbon::parse($fechaFin);

    // Filtrar por rango de fechas
   $query->where(function ($query) use ($fechaInicio, $fechaFin) {
        $query->whereDate('fecha', '>=', $fechaInicio)
            ->whereDate('fecha', '<=', $fechaFin);
    });
}




$resultado = $query->get();
$fechaInicioFormateada = $fechaInicio->format('d/m/Y');
$fechaFinFormateada = $fechaFin->format('d/m/Y');

   return response()->json(['fechaInicio' => $fechaInicioFormateada, 'fechaFin' => $fechaFinFormateada, 'resultado' => $resultado]);
}


  public function buscarPorBrigadaNo(Request $datai)
     {
    
 
     
        $brigada = $datai->input('id_sector');
        $orden = $datai->input('orden');
        $dias_anteriores = $datai->input('dias_anteriores');
  
        $query = control::where('id_sector', $brigada)
        ->orderBy('combustible', $orden);
    
        if ($dias_anteriores !== null) {
            $fechaLimite = now()->subDays($dias_anteriores);
            $query->whereDate('fecha', '>=', $fechaLimite);
        }
    
        $resultado = $query->get();
    
        return response()->json($resultado);
     }




     public function filtroFechaPlaca(Request $request) {

      


        $placa = $request->input('placa');
        $estado = $request->input('estado');
        $fechaInicio = Carbon::parse($request->input('fechaInicio'));
        $fechaFin = Carbon::parse($request->input('fechaFin'));
        
        
        $consulta = control::where(function($query) use ($placa) {
            $query->where('placa', $placa)
                ->orWhere('ficha_vehiculo', $placa);
         })
        ->where('estado', $estado)
        ->orderBy('combustible', 'desc');
    
        if ($fechaInicio !== null && $fechaFin !== null) {
            $fechaInicio = Carbon::parse($fechaInicio);
            $fechaFin = Carbon::parse($fechaFin);
    
            $consulta->where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereDate('fecha', '>=', $fechaInicio)
                    ->whereDate('fecha', '<=', $fechaFin);
            });
        }
    
        $resultado = $consulta->get();
        
        return response()->json($resultado);
    }
    
    







   public function filtrarPlaca(Request $request)   {
   
    
    $placa = $request->input('placa');
    $dias_anteriores = $request->input('dias_anteriores');
    $estado = $request->input('estado');
    
    $consulta = control::where(function($query) use ($placa) {
        $query->where('placa', $placa)
          ->orWhere('ficha_vehiculo', $placa);
     })
    ->where('estado', $estado)
    ->orderBy('combustible', 'desc');

    if ($dias_anteriores !== null) {
        $fechaLimite = now()->subDays($dias_anteriores);
        $consulta->whereDate('fecha', '>=', $fechaLimite);
    }

$resultado = $consulta->get();
    
    return response()->json($resultado);
    
    
 }




}