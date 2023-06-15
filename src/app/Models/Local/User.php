<?php

namespace Liffe\Compras\App\Models\Local;

use Phantom\App\Models\User as UserMac;

class User extends UserMac
{

    public function unitspe()
    {
        return $this->belongsToMany(Unity::class,
                            'peusrper',
                            'couserpe',
                            'counitpe')
                            ->orderBy('counitpe');
    }
    public function unitsli()
    {
        return $this->belongsToMany(Unity::class,
                            'liusrper',
                            'couserli',
                            'counitli')
                            ->orderBy('counitli');
    }
    public function unitsdi()
    {
        return $this->belongsToMany(Unity::class,
                            'diusrper',
                            'couserdi',
                            'counitdi')
                            ->orderBy('counitdi');
    }

}
