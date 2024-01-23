<?php

namespace App\Http\Controllers;
use App\Models\usuario;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    function login(Request $request) {

        $request->validate([
            'id_usuario' => 'required|string', 
            'contrasena' => 'required|string',
        ]);
    
        
         $id_usuario = $request->input('id_usuario');
         $contrasena = $request->input('contrasena');
   

        $consulta = usuario::where('id_usuario', $id_usuario)
        ->where('contrasena', $contrasena)
        ->whereIn('rol', [0, 1, 2, 3])
        ->first();
    
    if ($consulta) {
        $rol = $consulta->rol;
        $resultado = true;
        $retorno = (object) array('resultado' => $resultado,'id_usuario' => $id_usuario,'rol' => $rol);
    } else {
        $resultado = false;
    $retorno = (object) array('resultado' => $resultado);
    
    }
    return response()->json($retorno);
    
    }

 


 
    
    }
 