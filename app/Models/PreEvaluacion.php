<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreEvaluacion extends Model
{
    protected $table = 'RSG_PREEVALUADOR';
    protected $primaryKey = 'CODPREEVALUADOR'; // Debe ser en minúsculas
    use HasFactory;
}
