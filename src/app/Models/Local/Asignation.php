<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Liffe\Compras\App\Models\Gallery;
use Liffe\Compras\App\Models\Sai\iActive;
use Phantom\app\Http\Traits\SaveToUpper;

class Asignation extends Model{

    use SaveToUpper, SoftDeletes;

    protected $connection = 'pgsql';
    protected $table      = 'afndc';
    protected $primaryKey = 'afndccact';
    public $incrementing  = false;

    const CREATED_AT = 'afndcfcrd';
    const UPDATED_AT = 'afndcfupd';
    const DELETED_AT = 'afndcfdel';

    protected $alias = [
        'afndccorr as corr',
        'afndccact as cact',
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function ($query) {
            $query->afndccorr = Asignation::withTrashed()->max('afndccorr') + 1;
            $query->afndccusr = Auth::id();
            $query->afndcstte = 1;
        });
    }

    public function scopeAlias(){
        return $this->select($this->alias);
    }

}
