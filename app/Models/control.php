<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class control extends Model
{
    use HasFactory;
    protected $table = 'control';
    protected $primaryKey = 'id_control';
    public $timestamps = false;

    protected $fillable = [
        'id_control',
        'fecha',
        'placa',
        'ficha_vehiculo',
        'combustible',
        'precio_galon',
        'kilometraje',
        'kilometraje_act',
        'descripcion',
        'id_chofer',
        'id_usuario',
        'idbrigada',
        'kilometraje_rec',
        'estado',
        'diferencia_km',
        'kilometraje_pro'
        ,];
}


