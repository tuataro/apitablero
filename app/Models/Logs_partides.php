<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs_partides extends Model
{
    use HasFactory;
    protected $fillable = ['id','id_partida','sessid','moviment','obstacle','res'];
}
