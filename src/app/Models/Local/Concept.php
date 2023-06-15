<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\App\Http\Traits\HasCompositePrimaryKey;
use Phantom\app\Http\Traits\SaveToUpper;

class Concept extends Model
{

    use HasCompositePrimaryKey, SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'afcon';
    protected $primaryKey = ['afconpref', 'afconcorr'];
    public $incrementing  = false;

    const CREATED_AT = 'afconfcrd';
    const UPDATED_AT = 'afconfupd';

    const CONC_PROP = 1;
    const CONC_TACT = 2;
    const CONC_REGN = 3;
    const CONC_AFIJ = 4;
    const CONC_TREQ = 5;
    const CONC_TIMP = 6;
    const CONC_TMON = 7;
    const CONC_TDOC = 8;

    protected $alias = [
        'afconcorr as corr',
        'afcondesc as desc',
        'afconencd as encd',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->afconcusr = Auth::id();
            $query->afconstte = 1;
        });
    }

    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    public function scopeConcept($query, $mode, $find)
    {
        $find = strtoupper($find);
        return $query
            ->select($this->alias)
            ->where('afconpref', $mode)
            ->where('afconstte', 1)
            ->where('afconcorr', '<>', 0)
            ->where('afcondesc', 'like', "%$find%")
            ->orderBy('afconcorr')
            ->get();
    }

    public function scopeCombo($query, $mode){
        $combAlias = ["afconencd as value", "afcondesc as label"];
        return $query
            ->select($combAlias)
            ->where('afconpref', $mode)
            ->where('afconstte', 1)
            ->where('afconcorr', '<>', 0)
            ->orderBy('afconcorr')
            ->get();
    }

    public function scopeFinder($query, $concept, $corr)
    {
        return $query
            ->alias()
            ->where('afconpref', $concept)
            ->where('afconcorr', $corr)
            ->first();
    }

}
