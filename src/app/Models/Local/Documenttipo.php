<?php

namespace Liffe\Compras\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Documenttipo extends Model
{
    protected $connection = 'pgsql';
    protected $table      = 'doctipo';
    protected $primaryKey = 'iddoctipo';

    protected static function boot(){
        parent::boot();
        static::creating(function ($query) {
            $query->iddoctipo = Documenttipo::max('iddoctipo') + 1;
            //$query->iduserlog = Auth::id(); para registrar el usuario desde el modelo
        });
    }

    public function scopeList($query, $master, $tipe){
        return $query->where("gsglrcmtr", $master)
            ->where("gsglrmpid", $tipe)
            ->get();
    }

    function scopeGenKey($query, $code){
        return $query->select('iddoctipo')
                ->where('idpedshop', $code)
                ->max('iddoctipo') + 1;
    }

    public function stored(){
        return $this->morphTo(null,
            'gsglrmptp',
            'gsglrmpid');
    }
}
