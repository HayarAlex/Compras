<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Liffe\Compras\App\Models\Local\Revalue;
use Liffe\Compras\App\Models\Sai\iType;

class ConfigController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('compras::config.index');
    }

    public function types(){
        return view('compras::config.type.index');
    }

    public function storeType(Request $request){
        $request->validate([
            'list' => 'required'
        ]);

        $list = iType::select(['aftiptipo', 'aftipdscr'])
            ->whereIn('aftiptipo', $request->list)
            ->get();

        foreach ($list as $item) {
            $revalue = new Revalue;
            $revalue->afrvlcode = $item->aftiptipo;
            $revalue->afrvldesc = $item->aftipdscr;
            $revalue->save();
        }
    }

    public function removeType(Request $request){
        $request->validate([
            'list' => 'required'
        ]);

        Revalue::whereIn('afrvlcode', $request->list)
            ->delete();
    }

}