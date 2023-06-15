<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;

class ItemController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // -- list compras
        return view('compras::active.index');
    }

    public function show($id)
    {
        return view('compras::item.kardex');
    }

    public function register()
    {
        return view('compras::active.register');
    }

    public function requires()
    {
        return view('compras::item.requires');
    }

}