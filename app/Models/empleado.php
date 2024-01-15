<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class empleado extends Model
{
    use HasFactory;
    protected $table = 'empleado';
    protected $primaryKey = 'id_empleado';
    public $timestamps = false;


    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre', 'LIKE', "%$termino%")->where('estado',1);
    }

}
