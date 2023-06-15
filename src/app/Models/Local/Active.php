<?php

namespace Liffe\Compras\App\Models\Local;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Liffe\Compras\App\Models\Gallery;
use Liffe\Compras\App\Models\Sai\iActive;
use Phantom\app\Http\Traits\SaveToUpper;

class Active extends Model
{

    use SaveToUpper, SoftDeletes;

    protected $connection = 'pgsql';
    protected $table      = 'afacv';
    protected $primaryKey = 'afacvcorr';
    public $incrementing  = false;

    const CREATED_AT = 'afacvfcrd';
    const UPDATED_AT = 'afacvfupd';
    const DELETED_AT = 'afacvfdel';
//    const UPDATED_ = 'afacvfupd';

    protected $alias = [
        'afacvcorr as corr',
        'afacvencd as encd',
        'afacvdesc as desc',
        'afacvnsre as nsre',

        'afacvnppd as nppd',
        'afacvcppd as cppd',
        'afacvntac as ntac',
        'afacvctac as ctac',
        'afacvnreg as nreg',
        'afacvcreg as creg',
        'afacvnrbr as nrbr',
        'afacvcrbr as crbr',

        'afacvnstt as nstt',
        'afacvcusr as cusr',
        'afacvstte as stte',

        'afacvndoc as ndoc',
        'afacvfbuy as fbuy',
        'afacvcprv as cprv',
        'afacvnprv as nprv',
        'afacvnrms as nrms',
        'afacvcotz as cotz',
        'afacvotrb as otrb',
        'afacvvttl as vttl',

        'afacvctpo as ctpo',
        'afacvntpo as ntpo',
        'afacvcgru as cgru',
        'afacvngru as ngru',
        'afacvcsgr as csgr',
        'afacvnsgr as nsgr',

        'afacvobsr as obsr',
        'afacvcrsp as crsp',
        'afactcasg as casg',

        'afacvnimp as nimp',
        'afacvpimp as pimp',
        'afacvcimp as cimp',
        'afacvnmon as nmon',
        'afacvfmon as fmon',
        'afacvmdlo as mdlo',

        'afacvnrsp as nrsp',
        'afactnasg as nasg',
        'afacvnrod as nrod',
        'afacvgest as gest',

    ];

    protected static function boot(){
        parent::boot();
        static::creating(function ($query) {
            $query->afacvcorr = Active::withTrashed()->max('afacvcorr') + 1;
            $query->afacvcusr = Auth::id();
            $query->afacvstte = 1;
        });
    }

    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    public function scopeFinder($query, $code)
    {
        return $query
            ->where('afacvencd', $code)
            ->first();
    }

    public function generate($request)
    {
        $prpd = json_decode($request->prpd);
        $tact = json_decode($request->tact);
        $regn = json_decode($request->regn);
        $rbro = json_decode($request->rbro);
        $code = $prpd->encd.$tact->encd.$regn->encd.$rbro->encd;
        $encd = $code.$this->getCorrelative($code);
        $this->afacvencd = $encd;
    }

    public function scopeCorrelative($query, $code)
    {
        $out = $query
            ->alias()
            ->where('afacvencd', 'like', "%$code%")
            ->orderBy('afacvencd', 'desc')
            ->first();
        return $out ? $this->valid($out->encd) : 0;
    }

    public function gallery()
    {
        return $this->morphMany(Gallery::class,
            null,
            'afglrmptp',
            'afglrmpid');
    }

    private function valid($code)
    {
        return strlen($code) == 10 ? substr($code, -4) : 0;
    }

    private function getCorrelative($codif)
    {
        $ext = iActive::Correlative($codif);
        $lcl = Active::Correlative($codif);
        return $ext > $lcl ?
            $this->toFormat($ext):
            $this->toFormat($lcl);
    }

    private function toFormat($corr)
    {
        return str_pad($corr + 1, 4, "0", STR_PAD_LEFT);
    }

}
