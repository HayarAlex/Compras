<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Liffe\Compras\App\Models\Local\Area;
use Liffe\Compras\App\Models\Local\Ped;
use Liffe\Compras\App\Models\Local\Pedido;
use Liffe\Compras\App\Models\Local\Concept;
use Yajra\DataTables\Facades\DataTables;

class AreaController extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('compras::area.index');
    }

    public function show($id){
        return view('compras::area.show', compact('id'));
    }
    public function showp($id){
        return view('compras::area.showp', compact('id'));
    }

    public function register(){
        return view('compras::area.register');
    }

    public function store(Request $request){
        $request->validate([
            "desc" => "required",
            "regn" => "required"
        ]);

        $regn = json_decode($request->regn);

        $area = new Area;
        $area->afaredesc = $request->desc;
        $area->afarenung = $regn->desc;
        $area->afarecung = $regn->encd;
        $area->save();

        return Area::alias()->where('afarestte', 1)->orderBy('afarecorr')->get();
    }

    public function lists($id){
        $list = Area::alias()
                ->where('afarestte', 1)
                ->where('afarecung', $id)
                ->orderBy('afarecorr')
                ->get();
        return DataTables::of($list)->toJson();
    }

    public function listsp($id){
        $list = Ped::alias()
                ->where('idneg', $id)
                ->orderBy('idped')
                ->get();
        return DataTables::of($list)->toJson();
    }

    public function listsAll(){
        $list = Area::alias()
            ->where('afarestte', 1)
            ->orderBy('afarecorr')
            ->get();
        return DataTables::of($list)->toJson();
    }

    public function remove($id){
        $store = Area::findOrFail($id);
        $store->afarestte = 0;
        $store->update();
    }

    public function refresh(Request $request){

        $request->validate([
            'corr' => 'required',
            'desc' => 'required',
            'cuni' => 'required'
        ]);

        $regn = Concept::finder(Concept::CONC_REGN, $request->cuni);
        $store = Area::find($request->corr);
        $store->afaredesc = $request->desc;
        $store->afarecung = $regn->corr;
        $store->afarenung = $regn->desc;
        $store->update();
        return Area::alias()->find($request->corr);
    }

    public function info($id){
        return Area::alias()->find($id);
    }
    public function infop($id){
        return Ped::alias()->where('idart', $id)->get();
    }

}
