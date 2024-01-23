<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class combustible extends Model
{
    use HasFactory;
    protected $table = 'combustible';
    protected $primaryKey = 'id_combustible';
    public $timestamps = false;
}
