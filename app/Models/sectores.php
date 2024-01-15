<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sectores extends Model
{
    use HasFactory;
    protected $table = 'sector';
    protected $primaryKey = 'id_sector';
    public $timestamps = false;

}
