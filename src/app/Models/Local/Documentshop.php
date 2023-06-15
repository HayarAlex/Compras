<?php

namespace Liffe\Compras\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Documentshop extends Model
{

    protected $connection = 'pgsql';
    protected $table      = 'docshop';
    protected $primaryKey = 'iddocshop';

    protected static function boot(){
        parent::boot();
        static::creating(function ($query) {
            $query->iddocshop = Documentshop::max('iddocshop') + 1;
            //$query->iduserlog = Auth::id(); para registrar el usuario desde el modelo
        });
    }

    public function scopeList($query, $master, $tipe){
        return $query->where("gsglrcmtr", $master)
            ->where("gsglrmpid", $tipe)
            ->get();
    }

    function scopeGenKey($query, $code){
        return $query->select('iddocshop')
                ->where('idpedshop', $code)
                ->max('iddocshop') + 1;
    }

    public function stored(){
        return $this->morphTo(null,
            'gsglrmptp',
            'gsglrmpid');
    }
}
