<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Liffe\Compras\App\Models\Gallery;
use Liffe\Compras\App\Models\Local\Active;
use Liffe\Compras\App\Models\Local\Concept;
use Liffe\Compras\App\Models\Sai\iActive;
use Liffe\Maintenance\App\Models\Article;
use Yajra\DataTables\Facades\DataTables;

class GalleryController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($active, $doc){
        $id = $active;
        $active = Active::alias()->find($active);
        $docum  = Concept::finder(Concept::CONC_TDOC, $doc);
        return view('compras::active.gallery', compact('active', 'docum', 'id'));
    }

    public function load($active, $doc){
        $active = iActive::alias()->find($active);
        $docum  = Concept::finder(Concept::CONC_TDOC, $doc);
        return view('compras::kardex.gallery', compact('active', 'docum'));
    }

    public function gallery($active, $doc)
    {
//        dd("test");
        $list = Gallery::where('afglrmpid', $active)
            ->where('afglrctpo', $doc)
            ->where('afglrstte', 1)
            ->orderby('afglrfcrd')
            ->get();
        return DataTables::of($list)->toJson();
    }

    public function remove($code)
    {
        Gallery::where('afglrcorr', $code)->update(['afglrstte' => 0]);
    }


}
