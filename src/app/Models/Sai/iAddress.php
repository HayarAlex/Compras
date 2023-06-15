<?php

namespace Liffe\Compras\App\Models\Sai;

use Illuminate\Database\Eloquent\Model;

class iAddress extends Model
{
    protected $connection = 'informix';
    protected $table      = 'gbdir';
    protected $primaryKey = 'gbdircage';
    public $timestamps    = false;
    public $incrementing  = false;

    protected $alias = [
        'gbdircage as cage'
    ];

    public function scopeAlias()
    {
        return $this->select($this->alias);
    }
    public function scopeName($query, $code)
    {
        return $query->select('gbdirdire as dire')
                     ->where('gbdircage', $code)
                     ->first()
                     ->name;
    }

    public function scopeProviders($query, $find)
    {
        $find = strtoupper($find);
        return $query
            ->alias()
            ->where('gbdircage', 'like', "%$find%")
            ->whereBetween('gbdircage', [100000, 999999])
            ->orderBy('gbdircage')
            ->get();
    }
}
