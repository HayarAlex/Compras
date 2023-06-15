<?php

namespace Liffe\Compras\App\Models\Sai;

use Illuminate\Database\Eloquent\Model;
use Phantom\App\Http\Traits\HasCompositePrimaryKey;

class iConcept extends Model
{

    use HasCompositePrimaryKey;

    protected $connection = 'informix';
    protected $table      = 'afcon';
    protected $primaryKey = ['afconpref', 'afconcorr'];
    public $timestamps    = false;
    public $incrementing  = false;

    protected $alias = [
        'afconcorr as corr',
        'afcondesc as desc',
        'afconabre as abre',
    ];

    const CONC_TINC = 2;
    const CONC_STTE = 3;

    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    public function scopeConcept($query, $mode, $find)
    {//|afconcorr|afcondesc                               |afconabre
        $find = strtoupper($find);
        return $query
            ->select($this->alias)
            ->where('afconpref', $mode)
            ->where('afconcorr', '<>', 0)
            ->where('afcondesc', 'like', "%$find%")
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
