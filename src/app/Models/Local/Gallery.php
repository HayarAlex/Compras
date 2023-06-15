<?php

namespace Liffe\Compras\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Phantom\App\Http\Traits\HasCompositePrimaryKey;

class Gallery extends Model
{

    use HasCompositePrimaryKey;

    protected $connection = 'pgsql';
    protected $table      = 'afglr';
    protected $primaryKey = ['afglrmpid', 'afglrcorr'];
    public $incrementing  = false;

    const CREATED_AT = 'afglrfcrd';
    const UPDATED_AT = 'afglrfupd';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->afglrcusr = Auth::id();
            $query->afglrstte = true;
        });
    }

    function scopeGenKey($query, $code)
    {
        return $query->select('afglrcorr')
                ->where('afglrmpid', $code)
                ->max('afglrcorr') + 1;
    }

    public function stored()
    {
        return $this->morphTo(null,
            'afglrmptp',
            'afglrmpid');
    }

}
