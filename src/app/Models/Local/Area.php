<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\app\Http\Traits\SaveToUpper;

class Area extends Model{

    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'afare';
    protected $primaryKey = 'afarecorr';

    const CREATED_AT = 'afarefcrd';
    const UPDATED_AT = 'afarefupd';

    protected $alias = [
        'afarecorr as corr',
        'afaredesc as desc',
        'afarestte as stte',
        'afarecung as cuni',
        'afarenung as nuni'
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function ($query) {
            $query->afarecorr = Area::max('afarecorr') + 1;
            $query->afarecusr = Auth::id();
            $query->afarestte = 1;
        });
    }

    public function scopeAlias(){
        return $this->select($this->alias);
    }

    public function scopeActives($query, $find){
        $find = strtoupper($find);
        return $query
            ->alias()
            ->where('afarestte', 1)
            ->where('afaredesc', 'like', "%$find%")
            ->orderBy('afarecorr')
            ->get();
    }

    public function scopeInfo($query, $code){
        return $query
            ->alias()
            ->where('afarestte', 1)
            ->where('afarecorr', $code)
            ->first();
    }


}
