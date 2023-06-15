<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Liffe\Compras\app\Core\Transfer\Transfer;
use Liffe\Compras\App\Models\Local\ActivoArea;
use Liffe\Compras\App\Models\Local\Area;
use Yajra\DataTables\Facades\DataTables;

class TransferAreaController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('compras::transfer_area.index');
    }

    public function combAreas(Request $request){
        return Area::select(["afarecorr as value", "afaredesc as label"])
                   ->where("afarecung", $request->uneg)
                   ->get();
    }

    public function getResponsable($code){
        return Area::info($code);
    }

    public function listActives($code){
        $validList = '("0")';
        $listValid = ActivoArea::where("afaxacare", $code)->pluck("afaxacact");
        if(count($listValid)){
            $validList = str_replace(["[", "]"], ["(", ")"], $listValid->toJson());
        }

        $query = "select 
                    afmaecodi as codi,
                    afmaedscr as detl,
                    afcondesc as stat
                  from afmae inner join afcon
                    on afmaestat = afconcorr and afconpref = 3
                    where afmaemtvo is null
                  and afmaecodi in $validList";
        $list = DB::connection("informix")->select($query);
        return DataTables::of($list)->toJson();
    }

    public function transfer(Request $request){
        $request->validate([
            "orig" => "required",
            "dest" => "required",
            "actv" => "required"
        ]);
        $list = ActivoArea::whereIn('afaxacact', $request->actv)->get();
        foreach ($list as $item){
            $item->afaxacare = $request->dest;
            $item->save();
            dd($item);
        }
    }

}
