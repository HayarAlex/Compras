<?php

namespace Liffe\Compras\App\Models\Sai;

use Illuminate\Database\Eloquent\Model;
use Liffe\Compras\App\Models\Local\Revalue;
use Phantom\App\Http\Traits\HasCompositePrimaryKey;

class iType extends Model
{

    protected $connection = 'informix';
    protected $table      = 'aftip';
    protected $primaryKey = 'aftiptipo';
    public $timestamps    = false;
    public $incrementing  = false;

    protected $alias = [
        "aftiptipo || '||' || aftipdscr as value",
        "aftipdscr as label",
    ];

    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    public function scopeFinds($query, $code)
    {
        return $query
            ->alias()
            ->find($code);
    }

    public function scopeCombo($query, $find = '')
    {
        $find = strtoupper($find);
        $revaluo = $this->reevalue();
        return $this
            ->alias()
            ->where('aftipdscr', 'like', "%$find%")
            ->whereNotIn('aftiptipo', $revaluo)
            ->orderBy('aftiptipo')
            ->get();
    }

    public function scopeList($query){
        $revaluo = $this->reevalue();
        return $this
            ->select(['aftiptipo as code', 'aftipdscr as desc'])
            ->whereNotIn('aftiptipo', $revaluo)
            ->orderBy('aftiptipo')
            ->get();
    }

    private function reevalue()
    {
        return Revalue::list()->pluck('code');
    }

}
