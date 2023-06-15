<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\app\Http\Traits\SaveToUpper;

class Lictemp extends Model
{
    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'litem';
    protected $primaryKey = 'idlitemp';

    protected $alias = [
        'idlitemp as idlit',
        'codeusrlitemp as cuserli',
        'codelinegtemp as clinegt',
        'codelictemp as clit',
        'cantidadlitemp as calit',
        'codelinegdesctemp as clndt',
        'codelicdesctemp as clict',
        'fenttemp as fet',
        'probabilidadtemp as probt',
        'adjtemp as adjt',
        'unilic as ult',
    ];
    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->idlitemp = Lictemp::max('idlitemp') + 1;
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
