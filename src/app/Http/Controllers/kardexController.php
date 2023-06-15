<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Liffe\Compras\App\Models\Local\Active;
use Liffe\Compras\App\Models\Sai\iActive;
use Yajra\DataTables\Facades\DataTables;

class KardexController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('compras::kardex.index');
    }

    public function show($id){
        return view('compras::kardex.active', compact('id'));
    }

    public function refresh($id, Request $request){
        $request->validate([
            "cstt" => "required",
            "dscr" => "required|max:40",
            "detl" => "required|max:500"
        ]);
        $object = iActive::findOrfail($id);
        $object->afmaedscr = $request->dscr;
        $object->afmaedesl = $request->detl;
        $object->afmaestat = $request->cstt;
        $object->update();
    }

    public function getAll(){
        $list = iActive::alias()->whereNull("afmaemtvo")->orderBy("afmaecodi")->get();
        return DataTables::of($list)->toJson();
    }

    public function getActive($id){
        $query = "select 
                    cncsudesc as ccsp,
                    cnccodesc as ccos,
                    cnunedesc as regn,
                    aftipdscr as rubr,
                    afmaecodi as codi,
                    afmaedscr as dscr,
                    afmaedame as dmes,
                    afmaedesl as detl,
                    aftipdscr as tipo,
                    afcondesc as stte,
                    afcladscr as sgrp,
                    suempnemp as nemp, 
                    afmaestat as cstt
                from afmae inner join cncco 
                    on afmaeccos = cnccoccos inner join cncsu
                    on cnccocsup = cncsucsup inner join cnune
                    on afmaeuneg = cnuneuneg inner join aftip
                    on afmaetipo = aftiptipo inner join suemp
                    on afmaeresp = suempcemp inner join afcon
                    on afmaestat = afconcorr and afconpref = 3 inner join afcla
                    on afmaetipo = afclatipo and afmaegrup = afclagrup and afclasgrp = 0
                where afmaecodi = '{$id}'";

        $simple = "select 
                    afmaecodi as codi,
                    afmaedscr as dscr,
                    afmaedame as dmes,
                    afmaedesl as detl,
                    afmaestat as cstt,
                    aftipdscr as rubr,
                    aftipdscr as tipo,
                    afcondesc as stte,
                    cnccodesc as ccos,
                    cnunedesc as regn,
                    cncsudesc as ccsp,
                    gbagenomb as nemp
				   from afmae inner join aftip
                    on afmaetipo = aftiptipo inner join afcon
                    on afmaestat = afconcorr and afconpref = 3 inner join  cncco
                  
                    on afmaeccos = cnccoccos inner join cnune
                    on afmaeuneg = cnuneuneg inner join cncsu
                    on cnccocsup = cncsucsup inner join gbage
                    on afmaeresp = gbagecage
                   where afmaecodi = '{$id}'";
        $item = DB::connection('informix')->select($query);

        if(!$item){
            $item = DB::connection('informix')->select($simple);
        }
        return count($item) > 0 ? response()->json($item[0]): [];
    }

    public function search(Request $request){
        $request->validate([
            "srch" => "required"
        ]);
        $item = iActive::find($request->srch);
        if(!$item){
            $message = ['message' => 'Codigo de activo no valido !!!'];
            return $this->errorMessage($message);
        }
        return $request->srch;
    }

    public function showSearch(){
        return view('compras::kardex.searcher');
    }

    public function shower($id){
        return view('compras::kardex.kardex', compact('id'));
    }
}
