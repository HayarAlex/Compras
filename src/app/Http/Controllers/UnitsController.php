<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;

class UnitsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('bonus::units.index');
    }

    public function show($id)
    {
        // this a show
    }

}