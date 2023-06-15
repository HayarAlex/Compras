<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Liffe\Compras\App\Models\Local\Active;
use Liffe\Compras\App\Models\Local\Asignated;
use Liffe\Compras\App\Models\Local\Store;
use Liffe\Compras\App\Models\Sai\iActive;
use Liffe\Compras\App\Models\Sai\iClass;
use Liffe\Compras\App\Models\Sai\iType;
use Liffe\Compras\App\Models\Sai\iUsers;

class ActiveController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('compras::active.index');
    }

    public function show($id){
        $active = Active::alias()->find($id);
        return view('compras::active.kardex', compact('id', 'active'));
    }

    public function getInfo($id){
        return Active::alias()->find($id);
    }

    public function getDetail(){
        return "";
    }

    public function register(){
        return view('compras::active.register');
    }

    public function store(Request $request){
        $request->validate([
            'nsre' => 'required',
            'prpd' => 'required',
            'tact' => 'required',
            'regn' => 'required',
            'rbro' => 'required',
            'sact' => 'required',
            'desc' => 'required'
        ]);

        $prpd = json_decode($request->prpd);
        $tact = json_decode($request->tact);
        $regn = json_decode($request->regn);
        $rbro = json_decode($request->rbro);
        $sact = json_decode($request->sact);

        $active = new Active;
        $active->afacvdesc = $request->desc;
        $active->afacvnsre = $request->nsre;
        $active->afacvmdlo = $request->mdlo;
        $active->afacvnppd = $prpd->desc;
        $active->afacvcppd = $prpd->corr;
        $active->afacvntac = $tact->desc;
        $active->afacvctac = $tact->corr;
        $active->afacvnreg = $regn->desc;
        $active->afacvcreg = $regn->encd;
        $active->afacvnrbr = $rbro->desc;
        $active->afacvcrbr = $rbro->corr;
        $active->afacvnstt = $sact->desc;
        $active->afacvcstt = $sact->corr;
        $active->generate($request);
        $active->save();
    }

    public function mupdate(Request $request){
        $request->validate([
            'corr' => 'required',
            'desc' => 'required'
        ]);

        $active = Active::find($request->corr);
        $active->afacvdesc = $request->desc;
        $active->afacvnsre = $request->nsre;
        $active->afacvmdlo = $request->mdlo;
        $active->update();

        $iactive = iActive::find($active->afacvencd);
        $iactive->afmaedscr = $request->desc;
        $iactive->afmaedesl = $request->desc;
        $iactive->save();

        return Active::alias()->find($request->corr);
    }

    public function buyInfo($id, Request $request){
        $request->validate([
            'ndoc' => 'required',
            'fcmp' => 'required',
            'prvd' => 'required',
            'tdoc' => 'required',
            'tmon' => 'required',
            'otrb' => 'required',
            'vttl' => 'required',
            'ctpo' => 'required',
            'cgru' => 'required',
            'csgr' => 'required',
            'obsr' => 'required',
        ]);

        $prov = json_decode($request->prvd);

        $mond = json_decode($request->tmon);
        $docu = json_decode($request->tdoc);

        $type = explode("||", $request->ctpo);
        $grup = explode("||", $request->cgru);
        $sgrp = explode("||", $request->csgr);

        $active = Active::find($id);
        $active->afacvndoc = $request->ndoc;
        $active->afacvfbuy = $request->fcmp;
        $active->afacvcprv = $prov->cage;
        $active->afacvnprv = $prov->desc;
        $active->afacvnrms = $request->nrms;
        $active->afacvcotz = $request->cotz;
        $active->afacvotrb = $request->otrb;
        $active->afacvvttl = $request->vttl;
        $active->afacvctpo = $type[0];
        $active->afacvntpo = $type[1];
        $active->afacvcgru = $grup[0];
        $active->afacvngru = $grup[1];
        $active->afacvcsgr = $sgrp[0];
        $active->afacvnsgr = $sgrp[1];
        $active->afacvobsr = $request->obsr;
        $active->afacvstte = 1;

        $active->afacvcmon = $mond->corr;
        $active->afacvnmon = $mond->desc;
        $active->afacvfmon = $mond->encd;

        $active->afacvcimp = $docu->corr;
        $active->afacvnimp = $docu->desc;
        $active->afacvpimp = $docu->encd;

        $active->update();
    }

    public function activeResponsable($id, Request $request){
        $request->validate([
            "empl" => "required"
        ]);

        $respon = json_decode($request->empl);

        $respons = new Asignated;//afaxu
        $respons->afaxucact = $id;
        $respons->afaxucrsp = $respon->cemp;
        $respons->afaxunrsp = $respon->desc;
        $respons->afaxufasg = date("Y-m-d");
        $respons->afaxuactv = 1;
        $respons->centroCosto($respon->cemp);
        $respons->save();

        $active = Active::find($id);
        $active->afacvstte = 2;
        $active->afacvcrsp = $respon->cemp;
        $active->afacvnrsp = $respon->desc;

        if(!$active->afacvnrod){
            $active->afacvnrod = Active::max('afacvnrod') + 1;
        }

        $active->afacvgest = date('Y');

        $active->afactnasg = iUsers::class;
        $active->afactcasg = 2;

        $active->update();

    }

    public function activeStore($id, Request $request){
        $request->validate([
            "stor" => "required"
        ]);

        $store = json_decode($request->stor);

        $active = Active::find($id);

        if($active->afacvstte != 2){


            $respons = new Asignated;
            $respons->afaxucact = $id;
            $respons->afaxucrsp = $store->corr;
            $respons->afaxunrsp = $store->desc;
            $respons->afaxufasg = date("Y-m-d");
            $respons->afaxuactv = 1;
            $respons->centroCosto($store->corr);
            $respons->save();

            ///-----
            $active = Active::find($id);
            $active->afacvstte = 3;
            $active->afacvcrsp = $store->corr;
            $active->afacvnrsp = $store->desc;
            $active->afacvnrod = Active::max('afacvnrod') + 1;

            if(!$active->afacvnrod){
                $active->afacvnrod = Active::max('afacvnrod') + 1;
            }

            $active->afacvgest = date('Y');

            $active->afactnasg = Store::class;
            $active->afactcasg = 3;

            $active->update();
            //--- end

        }else{
            return response([], 500);
        }
    }

    public function remove($id){
        Active::where('afacvcorr', $id)->delete();
    }

}
