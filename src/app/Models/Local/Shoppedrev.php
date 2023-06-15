<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\app\Http\Traits\SaveToUpper;

class Shoppedrev extends Model
{
    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'shoppedrev';
    protected $primaryKey = 'idshrev';

    protected $alias = [
        'idshrev as idshr',
        'idshped as idped',
        'tiporev as tipor',
        'coment as com',
        'staterev as str',
        'fechaini as fini',
        'fechafin as ffin'
    ];
    public function scopeAlias()
    {
        return $this->select($this->alias);
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->idshrev = Shoppedrev::max('idshrev') + 1;
        });
    }
}
