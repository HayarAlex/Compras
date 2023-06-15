<?php

namespace Liffe\Compras\App\Models\Sai;

use Illuminate\Database\Eloquent\Model;

class iAgenda extends Model
{

    protected $connection = 'informix';
    protected $table      = 'gbage';
    protected $primaryKey = 'gbagecage';
    public $timestamps    = false;
    public $incrementing  = false;

    protected $alias = [
        'gbagecage as cage',
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

    public function scopeProviders($query, $find)
    {
        $find = strtoupper($find);
        return $query
            ->alias()
            ->where('gbagestat', 1)
            ->where('gbagenomb', 'like', "%$find%")
            ->whereBetween('gbagecage', [100000, 999999])
            ->orderBy('gbagecage')
            ->get();
    }

}