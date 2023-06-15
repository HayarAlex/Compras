<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Liffe\Compras\App\Models\Gallery;
use Liffe\Compras\App\Models\Sai\iActive;
use Phantom\App\Http\Traits\HasCompositePrimaryKey;
use Phantom\app\Http\Traits\SaveToUpper;

class TransferDetail extends Model{

    use SaveToUpper, SoftDeletes, HasCompositePrimaryKey;

    protected $connection = 'pgsql';
    protected $table      = 'aftrd';
    protected $primaryKey = ['aftrdctrm', "aftrdencd"];
    public $incrementing  = false;

    const CREATED_AT = 'aftrdfcrd';
    const UPDATED_AT = 'aftrdfupd';
    const DELETED_AT = 'aftrdfdel';

    protected $alias = [
        'aftrdctrm as ctrm',
        'aftrdcont as cont',
        'aftrdencd as encd',
        'aftrddesc as desc',
        'aftrdcstd as cstd',
        'aftrdnstd as nstd',
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function ($query) {
            $query->aftrdcusr = Auth::id();
            $query->aftrdstte = 1;
        });
    }

    public function scopeAlias(){
        return $this->select($this->alias);
    }

}
