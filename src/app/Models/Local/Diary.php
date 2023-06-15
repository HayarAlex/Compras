<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\app\Http\Traits\SaveToUpper;

class Diary extends Model
{
    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'diaryreg';
    protected $primaryKey = 'codigonew';//refreshmed se cambio el idmed por ese campo para el buscador del controlador

    protected $alias = [
        'idmed as idm',
        'codigonew as cnew',
        'coduneg as cneg',
        'desuneg as dneg',
        'patemed as patm',
        'matemed as matm',
        'nombmed as nomm',
        'diremed as dirm',
        'telemed as telm',
        'codclup as cupm',
        'sexomed as sexm',
        'fenamed as fenm',
        'cotimed as ctpm',
        'tipomed as tipm',
        'coesmed as cesm',
        'espemed as espm',
        'cozomed as czom',
        'zonamed as zonm',
        'origenmed as orgm',
        'catmed as cmed'
    ];
    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->idmed = Diary::max('idmed') + 1;
        });
    }
}
