<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Liffe\Compras\App\Models\Local\Concept;
use Liffe\Compras\App\Models\Local\Store;
use Liffe\Compras\App\Models\Sai\iAgenda;
use Liffe\Compras\App\Models\Sai\iClass;
use Liffe\Compras\App\Models\Sai\iConcept;
use Liffe\Compras\App\Models\Sai\iType;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('compras::order.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'desc' => 'required',
            'regn' => 'required'
        ]);

        $regn = json_decode($request->regn);

        $store = new Store;
        $store->afalmdesc = $request->desc;
        $store->afalmcuni = $regn->corr;
        $store->afalmnuni = $regn->desc;
        $store->save();

        return Store::alias()->where('afalmstte', 1)->orderBy('afalmcorr')->get();
    }

    public function lists(){
        $list = Store::alias()->where('afalmstte', 1)->orderBy('afalmcorr')->get();
        return DataTables::of($list)->toJson();
    }

    public function remove($id){
        $store = Store::findOrFail($id);
        $store->afalmstte = 0;
        $store->update();
    }

    public function refresh(Request $request){
        $request->validate([
            'corr' => 'required',
            'desc' => 'required',
            'cuni' => 'required'
        ]);

        $regn = Concept::finder(Concept::CONC_REGN, $request->cuni);
        $store = Store::find($request->corr);
        $store->afalmdesc = $request->desc;
        $store->afalmcuni = $regn->corr;
        $store->afalmnuni = $regn->desc;
        $store->update();
        return Store::alias()->find($request->corr);
    }

}