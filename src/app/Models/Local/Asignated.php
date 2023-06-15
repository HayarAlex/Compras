<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Phantom\app\Http\Traits\SaveToUpper;

class Asignated extends Model
{

    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'afaxu';//afaxu
    protected $primaryKey = 'afaxucact';
    public $incrementing  = false;

    const CREATED_AT = 'afaxufcrd';
    const UPDATED_AT = 'afaxufupd';

    protected $alias = [
        'afaxucact as cact',
        'afaxucrsp as crsp',
        'afaxuactv as actv',
        'afaxufasg as fasg',
        'afaxucusr as cusr',
        'afaxunrsp as nrsp',
        'afaxustte as stte',
        'afaxuccos as ccos',
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function ($query) {
            $query->afaxucusr = Auth::id();
            $query->afaxustte = 1;
        });
    }

    public function scopeAlias(){
        return $this->select($this->alias);
    }

    public function scopeCentroCosto($query, $resp){

        if($resp){
            $mquery = "select suempccos as ccos
                  from suemp
                  where suempcemp = $resp";

            $list = DB::connection("informix")->select($mquery);
            if($list){
                $query->afaxuccos = $list[0]->ccos;
            }
        }

    }

}
