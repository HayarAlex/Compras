<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\app\Http\Traits\SaveToUpper;

class Almpeddet extends Model
{
    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'almpedadd';
    protected $primaryKey = 'iditalm';

    protected $alias = [
        'iditalm as idia',
        'idpedalm as idpa',
        'codartalm as cart',
        'namprodalm as nart',
        'cantidadalm as cant',
        'stateresi as str',
        'stateenv as sti'
    ];
    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->iditalm = Almpeddet::max('iditalm') + 1;
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



