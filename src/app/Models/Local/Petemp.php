<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\app\Http\Traits\SaveToUpper;


class Petemp extends Model
{
    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'petem';
    protected $primaryKey = 'idtemp';

    protected $alias = [
        'idtemp as idt',
        'codenegtemp as codt',
        'codearttemp as codat',
        'codeartdesctemp as codtdesc',
        'codenegdesctemp as codatdesc',
        'cantidadtemp as cantt'
    ];

    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->idtemp = Petemp::max('idtemp') + 1;
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
