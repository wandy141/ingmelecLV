<?php

namespace App\Http\Controllers;
use App\Models\control;
use App\Models\vehiculos;
use App\Models\chofer;
use App\Models\empleado;
use App\Models\combustible;
use App\Models\usuario;
use App\Models\departamento;
use App\Models\sectores;

use Carbon\Carbon;

use Illuminate\Http\Request;

class ControlController extends Controller
{
    function insertarControl(Request $data)
    {
        try {

            $datos = (object) $data;
            $control = (object) $datos->control;
    
            // Crear una nueva instancia de control
            $nuevoControl = new control();
    
            $vehiculo = Vehiculos::where('placa', $control->placa)->first();

            if ($vehiculo) {
                $nuevoControl->ficha_vehiculo = $vehiculo->ficha; 
            } 


            // Asignar los valores del control
            $nuevoControl->id_control = $control->id_control;
            $nuevoControl->fecha = $control->fecha;
            $nuevoControl->placa = $control->placa;
            $nuevoControl->nombre_comb = $control->nombre_comb;
            $nuevoControl->combustible = $control->combustible;
            $nuevoControl->precio_combustible = $control->precio_combustible;
            $nuevoControl->precio_galon = $control->precio_galon;
            $nuevoControl->kilometraje = $control->kilometraje;
            $nuevoControl->kilometraje_act = $control->kilometraje_act;
            $nuevoControl->kilometraje_pro = $control->kilometraje_pro;
            $nuevoControl->descripcion = $control->descripcion;
            $nuevoControl->id_chofer = $control->id_chofer;
            $nuevoControl->id_usuario = $control->id_usuario;
            $nuevoControl->id_sector = $control->id_sector;
            $nuevoControl->consumo_vehiculo = $control->consumo_vehiculo;
            $nuevoControl->estado = 0;


            
    
            $id_chofer = $control->id_chofer;

            $chofer = empleado::find($id_chofer);
            
            if ($chofer) {
                $nuevoControl->nombre_chofer = $chofer->nombre;
            } else {

            }

            // Actualizar el kilometraje del vehículo
            vehiculos::where('placa', $control->placa)->update(['kilometraje' => $control->kilometraje_act]);
    
            // Guardar el nuevo control en la base de datos
            $resultado = $nuevoControl->save();
            $id = $nuevoControl->id_control;
    
            // Obtener el registro actual
            $registroActual = control::find($id);
    
            // Obtener el registro anterior
            $registroAnterior = control::where('id_control', '<', $id)->orderBy('id_control', 'desc')->first();
    
            if ($registroAnterior) {
                // Calcular la diferencia de kilómetros




             
               //tengo que cambiar el 51 por la varibla que viene del vehiculo por consumo de fabricante
                $diferenciaKilometros = $registroActual->kilometraje_act - $registroAnterior->kilometraje_act;
            

                $registroAnterior->update(['kilometraje_rec' => $diferenciaKilometros, 'estado' => 1 ]);
                $registroAnterior->update([ 'diferencia_km' => $registroAnterior->kilometraje_pro - $registroAnterior->kilometraje_rec]); 
                return response()->json(['message' => ' correctamente','resultado' => $resultado]);
            } else {
                return response()->json(['message' => 'No hay registros anteriores para calcular la diferencia de kilómetros']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar la diferencia de kilómetros', 'error' => $e->getMessage()], 500);
        }
    }
    


//traer todo el objeto de vehiculo por id
public function vehiculoId(Request $datai)
{
    $data=(object) $datai;
    $vehiculo = $data->placa;

    $consulta = Vehiculos::where('placa', $vehiculo)
    ->where('estado', 1)
    ->first();    
    return response()->json($consulta);
}

public function vehiculoFi(Request $datai)
{
    $data = (object) $datai;
    $vehiculo = $data->ficha;
    
    $consulta = Vehiculos::where('ficha', $vehiculo)->where('estado',1)->first() ; 
    
    return response()->json($consulta);
    
}



public function vehiculoPlaca(Request $datai)
{
    $data=(object) $datai;
    $vehiculo = $data->placa;

    $consulta = Vehiculos::where('placa', $vehiculo)->first();    
    return response()->json($consulta);
}

public function vehiculoFicha(Request $datai)
{
    $data = (object) $datai;
    $vehiculo = $data->ficha;
    
    $consulta = Vehiculos::where('ficha', $vehiculo)->first() ; 
    
    return response()->json($consulta);
    
}






function getChoferes(){
    $consulta = empleado::all();
    return response()->json($consulta);

}


public function metodoDelControlador(Request $request)
    {
        $termino = $request->input('peticion');

        // Verifica si el término de búsqueda está presente
        if ($termino) {
            // Utiliza el método de ámbito para buscar en la base de datos
            $resultados = empleado::buscar($termino)->get();

            return response()->json($resultados);
        } else {
            $resultados = [];
            return response()->json($resultados);
        }
    }



    

    

//editar reportes

function editarReportes(Request $request)   {
    

    $data = (object)$request;
    $control = (object)$data->control;

    $objId = control::find($control->id_control); 
    if ($objId){
        $placa = $objId->placa;
        $vehiculo = vehiculos::find($placa);

        if ( $vehiculo) {
    $idTipoCombustible = $vehiculo->id_tipocomb;
    $tipoCombustible = Combustible::find($idTipoCombustible);


    if ($tipoCombustible) {
        $precioCombustible = $tipoCombustible->precio_galon;

        $precio = $precioCombustible * $control->combustible;

        $objId->descripcion = $control->descripcion;
        $objId->combustible = $control->combustible;
        $objId->id_chofer = $control->id_chofer;
        $objId->nombre_chofer = $control->nombre_chofer;
        $objId->precio_galon = $precio;
        $objId->id_sector = $control->id_sector;
     
    }

}

    $resultado = $objId->save();
    return response()->json($resultado);


        }

    }

public function getEditReportes(Request $request){
    $usuario = $request->input('usuario');
    $zonaHorariaRD = 'America/Santo_Domingo';

    $consulta = Control::where('fecha', '>=', Carbon::now($zonaHorariaRD)->subDay())
    ->where('id_usuario', $usuario)
    ->orderBy('fecha', 'desc')
    ->get();

    foreach ($consulta as $control) {
        // Obtener el nombre del sector utilizando el id_sector
        $sector = Sectores::where('id_sector', $control->id_sector)->first();

        // Agregar el nombre del sector al resultado
        $control->nombre_sector = $sector ? $sector->nombre_sec : null;
    }


    return response()->json($consulta);

}



    public function buscarUsuarios(Request $datai)
{
    $data=(object) $datai;
    $usuario = $data->id_usuario;

    $consulta = usuario::find($usuario);    
    return response()->json($consulta);
}




public function buscarEmpleados(Request $datai)
{
    $data=(object) $datai;
    $empleado = $data->id_empleado;

    $consulta = empleado::find($empleado);    
    return response()->json($consulta);
}




public function insertarUsuario(Request $request)  {
    $data = $request->all();
    $usuario = (object) $data['usuario'];

    $objId = usuario::find($usuario->id_usuario);

    if ($objId == null) {
        $objId = new usuario();
        $objId->id_usuario = $usuario->id_usuario;
        $objId->contrasena = $usuario->contrasena;
        $objId->nombre_empleado = $usuario->nombre_empleado;
        $objId->id_empleado = $usuario->id_empleado;
        $objId->rol = $usuario->rol;
    } else {
        $objId->contrasena = $usuario->contrasena;
        $objId->nombre_empleado = $usuario->nombre_empleado;
        $objId->id_empleado = $usuario->id_empleado;
        $objId->rol = $usuario->rol;
    }

    $resultado = $objId->save();
    return response()->json($resultado);
}


public function insertarEmpleado(Request $request)  {
    $data = $request->all();
    $empleado = (object) $data['empleado'];

    $objId = empleado::find($empleado->id_empleado);

    if ($objId == null) {
        $objId = new empleado();
        $objId->id_empleado = $empleado->id_empleado;
        $objId->nombre = $empleado->nombre;
        $objId->cedula = $empleado->cedula;
        $objId->cargo = $empleado->cargo;
        $objId->ingreso = $empleado->ingreso;
        $objId->nacimiento = $empleado->nacimiento;
        $objId->id_departamento = $empleado->id_departamento;
        $objId->estado = $empleado->estado;
    } else {
        $objId->nombre = $empleado->nombre;
        $objId->cedula = $empleado->cedula;
        $objId->cargo = $empleado->cargo;
        $objId->ingreso = $empleado->ingreso;
        $objId->nacimiento = $empleado->nacimiento;
        $objId->id_departamento = $empleado->id_departamento;
        $objId->estado = $empleado->estado;
    }

    $resultado = $objId->save();
    return response()->json($resultado);
}

function getDepartamento() {
    
$consulta = departamento::all();
return response()->json($consulta);


}

}