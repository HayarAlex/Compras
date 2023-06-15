<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\app\Http\Traits\SaveToUpper;

class Almpedido extends Model
{
    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'almped';
    protected $primaryKey = 'idpeal';

    protected $alias = [
        'idpeal as idpa',
        'ordprod as ordpro',
        'numlote as nlote',
        'tiped as tp',
        'timat as tm',
        'pfecha as pfe',
        'priority as priori',
        'statep as stp',
        'stater as str',
        'statelog as stl',
        'fechasoli as fsol',
        'fechaaten as fate',
        'observacionpeal as obs',
        'iduserp as idus',
        'correo as cr',
        'nameuserp as naus',
        'descprod as descp'
    ];
    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->idpeal = Almpedido::max('idpeal') + 1;
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
