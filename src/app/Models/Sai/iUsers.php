<?php

namespace Liffe\Compras\App\Models\Sai;

use Illuminate\Database\Eloquent\Model;

class iUsers extends Model
{

    protected $connection = 'informix';
    protected $table      = 'gbage';
    protected $primaryKey = 'gbagecage';
    public $timestamps    = false;
    public $incrementing  = false;

    /*
     select gbagecage, gbagenomb
from gbage
where gbagestat = 1
     */

    protected $alias = [
        'gbagecage as cemp',
        'gbagenomb as desc',
    ];

    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    public function scopeName($query, $code)
    {
        return $query->select('gbagenomb as name')
                     ->where('gbagecage', $code)
                     ->first()
                     ->name;
    }

    public function scopeActives($query, $find)
    {
        $find = strtoupper($find);
        return $query
            ->alias()
            ->where('gbagestat', 1)
            ->where('gbagenomb', 'like', "%$find%")
            ->orderBy('gbagecage')
            ->get();
    }

}