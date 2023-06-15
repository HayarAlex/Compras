<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Liffe\Compras\App\Models\Sai\iActive;
use Phantom\app\Http\Traits\SaveToUpper;

class Revalue extends Model
{

    use SaveToUpper;

    protected $connection = 'pgsql';
    protected $table      = 'afrvl';
    protected $primaryKey = 'afrvlcode';
    public $incrementing  = false;

    const CREATED_AT = 'afrvlfcrd';
    const UPDATED_AT = 'afrvlfupd';

    protected $alias = [
        'afrvlcode as code',
        'afrvldesc as desc',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->afrvlcusr = Auth::id();
        });
    }

    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    public function scopeList($query)
    {
        return $this
            ->alias()
            ->orderBy('afrvlcode')
            ->get();
    }

}
