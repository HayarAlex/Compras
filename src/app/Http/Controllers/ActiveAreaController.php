<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Liffe\Compras\App\Models\Local\ActivoArea;
use Liffe\Compras\App\Models\Local\Pedido;
use Liffe\Compras\App\Models\Local\Ped;
use Liffe\Compras\App\Models\Sai\iActive;
use Yajra\DataTables\Facades\DataTables;

class ActiveAreaController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('compras::active_area.index');
    }
    public function indexp(){
        return view('compras::modorder.index');
    }

    public function show($area){
        return view('compras::active_area.register', compact("area"));
    }
    public function showp($area){
        return view('compras::modorder.register', compact("area"));
    }

    public function store(Request $request){
//        dd($request->all());
        $request->validate([
            "care" => "required",
            "list" => "required"
        ]);
        foreach ($request->list as $active){
            $this->saveVinculation($active, $request->care);
        }
    }

    public function destroy(Request $request){
//        dd($request->all());
        $request->validate([
            "care" => "required",
            "list" => "required"
        ]);
        ActivoArea::where("afaxacare", $request->care)
            ->whereIn("afaxacact", $request->list)
            ->delete();
    }

    public function changestate($id){
        $statep = Ped::findOrFail($id);
        if ($statep->state == 1) {
            $statep->state = 0;
        }else{
            $statep->state = 1;
        }
        $statep->update();
    }

    //---- section list
    public function activeAvalaible(){
        $exclude = $this->excludeValid();
        $avalaible = iActive::select(["afmaecodi as codi", "afmaedscr as dscr"])
                            ->whereNull("afmaemtvo")
                            ->whereNotIn("afmaecodi", $exclude)
                            ->get();
        return DataTables::of($avalaible)->toJson();
    }

    public function activeArea($area){
        $valid = $this->inArea($area);
        $avalaible = iActive::select(["afmaecodi as codi", "afmaedscr as dscr"])
                            ->whereNull("afmaemtvo")
                            ->whereIn("afmaecodi", $valid)
                            ->get();
        return DataTables::of($avalaible)->toJson();
    }
    public function activeAreap($area){
        $avalaible = Pedido::where("codeneg", $area)
                            ->get();
        return DataTables::of($avalaible)->toJson();
    }

    private function inArea($area){
        return ActivoArea::where("afaxacare", $area)->pluck("afaxacact");
    }

    private function excludeValid(){
        return ActivoArea::pluck('afaxacact');
    }

    private function saveVinculation($active, $area){
        $assoc = new ActivoArea;
        $assoc->afaxacact = $active;
        $assoc->afaxacare = $area;
        $assoc->save();
    }

}
