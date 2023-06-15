<?php

namespace Liffe\Compras\App\Models\Sai;

use Illuminate\Database\Eloquent\Model;
use Phantom\App\Http\Traits\HasCompositePrimaryKey;
use Phantom\app\Http\Traits\SaveToUpper;

class iDetailTransfer extends Model{

    use SaveToUpper, HasCompositePrimaryKey;

    protected $connection = 'informix';
    protected $table      = 'afdtr';
    protected $primaryKey = ["afdtrntra", "afdtritem"];
    public $timestamps    = false;
    public $incrementing  = false;

    protected $alias = [
        'afdtrntra as ntra',
        'afdtrntra as item'
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function ($query) {
            $query->afdtrftra = date("Y-m-d");
            $query->afdtrmrcb = 0;
        });
    }

    public function scopeAlias(){
        return $this->select($this->alias);
    }

}
