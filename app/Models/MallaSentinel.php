<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MallaSentinel extends Model
{
    protected $table = 'RSG_CARGA_SENTINEL';
    protected $PrimaryKey = 'ID';
    use HasFactory;
}
