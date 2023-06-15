<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\app\Http\Traits\SaveToUpper;

class Pedido extends Model
{
    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'peadd';
    protected $primaryKey = 'id';

    protected $alias = [
        'id as id',
        'idpedido as idpedido',
        'codeneg as coden',
        'fechap as fep',
        'codeart as codea',
        'cantidad as cant',
        'observacion as obs',
        'codenegdesc as coddesc',
        'codartdesc as codadesc',
        'fechadis as fed',
        'unidad as uni',
        'state as st',
        'stateenv as stenv'
    ];

    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->id = Pedido::max('id') + 1;
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
