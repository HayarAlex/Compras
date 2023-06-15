<?php

namespace Liffe\Compras\App\Models\Mysql;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\App\Http\Traits\HasCompositePrimaryKey;
use Phantom\app\Http\Traits\SaveToUpper;

class Zone extends Model
{
    protected $connection = 'zonas';
    protected $table      = 'dm_maestro_zonas_prueba2';
    public $incrementing  = false;
}
