<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\app\Http\Traits\SaveToUpper;

class Lic extends Model
{
    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'licd';
    protected $primaryKey = 'idlicd';

    protected $alias = [
        'idlicd as idl',
        'idneg as idn',
        'idadj as ida',
        'descadj as desca',
        'probadj as proba',
        'fechasol as fsol',
        'fechaent as fent',
        'stateadj as statea',
        'stateresa as stra',
        'cuce as cuce',
        'staterot as strot',
        'detrot as drot',
        'obslic as obsl',
    ];
    public function scopeAlias()
    {
        return $this->select($this->alias);
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->idlicd = Lic::max('idlicd') + 1;
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
