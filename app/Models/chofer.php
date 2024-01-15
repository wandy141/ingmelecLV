<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chofer extends Model
{
    use HasFactory;
    protected $table = 'chofer';
    protected $primaryKey = 'id_chofer';
    public $timestamps = false;


    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre', 'LIKE', "%$termino%");
    }

}
