<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\app\Http\Traits\SaveToUpper;

class Ped extends Model
{
    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'pedd';
    protected $primaryKey = 'idped';

    protected $alias = [
        'idped as idp',
        'idart as ida',
        'idneg as idn',
        'pdesc as pd',
        'pfecha as pfe',
        'statep as statep',
        'stresa as stateres'
    ];
    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->idped = Ped::max('idped') + 1;
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
