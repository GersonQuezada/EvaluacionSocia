<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreEvaluacion extends Model
{
    protected $table = 'RSG_PREEVALUADOR';
    protected $primaryKey = 'CODPREEVALUADOR';
    public $timestamps = false;
    use HasFactory;


    protected $fillable = [
        'nombrecompleto',
        'dni',
        'bancocomunal',
        'fecha',
        'asesor',
        'monto',
        'plazo',
        'cuota',
        'nivelriesgo',
        'subneto',
        'deudaexterna',
        'ingresoneto',
        'capacidadpago',
        'CODREGION',
        'fechamodificada',
        'fechamodi_actual',
        'FECHAVIGENCIA'
    ];
}
