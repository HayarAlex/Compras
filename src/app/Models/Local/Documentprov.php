<?php

namespace Liffe\Compras\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Documentprov extends Model
{
    

    protected $connection = 'pgsql';
    protected $table      = 'docprov';
    protected $primaryKey = 'iddocprov';

    protected static function boot(){
        parent::boot();
        static::creating(function ($query) {
            $query->iddocprov = Documentprov::max('iddocprov') + 1;
            //$query->iduserlog = Auth::id(); para registrar el usuario desde el modelo
        });
    }
    public function scopeList($query, $master, $tipe){
        return $query->where("gsglrcmtr", $master)
            ->where("gsglrmpid", $tipe)
            ->get();
    }

    function scopeGenKey($query, $code){
        return $query->select('iddocprov')
                ->where('idpedshop', $code)
                ->max('iddocprov') + 1;
    }

    public function stored(){
        return $this->morphTo(null,
            'gsglrmptp',
            'gsglrmpid');
    }
}
