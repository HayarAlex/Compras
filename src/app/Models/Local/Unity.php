<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;

class Unity extends Model
{

    protected $connection = 'pgsql';
    protected $table      = 'count';
    public $incrementing  = false;
    protected $primaryKey = 'countcunt';
    public $timestamps    = false;

}
