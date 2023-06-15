<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\app\Http\Traits\SaveToUpper;

class Shoppeddet extends Model
{
    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'shoppedadd';
    protected $primaryKey = 'idshdet';

    protected $alias = [
        'idshdet as iddetsh',
        'idshped as peddetsh',
        'nameprov as namepsh',
        'detalleprov as detpsh',
        'cantaten as canatsh',
        'preciounit as presunish',
        'docrespprov as docprov',
        'fechaenvp as fenvp',
        'fecharesp as fresp',
        'incoterm as inco',
        'cuepa as cue',
        'ctepa as cte',
        'facimp as fim',
        'statecali as stcal',
        'statesani as stsan',
        'statelogi as stlog',
        'stateinve as stinv',
        'obcal as oca',
        'obsan as osa',
        'oblog as olo',
        'obinv as oin',
    ];
    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->idshdet = Shoppeddet::max('idshdet') + 1;
        });
    }
}
