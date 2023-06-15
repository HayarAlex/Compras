<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Liffe\Compras\App\Models\Gallery;
use Liffe\Compras\App\Models\Sai\iActive;
use Phantom\app\Http\Traits\SaveToUpper;

class Transfer extends Model{

    use SaveToUpper, SoftDeletes;

    protected $connection = 'pgsql';
    protected $table      = 'aftrm';
    protected $primaryKey = 'aftrmcorr';
    public $incrementing  = false;

    const CREATED_AT = 'aftrmfcrd';
    const UPDATED_AT = 'aftrmfupd';
    const DELETED_AT = 'aftrmfdel';

    protected $alias = [
        'aftrmcorr as corr',
        'aftrmencd as encd',
        'aftrmsres as sres',
        'aftrmscar as scar',
        'aftrmsung as sung',
        'aftrmscct as scct',
        'aftrmtres as tres',
        'aftrmtcar as tcar',
        'aftrmtung as tung',
        'aftrmtcct as tcct',
        'aftrmglsa as glsa',
        'aftrmfcrd as fcrd',
        'aftrmscrs as scrs',
        'aftrmtcrs as tcrs',

        'aftrmsnct as snct',
        'aftrmtnun as tnun',
        'aftrmtnct as tnct',
        'aftrmsnun as snun'
    ];

    protected static function boot(){
        parent::boot();
        static::creating(function ($query) {
            $query->aftrmencd = Transfer::withTrashed()->max('aftrmencd') + 1;
            $query->aftrmcusr = Auth::id();
            $query->aftrmstte = 1;
        });
    }

    public function scopeAlias(){
        return $this->select($this->alias);
    }

}
