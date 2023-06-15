<?php

namespace Liffe\Compras\App\Models\Sai;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Phantom\app\Http\Traits\SaveToUpper;

class iActive extends Model{

    use SaveToUpper;

    protected $connection = 'informix';
    protected $table      = 'afmae';
    protected $primaryKey = 'afmaecodi';
    public $timestamps    = false;
    public $incrementing  = false;

    protected $alias = [
        'afmaecodi as codi',
        'afmaedscr as dscr',
        'afmaeuneg as uneg',
        'afmaevida as vidu',
        'afmaeccos as ccos',
        'afmaeobs1 as obs1',
        'afmaeobs2 as obs2',
        'afmaeobs3 as obs3',
    ];

    public function scopeAlias(){
        return $this->select($this->alias);
    }

    public function scopeCorrelative($query, $code){
        $out = $query
            ->alias()
            ->where('afmaecodi', 'like', "%$code%")
            ->orderBy('afmaecodi', 'desc')
            ->first();
        return $out ? $this->valid($out->codi) : 0;
    }

    private function valid($code){
        return strlen($code) == 10 ? substr($code, -4) : 0;
    }

    public function scopeFinder($query, $code){
        $mquery = "select
                        afmaecodi as codi,
                        afmaedscr as dscr,
                        afmaeuneg as uneg,
                        afmaevida as vidu,
                        afmaeccos as ccos,
                        afmaeobs1 as obs1,
                        afmaeobs2 as obs2,
                        afmaeobs3 as obs3,
                        cnccodesc as ncos,
                        cnunedesc as nung
                    from afmae inner join cncco
                         on afmaeccos = cnccoccos inner join cnune
                         on afmaeuneg = cnuneuneg
                    where afmaecodi = '$code'";

        $out = DB::connection('informix')->select($mquery);

        return $out ? $out[0] : [];
    }

}
