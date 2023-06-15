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

class DocsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('compras::config.docs.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'desc' => 'required'
        ]);

        $store = new Concept;
        $store->afcondesc = $request->desc;
        $store->afconcorr = Concept::where('afconpref', Concept::CONC_TDOC)->max('afconcorr') + 1;
        $store->afconpref = Concept::CONC_TDOC;
        $store->save();

        return Concept::alias()->where('afconstte', 1)->where('afconcorr', '<>', 0)->where('afconpref', Concept::CONC_TDOC)->orderBy('afconcorr')->get();
    }

    public function lists(){
        $list = Concept::alias()->where('afconstte', 1)->where('afconcorr', '<>', 0)->where('afconpref', Concept::CONC_TDOC)->orderBy('afconcorr')->get();
        return DataTables::of($list)->toJson();
    }

    public function remove($id){
        $store = Concept::find([Concept::CONC_TDOC, $id]);
        $store->afconstte = 0;
        $store->update();
    }

    public function refresh(Request $request){
        $request->validate([
            'corr' => 'required',
            'desc' => 'required'
        ]);

        $store = Concept::find([Concept::CONC_TDOC, $request->corr]);
        $store->afcondesc = $request->desc;
        $store->update();
        return Concept::alias()->where('afconpref', Concept::CONC_TDOC)
            ->where('afconcorr', $request->corr)
            ->first();
    }

}