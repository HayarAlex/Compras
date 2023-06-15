<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\app\Http\Traits\SaveToUpper;

class Licitacion extends Model
{
    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'liadd';
    protected $primaryKey = 'idli';

    protected $alias = [
        'idli as idli',
        'idlicitacion as idlicit',
        'fechasoli as fsol',
        'codeneg as cneg',
        'codenegdesc as cndesc',
        'codeart as cart',
        'codeartdesc as cadesc',
        'cantreq as creq',
        'respuesta as res',
        'fechacon as fcon',
        'fechaentr as fent',
        'adjudicacion as adj',
        'stateli as stateli',
        'respcom as rcom',
        'probad as probad',
        'stateresi as stri'
    ];
    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->idli = Licitacion::max('idli') + 1;
        });
    }
    public function scopeActives($query, $find)
    {
        $find = strtoupper($find);
        return $query
            ->alias()
            ->where('afalmstte', 1)
            ->where('afalmdesc', 'like', "%$find%")
            ->orderBy('afalmcorr')
            ->get();
    }
}
