<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\app\Http\Traits\SaveToUpper;

class Shoppedido extends Model
{
    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'shopped';
    protected $primaryKey = 'idshopped';

    protected $alias = [
        'idshopped as idsh',
        'codigosh as codsh',
        'descripcionsh as descsh',
        'unidadsh as unish',
        'cantidadsh as cansh',
        'fechareqsh as freqsh',
        'prioritysh as priosh',
        'tipopedsh as tpedsh',
        'detapedsh as dpedsh',
        'obsfrst as obsfsh',
        'obsscnd as obsssh',
        'arearevsh as arevsh',
        'respareash as raresh',
        'obsthrd as obstsh',
        'fechaatenlog as fatesh',
        'fecharegrev as farevsh',
        'fechaaprov as faprosh',
        'stateevprov as stenvsh',
        'statersprov as strespsh',
        'staterevlog as strevsh',
        'statearerev as starevsh',
        'staterevend as strfinsh',
        'statelog as stlo',
        'statesan as stsa',
        'stateinv as stin',
        'comentlog as comlog',
        'comentsan as comsan',
        'comentinv as cominv',
        'fechaenvp as fenvio',
        'fechainicio as finicio',
        'fecharesprov as frpro',
        'arearevlo as arlo',
        'arearevsa as arsa',
        'ffinc as fcal',
        'ffins as fsan',
        'ffinl as flog',
        'ffini as finv'.
        'hini as hini'
    ];
    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->idshopped = Shoppedido::max('idshopped') + 1;
        });
    }
}
