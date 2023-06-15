<?php

namespace Liffe\Compras\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Liffe\Compras\App\Models\Local\Concept;

class ConfigApiController extends Controller
{
    public function concept(){
        $alias = ['afconpref as pref',
                  'afconcorr as corr',
                  'afcondesc as desc',
                  'afconencd as abre',
                  'afconstte as fcnv'];
        return Concept::select($alias)
            ->where('afconstte', 1)
            ->get();
    }

    public function units(){
        $alias = ["cnuneuneg as uneg",
                  "cnunedesc as desc",
                  "cnuneuneg as stte"];
        $query = "select 
                    cnuneuneg as uneg,
                    cnunedesc as desc, 
                    cnuneuneg as stte 
                  from 
                    cnune";

        return DB::connection("informix")->select($query);
    }

    public function arts(){
        $alias = ["inartcart as cart",
                  "inartdesc as desc"];
        $query = "select 
                    inartcart as cart,
                    inartdesc as desc
                  from 
                    inart";

        return DB::connection("informix")->select($query);
    }

    public function employes(){
        $alias = ["suempcemp as cemp",
                  "suempinic as apat",
                  "suempinic as amat",
                  "suempinic as nomb",
                  "suempnemp as fnom",
                  "suempuneg as cune",
                  "suempuneg as nune",
                  "suempfing as fing"];

        $query = "select 
                    suempcemp as cemp,
                    suempinic as apat,
                    suempinic as amat,
                    suempinic as nomb,
                    suempnemp as fnom,
                    suempuneg as cune,
                    suempuneg as nune,
                    suempfing as fing 
                  from 
                    suemp 
                  where 
                    suempstat = 0";

        return DB::connection("informix")->select($query);

    }

    public function assets(){
        $alias = ["afmaecodi as codi",
                  "afmaedesl as desl",
                  "afmaestat as stat",
                  "afmaetipo as tipo",
                  "afmaegrup as grup",
                  "afmaesgrp as sgrp",
                  "afmaeresp as resp",
                  "afmaeuneg as uneg",
                  "afmaeuneg as cung",
                  "afmaeccos as ccos"
            ];

        $query = "select 
                    afmaecodi as codi,
                    case 
                    	when afmaedesl is null then afmaedscr
                    	else afmaedesl end as desl,
                    afmaestat as stat,
                    afmaetipo as tipo,
                    afmaegrup as grup,
                    afmaesgrp as sgrp,
                    afmaeresp as resp,
                    afmaeuneg as uneg,
                    afmaeuneg as cung,
                    afmaeccos as ccos
                  from 
                    afmae";

        return DB::connection("informix")->select($query);
    }

}
