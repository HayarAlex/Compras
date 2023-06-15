<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Phantom\App\Http\Traits\HasCompositePrimaryKey;
use Phantom\app\Http\Traits\SaveToUpper;

class ActivoArea extends Model{

    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'afaxa';
    protected $primaryKey = "afaxacact";
    public $incrementing  = false;

    const CREATED_AT = 'afaxafcrd';
    const UPDATED_AT = 'afaxafupd';

    protected $alias = [
        'afaxacact as cact',
        'afaxacare as care',
        'afaxacusr as cusr',
        'afaxastte as stte'
    ];

    public function scopeAlias(){
        return $this->select($this->alias);
    }

    protected static function boot(){
        parent::boot();
        static::creating(function ($query) {
            $query->afaxacusr = Auth::id();
            $query->afaxastte = 1;
        });
    }

    public function scopeGetArea($query, $code){
        $query = "select 
                    afaredesc as area
                  from afaxa inner join afare
                      on afaxacare = afarecorr
                  where afaxacact = '$code'";
        $result = DB::select($query);
        return $result ? $result[0]->area: "";
    }

}
