<?php

namespace Liffe\Compras\App\Models\Sai;

use Illuminate\Database\Eloquent\Model;
use Phantom\App\Http\Traits\HasCompositePrimaryKey;

class iCostCenter extends Model
{

    protected $connection = 'informix';
    protected $table      = 'cncco';
    protected $primaryKey = 'cnccoccos';
    public $timestamps    = false;
    public $incrementing  = false;

    protected $alias = [
        'cnccoccos as corr',
        'cnccodesc as desc'
    ];

    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    public function scopeCombo($query, $find)
    {
        $find = strtoupper($find);
        return $query
            ->select($this->alias)
            ->where('cnccodesc', 'like', "%$find%")
            ->orderBy('cnccoccos')
            ->get();
    }

}
