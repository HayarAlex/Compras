<?php

namespace Liffe\Compras\App\Models\Sai;

use Illuminate\Database\Eloquent\Model;
use Liffe\Compras\App\Models\Local\Unity;

class iUnit extends Model
{

    protected $connection = 'informix';
    protected $table      = 'cnune';
    protected $primaryKey = 'cnuneuneg';
    public $timestamps    = false;
    public $incrementing  = false;


    public function unity()
    {
        return $this->hasOne(Unity::class, 'oruntcunt');
    }

}
