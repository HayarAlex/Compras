<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Liffe\Compras\App\Models\Local\Active;
use Liffe\Compras\App\Models\Sai\iActive;
use Yajra\DataTables\Facades\DataTables;

class StatesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listDefault()
    {
        $list = Active::alias()->where('afacvstte', 1)->get();
        return DataTables::of($list)->toJson();
    }

    public function listTransitory()
    {
        // not in
        $activated = $this->activated();
        $list = Active::alias()
            ->where('afacvstte', 2)
            ->whereNotIn('afacvencd', $activated)
            ->get();
        return DataTables::of($list)->toJson();
    }

    public function listCustodia()
    {
        $list = Active::alias()->where('afacvstte', 3)->get();
        return DataTables::of($list)->toJson();
    }

    public function listActive()
    {
        $validate = $this->activated();
        $list = Active::alias()->whereIn('afacvencd', $validate)->get();
        return DataTables::of($list)->toJson();
    }

    private function activated()
    {
        $transitory = Active::where('afacvstte', 2)->pluck('afacvencd');
        return iActive::whereIn('afmaecodi', $transitory)->pluck('afmaecodi');
    }


}