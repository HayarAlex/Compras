<?php

namespace Liffe\Compras\App\Models\Sai;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Phantom\app\Http\Traits\SaveToUpper;

class iMasterTransfer extends Model{

    use SaveToUpper;

    protected $connection = 'informix';
    protected $table      = 'afhtr';
    protected $primaryKey = 'afhtrntra';
    public $timestamps    = false;
    public $incrementing  = false;

    public $TIPO_TRANSFERENCIA = 2;

    protected $alias = [
        'afhtrntra'
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function ($query) {
            $query->afhtrntra = iMasterTransfer::max('afhtrntra') + 1;
            $query->afhtrftra = iMasterTransfer::fechaSai();
            $query->afhtrndoc = iMasterTransfer::nroDocumento();
            $query->afhtrttra = iMasterTransfer::transferencia();
            $query->afhtrcpry = 0;
            $query->afhtrcprg = 0;
            $query->afhtrcpry = 0;
            $query->afhtrcprg = 0;
            $query->afhtrmrcb = 0;
            $query->afhtrgls1 = "TRASPASO ACTIVOS SISTEMA MAC";
            $query->afhtruser = "LCD";
            $query->afhtrhora = date("H:i:s");
            $query->afhtrfpro = date("Y-m-d");
        });
    }

    public function scopeAlias(){
        return $this->select($this->alias);
    }

    public function scopeFechaSai(){
        return DB::connection('informix')
            ->table('gbhtc')
            ->orderBy('gbhtcfech', 'DESC')
            ->value('gbhtcfech');
    }

    public function scopeNroDocumento(){
        return "MAC-ACTIVO";
    }

    public function scopeTransferencia(){
        return $this->TIPO_TRANSFERENCIA;
    }

}
