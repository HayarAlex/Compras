<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\app\Http\Traits\SaveToUpper;

class Store extends Model
{

    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'afalm';
    protected $primaryKey = 'afalmcorr';

    const CREATED_AT = 'afalmfcrd';
    const UPDATED_AT = 'afalmfupd';

    protected $alias = [
        'afalmcorr as corr',
        'afalmdesc as desc',
        'afalmstte as stte',
        'afalmcuni as cuni',
        'afalmnuni as nuni'
    ];

    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->afalmcorr = Store::max('afalmcorr') + 1;
            $query->afalmcusr = Auth::id();
            $query->afalmstte = 1;
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
