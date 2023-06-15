<?php

namespace Liffe\Compras\App\Models\Sai;

use Illuminate\Database\Eloquent\Model;
use Phantom\App\Http\Traits\HasCompositePrimaryKey;

class iClass extends Model
{

    use HasCompositePrimaryKey;

    protected $connection = 'informix';
    protected $table      = 'afcla';
    protected $primaryKey = ['afclatipo', 'afclagrup', 'afclasgrp'];
    public $timestamps    = false;
    public $incrementing  = false;

    protected $alias = [
        'afclatipo as tipo',
        'afclagrup as grup',
        'afclasgrp as sgrp',
        'afcladscr as desc'
    ];

    protected $comboGroup = [
        "afclagrup || '||' || afcladscr as value",
        "afcladscr as label"
    ];

    protected $comboSubGroup = [
        "afclasgrp || '||' || afcladscr as value",
        "afcladscr as label"
    ];

    public function scopeAlias()
    {
        return $this->select($this->alias);
    }

    public function scopeGroups($query, $type, $find = '')
    {
        $type = explode("||", $type)[0];
        $find = strtoupper($find);
        return $query
            ->select($this->comboGroup)
            ->where('afclatipo', $type)
            ->where('afclasgrp', 0)
            ->where('afclagrup', '<>', 0)
            ->where('afcladscr', 'like', "%$find%")
            ->orderBy('afclagrup')
            ->get();
    }

    public function scopeSubGroups($query, $type, $group, $find = '')
    {
        $type = explode("||", $type)[0];
        $group = explode("||", $group)[0];
        $find = strtoupper($find);
        return $query
            ->select($this->comboSubGroup)
            ->where('afclatipo', $type)
            ->where('afclagrup', $group)
            ->where('afclasgrp', '<>', 0)
            ->where('afcladscr', 'like', "%$find%")
            ->orderBy('afclasgrp')
            ->get();
    }

}
