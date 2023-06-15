<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Liffe\Compras\App\Mail\MessageTest;
use Liffe\Compras\App\Mail\MessageComplete;
use Liffe\Compras\App\Mail\MessagePartial;
use Liffe\Compras\App\Mail\MessageInv;
use Liffe\Compras\App\Mail\MessageCal;
use Liffe\Compras\App\Mail\MessageLog;
use Liffe\Compras\App\Mail\MessageSan;
use Liffe\Compras\App\Mail\MessageSeg;
use Liffe\Compras\App\Mail\MessageObs;
use Liffe\Compras\App\Models\Documentshop;
use Liffe\Compras\App\Models\Documentprov;
use Liffe\Compras\App\Models\Documenttipo;
use Liffe\Compras\App\Models\Local\Concept;
use Liffe\Compras\App\Models\Local\Store;
use Liffe\Compras\App\Models\Local\User;
use Liffe\Compras\App\Models\Local\Unity;
use Liffe\Compras\App\Models\Local\Pedido;
use Liffe\Compras\App\Models\Local\Ped;
use Liffe\Compras\App\Models\Local\Petemp;
use Liffe\Compras\App\Models\Local\Lictemp;
use Liffe\Compras\App\Models\Local\Lic;
use Liffe\Compras\App\Models\Local\Licitacion;
use Liffe\Compras\App\Models\Local\Almpedido;
use Liffe\Compras\App\Models\Local\Almpeddet;
use Liffe\Compras\App\Models\Local\Diary;
use Liffe\Compras\App\Models\Local\Shoppedido;
use Liffe\Compras\App\Models\Local\Shoppeddet;
use Liffe\Compras\App\Models\Local\Shoppedrev;
use Liffe\Compras\App\Models\Mysql\Zone;
use Liffe\Compras\App\Models\Sai\iAgenda;
use Liffe\Compras\App\Models\Sai\iAddress;
use Liffe\Compras\App\Models\Sai\iUnit;
use Liffe\Compras\App\Models\Sai\iClass;
use Liffe\Compras\App\Models\Sai\iConcept;
use Liffe\Compras\App\Models\Sai\iType;
use Yajra\DataTables\Facades\DataTables;
use Milon\Barcode\DNS2D;
use PDF;

class StoreController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('compras::store.index');
    }
    public function indexco()
    {
        return view('compras::orderconfig.index');
    }
    public function indexus()
    {
        return view('compras::orderconfig.users.index');

    }
    public function userUnit($id)
    {
        $user = User::findOrFail($id);
        return view('compras::orderconfig.users.user', compact('user'));
    }
    public function unitUser($id)
    {
        $user = User::findOrFail($id);
        $userUnit = $user->unitspe->pluck('countcunt');
        $allUnits = Unity::orderBy('countcunt')->get();
        foreach ($allUnits->whereIn('countcunt', $userUnit) as &$unit)
        {
            $unit->selected = true;
        }
        $salida = json_encode($allUnits);
        return str_replace(['countdesc', 'countcunt'], ['title', 'key'], $salida);
    }
    public function syncUnits(Request $request)
    {
        $user = User::findOrFail($request->user);
        $user->unitspe()->sync($request->units);
        return "oks";
    }
    public function units(){
        $current = Auth::getUser();
        $user    = User::findOrFail($current->id);
        $units = $user->administrator() ?
                 Unity::orderBy('countcunt')->get() :
                 $user->unitspe;
        return DataTables::of($units)
            ->addColumn('key', function($row){
                return encrypt($row->countcunt);
            })->toJson();
    }
    public function unitslic(){
        $current = Auth::getUser();
        $user    = User::findOrFail($current->id);
        $units = $user->administrator() ?
                 Unity::orderBy('countcunt')->get() :
                 $user->unitsli;
        return DataTables::of($units)
            ->addColumn('key', function($row){
                return encrypt($row->countcunt);
            })->toJson();
    }
    public function unitsdia(){
        $current = Auth::getUser();
        $user    = User::findOrFail($current->id);
        $units = $user->administrator() ?
                 Unity::orderBy('countcunt')->get() :
                 $user->unitsdi;
        return DataTables::of($units)
            ->addColumn('key', function($row){
                return encrypt($row->countcunt);
            })->toJson();
    }
    public function indexcoli()
    {
        return view('compras::tenderconfig.index');
    }
    public function indexusli()
    {
        return view('compras::tenderconfig.users.index');

    }
    public function userUnitli($id)
    {
        $user = User::findOrFail($id);
        return view('compras::tenderconfig.users.user', compact('user'));
    }
    public function unitUserli($id)
    {
        $user = User::findOrFail($id);
        $userUnit = $user->unitsli->pluck('countcunt');
        $allUnits = Unity::orderBy('countcunt')->get();
        foreach ($allUnits->whereIn('countcunt', $userUnit) as &$unit)
        {
            $unit->selected = true;
        }
        $salida = json_encode($allUnits);
        return str_replace(['countdesc', 'countcunt'], ['title', 'key'], $salida);
    }
    public function syncUnitsli(Request $request)
    {
        $user = User::findOrFail($request->user);
        $user->unitsli()->sync($request->units);
        return "oks";
    }
    public function indexo()
    {
        return view('compras::order.index');
    }
    public function indexol()
    {
        return view('compras::listorder.index');
    }
    public function indexliorrep(){
        return view('compras::liorrep.index');
    }
    public function indexalmped(){
        return view('compras::almped.index');
    }
    public function indexalmadm(){
        return view('compras::almadm.index');
    }

    public function indexl()
    {
        return view('compras::tender.index');
    }
    public function indexal()
    {
        return view('compras::admtender.index');
    }
    
    //modulo agenda sai visita medical
    public function indexmed(){
        return view('compras::diarymed.index');
    }
    public function indexmedcon()
    {
        return view('compras::diaryconfig.index');
    }
    public function indexmedlist(){
        return view('compras::diarylist.index');
    }
    public function showlistmed($id){
        return view('compras::diarylist.elements.new', compact('id'));
    }
    public function medUnit($id)
    {
        $user = iAgenda::findOrFail($id);
        $userloc = Diary::where('codigonew',$id)->get();
        return view('compras::diarylist.elements.info', compact('user','userloc'));
    }
    //end modulo agenda medica
    public function indexusdi()
    {
        return view('compras::diaryconfig.users.index');

    }
    public function userUnitdi($id)
    {
        $user = User::findOrFail($id);
        return view('compras::diaryconfig.users.user', compact('user'));
    }
    public function unitUserdi($id)
    {
        $user = User::findOrFail($id);
        $userUnit = $user->unitsdi->pluck('countcunt');
        $allUnits = Unity::orderBy('countcunt')->get();
        foreach ($allUnits->whereIn('countcunt', $userUnit) as &$unit)
        {
            $unit->selected = true;
        }
        $salida = json_encode($allUnits);
        return str_replace(['countdesc', 'countcunt'], ['title', 'key'], $salida);
    }
    public function syncUnitsdi(Request $request)
    {
        $user = User::findOrFail($request->user);
        $user->unitsdi()->sync($request->units);
        return "oks";
    }
    //registrar en la base de datos postgresql agenda visita meica
    public function diarystore(Request $request)
    {
        $code = $request->codigen;
        $list = iAgenda::where('gbagecage', $code)->count();
        if ($list == 0) {
            $distore = new Diary;
            $distore->codigonew = $request->codigen;
            $distore->coduneg = $request->codneg;
            $distore->patemed = $request->pater;
            $distore->matemed = $request->mater;
            $distore->nombmed = $request->nomb;
            $distore->diremed = $request->direc;
            $distore->telemed = $request->telef;
            $distore->codclup = $request->codup;
            $distore->sexomed = $request->sexmed;
            $distore->fenamed = $request->fenac;
            $distore->cotimed = $request->tipmed;
            $distore->tipomed = $request->tipmed;
            $distore->coesmed = $request->espmed;
            $distore->espemed = $request->espmed;
            $distore->cozomed = $request->zonamed;
            $distore->zonamed = $request->zonamed;
            $distore->origenmed = $request->orimed;
            $distore->catmed = $request->categ;
            $distore->save();
            $agemed = new iAgenda;
            $agemed->gbagecage = $request->codigen;
            $agemed->gbagenomb = strtoupper($request->nomb).' '.strtoupper($request->pater).' '.strtoupper($request->mater);
            $agemed->gbagetper = 1;
            $agemed->gbagesexo = $request->sexmed;
            $agemed->gbagefnac = $request->fenac;
            $agemed->gbagenaci = 1;
            $agemed->gbageeciv = 2;
            $agemed->gbageprof = 5;
            $agemed->gbagetdid = 1;
            $agemed->gbagendid = '0';
            $agemed->gbagecorg = '1';
            $agemed->gbagepais = $request->codneg;
            $agemed->gbagedir1 = strtoupper($request->dirone);
            $agemed->gbagedir2 = strtoupper($request->dirtwo);
            $agemed->gbagetlex = $request->telef;
            $agemed->gbagerubr = $request->espmed;
            $agemed->gbageciud = 100;
            $agemed->gbagedpto = $request->orisai;
            $agemed->gbagezona = $request->zonamed;
            $agemed->gbagefreg = date('Y-m-d');
            $agemed->gbagestat = 1;
            $agemed->gbagefsta = date('Y-m-d');
            $agemed->gbageuser = 'TCM';
            $agemed->gbagehora = date('h:i:s');
            $agemed->gbagefpro = date('Y-m-d');
            $agemed->gbageappa = $request->pater;
            $agemed->gbageapma = strtoupper($request->mater);
            $agemed->gbagenoms = strtoupper($request->nomb);
            $agemed->gbagenoml = strtoupper($request->nomb).' '.strtoupper($request->pater).' '.strtoupper($request->mater);
            $agemed->gbageuneg = $request->codneg;
            $agemed->gbagetipo = 10;
            $agemed->save();
            $dirmed = new iAddress;
            $dirmed->gbdircage = $request->codigen;
            $dirmed->gbdiritem = 1;
            $dirmed->gbdirtdir = 8;
            $dirmed->gbdirpais = $request->codneg;
            $dirmed->gbdirdpto = 100;
            $dirmed->gbdirciud = $request->zonamed;
            $dirmed->gbdirubn6 = strtoupper($request->direc);
            $dirmed->gbdirdire = strtoupper($request->direc);
            $dirmed->gbdirmpri = 1;
            $dirmed->gbdiruser = 'TCM';
            $dirmed->gbdirhora = date('h:i:s');
            $dirmed->gbdirfpro = date('Y-m-d');
            $dirmed->save();

            return '1';
        }else{
            return '0';
        }
        
        
    }
    public function refreshmed(Request $request)
    {
        $especialidadcode = $request->espmed;
        if (empty($especialidadcode)) {
            $agemed = iAgenda::find($request->codigen);
            $agemed->gbageappa = strtoupper($request->pater);
            $agemed->gbageapma = strtoupper($request->mater);
            $agemed->gbagenoms = strtoupper($request->nomb);
            $agemed->gbagenomb = strtoupper($request->nomb).' '.strtoupper($request->pater).' '.strtoupper($request->mater);
            $agemed->gbagenoml = strtoupper($request->nomb).' '.strtoupper($request->pater).' '.strtoupper($request->mater);
            $agemed->gbagetlex = $request->telef;
            $agemed->gbagedir1 = strtoupper($request->dirone);
            $agemed->gbagedir2 = strtoupper($request->dirtwo);
            $agemed->gbagesexo = $request->sexmed;
            $agemed->gbagefnac = $request->fenac;
            $agemed->gbagezona = $request->zonamed;
            $agemed->gbagedpto = $request->orisai;
            $agemed->update();
        }else{
            $agemed = iAgenda::find($request->codigen);
            $agemed->gbageappa = strtoupper($request->pater);
            $agemed->gbageapma = strtoupper($request->mater);
            $agemed->gbagenoms = strtoupper($request->nomb);
            $agemed->gbagenomb = strtoupper($request->nomb).' '.strtoupper($request->pater).' '.strtoupper($request->mater);
            $agemed->gbagenoml = strtoupper($request->nomb).' '.strtoupper($request->pater).' '.strtoupper($request->mater);
            $agemed->gbagetlex = $request->telef;
            $agemed->gbagedir1 = strtoupper($request->dirone);
            $agemed->gbagedir2 = strtoupper($request->dirtwo);
            $agemed->gbagesexo = $request->sexmed;
            $agemed->gbagefnac = $request->fenac;
            $agemed->gbagezona = $request->zonamed;
            $agemed->gbagerubr = $request->espmed;
            $agemed->gbagedpto = $request->orisai;
            $agemed->update();
        }
        
        $list = Diary::where('codigonew', $request->codigen)->count();
        if ($list == 0) {
            $distore = new Diary;
            $distore->codigonew = $request->codigen;
            $distore->coduneg = $request->codneg;
            $distore->desuneg = $request->codneg;
            $distore->patemed = $request->pater;
            $distore->matemed = $request->mater;
            $distore->nombmed = $request->nomb;
            $distore->diremed = $request->direc;
            $distore->telemed = $request->telef;
            $distore->codclup = $request->codup;
            $distore->sexomed = $request->sexmed;
            $distore->fenamed = $request->fenac;
            $distore->cotimed = $request->tipmed;
            $distore->tipomed = $request->tipmed;
            $distore->coesmed = $request->espmed;
            $distore->espemed = $request->espmed;
            $distore->cozomed = $request->zonamed;
            $distore->zonamed = $request->zonamed;
            $distore->origenmed = $request->orimed;
            $distore->catmed = $request->categ;
            $distore->save();
        }else{
            $distore = Diary::find($request->codigen);
            $distore->desuneg = $request->codneg;
            $distore->patemed = $request->pater;
            $distore->matemed = $request->mater;
            $distore->nombmed = $request->nomb;
            $distore->diremed = $request->direc;
            $distore->telemed = $request->telef;
            $distore->codclup = $request->codup;
            $distore->sexomed = $request->sexmed;
            $distore->fenamed = $request->fenac;
            $distore->cotimed = $request->tipmed;
            $distore->tipomed = $request->tipmed;
            $distore->coesmed = $request->espmed;
            $distore->espemed = $request->espmed;
            $distore->cozomed = $request->zonamed;
            $distore->zonamed = $request->zonamed;
            $distore->origenmed = $request->orimed;
            $distore->update();
        }
        return '1';
    }
    //modulo almacenes
    public function showformad(){
        return view('compras::almped.elements.padicional.new');
    }
    public function showformlo(){
        return view('compras::almped.elements.plote.new');
    }
    public function showformin(){
        return view('compras::almped.elements.pinsumo.new');
    }
    public function showformpri(){
        return view('compras::almped.elements.pprima.new');
    }
    public function admformad(){
        return view('compras::almadm.elements.padicional.new');
    }
    public function admformlo(){
        return view('compras::almadm.elements.plote.new');
    }
    public function admformin(){
        return view('compras::almadm.elements.pinsumo.new');
    }
    public function admformpri(){
        return view('compras::almadm.elements.pprima.new');
    }
    public function admformrep(){
        return view('compras::almadm.elements.preporte.new');
    }
    //end modulo
    public function showl($id){
        return view('compras::tender.elements.new', compact('id'));
    }
    public function showo($id){
        return view('compras::order.elements.new', compact('id'));
    }
    public function showm($id){
        return view('compras::liorrep.elements.showp', compact('id'));
    }
    public function showla($id){
        return view('compras::admtender.elements.new', compact('id'));
    }
    public function showlp($id){
        return view('compras::listorder.elements.new', compact('id'));
    }
    public function infol($id){
        return iUnit::where('cnunecreg', $id)->get();
    }
    public function infoo($id){
        return iUnit::where('cnunecreg', $id)->get();
    }

    public function reportedata(Request $request){
        $request->validate([
            'init' => 'required',
            'endt' => 'required'
        ]);
        return $request->all(['tipo','init', 'endt']);
    }
    public function showrep($typep,$init, $end){
        return view('compras::almadm.elements.preporte.newreport', compact('typep','init', 'end'));
    }
    public function dtreport($typep,$init, $end){
        $query = "select idpeal as idp,ordprod as ord,numlote as num,timat as sub,descprod as descp,pfecha as pf,almpedadd.codartalm as codart,almpedadd.namprodalm as nomart,almpedadd.cantidadalm as cant 
        from almped 
        join almpedadd on idpedalm = idpeal 
        where tiped = '$typep' 
        and (pfecha >= '$init' and pfecha <= '$end')
        and almpedadd.stateresi = '0'";
        $list = DB::select($query);
        return DataTables::of($list)->ToJson();
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
    

    public function artstoreo(Request $request)
    {

        $storep = new Pedido;
        $storep->idpedido = $request->tl;
        $storep->codeneg = $request->tn;
        $storep->fechap = date('d-m-Y');
        $storep->codeart = $request->ta;
        $storep->cantidad = $request->tc;
        $storep->codenegdesc = $request->tad;
        $storep->unidad = $request->tuni;
        $storep->state = 1;
        $storep->stateenv = 1;
        $storep->save();
        return Pedido::alias()->get();

    }
    public function pestore(Request $request)
    {

        $storepp = new Ped;
        $storepp->idneg = $request->idn;
        $storepp->pfecha = date('d-m-Y');
        $storepp->statep = 1;
         $storepp->stresa = 1;
        $storepp->pdesc = "Pedido";
        $storepp->save();
        return Ped::alias()->orderBy("idped")->get();

    }
    public function storet(Request $request)
    {
        $storet = new Petemp;
        $storet->codenegtemp = $request->cod;
        $storet->codearttemp = $request->coda;
        $storet->cantidadtemp = $request->cant;
        $storet->codenegdesctemp = $request->coddesc;
        $storet->codeartdesctemp = $request->codadesc;
        $storet->save();
        return Petemp::alias()->get();
    }
    public function artstore(Request $request)
    {
        $lic = new Licitacion;
        $lic->idlicitacion = $request->tl;
        $lic->codeneg = $request->tn;
        $lic->codeart = $request->ta;
        $lic->codeartdesc = $request->tad;
        $lic->cantreq = $request->tc;
        $lic->probad = $request->un;
        $lic->stateli = 1;
        $lic->stateresi = 1;
        $lic->save();
        return Licitacion::alias()->get();
    }
    public function listore(Request $request)
    {
        $listore = new Lic;
        $listore->idneg = $request->idn;
        $listore->idadj = $request->ida;
        $listore->descadj = $request->desca;
        $listore->probadj = $request->proba;
        $listore->fechasol = date('d-m-Y');
        $listore->fechaent = $request->fent;
        $listore->stateadj = 1;
        $listore->stateresa = 1;
        $listore->cuce = $request->cuce;
        $listore->staterot = $request->rot;
        $listore->detrot = $request->drot;
        $listore->obslic = $request->obs;
        $listore->save();
        return Lic::alias()->orderBy("idlicd")->get();
    }
    public function lists(){
        $list = Store::alias()->where('afalmstte', 1)->orderBy('afalmcorr')->get();
        return DataTables::of($list)->toJson();
    }
    public function listas(){
        $list = Pedido::alias()->orderBy('id')->get();
        return DataTables::of($list)->toJson();
    }
    public function listast(){
        $list = Petemp::alias()->orderBy('idtemp')->get();
        return DataTables::of($list)->toJson();
    }
    public function lilists(){
        $list = Lictemp::alias()->orderBy('idlitemp')->get();
        return DataTables::of($list)->toJson();
    }
    //list por pedidos almacen
    public function palists($id){
        $list = Almpedido::alias()
                ->where('tiped', $id)
                ->where('statelog', 1)
                ->orderByDesc('idpa')
                ->get();
        return DataTables::of($list)->toJson();
    }
    public function admlists($id){
        $list = Almpedido::alias()
                ->where('tiped', $id)
                ->where('statep', 0)
                ->orderByDesc('idpa')
                ->get();
        return DataTables::of($list)->toJson();
    }
    public function alstore(Request $request)
    {
        $current = Auth::getUser();
        $alstore = new Almpedido;
        $alstore->ordprod = $request->prod;
        $alstore->numlote = $request->lote;
        $alstore->tiped = $request->tipo;
        $alstore->timat = $request->mater;
        $alstore->pfecha = $request->fec;
        $alstore->priority = $request->pri;
        $alstore->statep = 1;
        $alstore->stater = 1;
        $alstore->statelog = 1;
        $alstore->observacionpeal = $request->ob;
        $alstore->fechasoli = date('d-m-Y');
        $alstore->iduserp = $current->id;
        $alstore->correo = $current->email;
        $alstore->nameuserp = $current->usersnoml;
        $alstore->descprod = $request->desc;
        $alstore->save();
        
        return Almpedido::alias()->orderBy("idpa")->get();
    }
    public function aldetstore(Request $request,$id)
    {
        $request->validate([
            'list' => 'required'
        ]);
        foreach ($request->list as $item){
            $detstore = new Almpeddet();
            $detstore->idpedalm = $id;
            $detstore->codartalm = $item['insu'];
            $detstore->namprodalm = $item['nomb'];
            $detstore->cantidadalm = intval($item['cant']);
            $detstore->stateresi = 1;
            $detstore->stateenv = 1;
            $detstore->save();
        }
        return Almpeddet::alias()->get();
    }
    public function artdetstore(Request $request)
    {
        
        $detstore = new Almpeddet();
        $detstore->idpedalm = $request->idp;
        $detstore->codartalm = $request->insu;
        $detstore->namprodalm = $request->nomb;
        $detstore->cantidadalm = $request->cant;
        $detstore->stateresi = 1;
        $detstore->stateenv = 1;
        $detstore->save();
        return Almpeddet::alias()->get();
    }
    public function alshow($id){
        $list = Almpedido::find($id);
        return view('compras::almped.elements.padicional.detail', compact('id','list'));
        
    }
    public function lotshow($id){
        $list = Almpedido::find($id);
        return view('compras::almped.elements.plote.detail', compact('id','list'));
    }
    public function insshow($id){
        $list = Almpedido::find($id);
        return view('compras::almped.elements.pinsumo.detail', compact('id','list'));
    }
    public function prishow($id){
        $list = Almpedido::find($id);
        return view('compras::almped.elements.pprima.detail', compact('id','list'));
    }
    public function aladm($id){
        $list = Almpedido::find($id);
        return view('compras::almadm.elements.padicional.detail', compact('id','list'));
        
    }
    public function lotadm($id){
        $list = Almpedido::find($id);
        return view('compras::almadm.elements.plote.detail', compact('id','list'));
    }
    public function insadm($id){
        $list = Almpedido::find($id);
        return view('compras::almadm.elements.pinsumo.detail', compact('id','list'));
    }
    public function priadm($id){
        $list = Almpedido::find($id);
        return view('compras::almadm.elements.pprima.detail', compact('id','list'));
    }
    public function detlist($id){
        $list = Almpeddet::alias()
                ->where('idpedalm', $id)
                ->orderByDesc('iditalm')
                ->get();
        return DataTables::of($list)->toJson();
    }
    public function detprilist($id){
        $qDetail = "select almpedadd.iditalm as idia, almpedadd.codartalm as cart, itempri.itemnom as nart, almpedadd.cantidadalm as cant, almpedadd.stateresi as str
            from almpedadd 
            join itempri on itempri.itemcod = codartalm
            where idpedalm = '$id'";
        $list = DB::select($qDetail);
        return DataTables::of($list)->toJson();

    }
    public function detrefresh(Request $request){
        
        $li = Almpeddet::find($request->idia);
        $li->cantidadalm = $request->cant;
        $li->update();
        return Almpeddet::alias()->find($request->idia);
    }
    public function statedet(Request $request){
        
        $li = Almpeddet::find($request->idia);
        $li->stateresi = $request->str;
        $li->update();
        return Almpeddet::alias()->find($request->idia);
    }
    public function fecref(Request $request){
        
        $li = Almpedido::find($request->idped);
        $li->pfecha = $request->fec;
        $li->fechaaten = date('d-m-Y');
        $li->update();
        Mail::to($li->correo)->send(new MessagePartial($li));
        return Almpedido::alias()->find($request->idped);
    }
    public function confirmpeda($id){
        $storep = Almpedido::find($id);
        if ($storep->statep == 1) {
            $storep->statep = 0;
            
        }else{
            $storep->statep = 0;
        }
        if ($storep->tiped == 1 || $storep->tiped == 2) {
            $correo = [
                'cmartinez@grupoalcos.com',
                'acastillo@grupoalcos.com',
                'ngisbert@grupoalcos.com'
            ];
            $numero = count($correo);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correo[$x])
                ->send(new MessageTest($storep));
            }
            
        }elseif ($storep->tiped == 3) {
            $correo = [
                'promero@grupoalcos.com',
                'acastillo@grupoalcos.com',
                'ngisbert@grupoalcos.com'
            ];
            $numero = count($correo);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correo[$x])
                ->queue(new MessageTest($storep));
            }
        }else{
            $correo = [
                'mhurtado@grupoalcos.com',
                'acastillo@grupoalcos.com',
                'ngisbert@grupoalcos.com'
            ];
            $numero = count($correo);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correo[$x])
                ->send(new MessageTest($storep));
            }

        }
        
        
        $storep->update();
    }
    public function conpedal($id){
        $storep = Almpedido::find($id);
        if ($storep->stater == 1) {
            $storep->stater = 0;
            $storep->fechaaten = date('d-m-Y');
            Mail::to($storep->correo)->send(new MessageComplete($storep));
        }else{
            $storep->stater = 0;
            
        }
        $storep->update();
    }
    public function deletepe($id){
        $storep = Almpedido::find($id);
        if ($storep->statep == 1) {
            $storep->statelog = 0;
        }else{
            $storep->statelog = 1;
        }
        $storep->update();
    }
    //end list pedidos
    public function liclists($id){
        $list = Lic::alias()
                ->where('idneg', $id)
                ->orderByDesc('idlicd')
                ->get();
        return DataTables::of($list)->toJson();
    }
    public function pedlists($id){
        $list = Ped::alias()
                ->where('idneg', $id)
                ->orderByDesc('idped')
                ->get();
        return DataTables::of($list)->toJson();
    }
    public function admliclists($id){
        $list = Lic::alias()
                ->join('liadd','liadd.idlicitacion', '=','idlicd')
                ->where('idneg', $id)
                ->where('liadd.stateli', 1)
                ->orderByDesc('idlicd')
                ->get();
        $qDetail = "select idadj as ida,descadj as desca,fechasol as fsol, fechaent as fent,stateresa as stra ,idlicd as idl,descadj,count(*) as total,count(case liadd.stateli when '1' then null else liadd.stateli end) 
            from licd 
            join liadd on liadd.idlicitacion = idlicd 
            where idneg = '$id' group by idlicd order by idlicd desc";
        $tdetail = DB::select($qDetail);
        return DataTables::of($tdetail)->toJson();
    }
    public function apedlists($id){
        $list = Ped::alias()
                ->where('idneg', $id)
                ->where('statep', 0)
                ->orderByDesc('idped')
                ->get();
        return DataTables::of($list)->toJson();
    }
    public function listOrder($id){
        $list = Licitacion::alias()->where('idlicitacion', $id)->get();
        return DataTables::of($list)->toJson();
    }
    public function pelistOrder($id){
        $list = Pedido::alias()->where('idpedido', $id)->get();
        return DataTables::of($list)->toJson();
    }
    public function activeAreap($area){
        $avalaible = Pedido::where("codeneg", $area)
                            ->get();
        $qDetail = "select peadd.idpedido as idp,pfecha as fp,peadd.codeart as ca,peadd.codenegdesc as da,peadd.unidad as uni,peadd.cantidad as cr,peadd.observacion as obs,peadd.state as st,peadd.fechadis as fd,peadd.codeneg as neg,peadd.codartdesc as cata,peadd.stateenv as stenv
            from pedd 
            join peadd on peadd.idpedido = idped 
            where idneg = '$area' order by idped desc";
        $tdetail = DB::select($qDetail);
        return DataTables::of($tdetail)->toJson();
    }
    public function activeAreapd($area){
        $avalaible = Pedido::where("codeneg", $area)
                            ->get();
        $qDetail = "select peadd.idpedido as idp,pfecha as fp,peadd.codeart as ca,peadd.codenegdesc as da,peadd.unidad as uni,peadd.cantidad as cr,peadd.observacion as obs,peadd.state as st,peadd.fechadis as fd,peadd.codeneg as neg,peadd.codartdesc as cata,peadd.stateenv as stenv
            from pedd 
            join peadd on peadd.idpedido = idped 
            order by idped desc";
        $tdetail = DB::select($qDetail);
        return DataTables::of($tdetail)->toJson();
    }
    public function licshow($id){
        $list = Lic::find($id);
        return view('compras::tender.elements.detail', compact('id','list'));
    }

    public function licshowa($id){
        $list = Lic::find($id);
        return view('compras::admtender.elements.detail', compact('id','list'));
    }
    public function pedshow($id){
        $list = Ped::find($id);
        return view('compras::order.elements.detail', compact('id','list'));
    }
    public function pedshowa($id){
        $list = Ped::find($id);
        return view('compras::listorder.elements.detail', compact('id','list'));
    }

    

    public function remove($id){
        $store = Store::findOrFail($id);
        $store->afalmstte = 0;
        $store->update();
    }

    public function removep($id){
        $storep = Pedido::findOrFail($id);
        if ($storep->state == 1) {
            $storep->state = 0;
        }else{
            $storep->state = 1;
        }
        $storep->update();
    }
    public function removeped($id){
        $storep = Pedido::findOrFail($id);
        $storep->delete();
    }
    public function changestateli($id){
        $storep = Licitacion::findOrFail($id);
        if ($storep->stateli == 1) {
            $storep->stateli = 0;
        }else{
            $storep->stateli = 1;
        }
        $storep->update();
    }
    public function removet($id){
        $storep = Petemp::findOrFail($id);
        $storep->delete();
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
    public function refreshp(Request $request){
        
        $storep = Pedido::find($request->id);
        $storep->observacion = $request->observacion;
        $storep->fechadis = $request->fechadis;
        $storep->state = $request->state;
        $storep->update();
        return Pedido::find($request->id);
    }

    public function refresht(Request $request){
        
        $storep = Petemp::find($request->idt);
        $storep->cantidadtemp = $request->cantt;
        $storep->update();
        return Petemp::alias()->find($request->idt);
    }
    public function artrefresh(Request $request){
        
        $li = Licitacion::find($request->idli);
        $li->cantreq = $request->creq;
        $li->stateli = $request->stateli;
        $li->update();
        return Licitacion::alias()->find($request->idli);
    }
    public function peartrefresh(Request $request){
        
        $li = Pedido::find($request->id);
        $li->cantidad = $request->cant;
        $li->update();
        return Pedido::alias()->find($request->id);
    }
    public function pedartrefresh(Request $request){
        
        $li = Pedido::find($request->id);
        $li->observacion = $request->obs;
        $li->fechadis = $request->fed;
        $li->state = $request->st;
        $li->codartdesc = $request->codadesc;
        $li->stateenv = $request->stenv;
        $li->update();
        return Pedido::alias()->find($request->id);
    }
    public function admartrefresh(Request $request){
        
        $li = Licitacion::find($request->idli);
        $li->respuesta = $request->res;
        $li->update();
        return Licitacion::alias()->find($request->idli);
    }
    public function liupdate(Request $request){
        
        $liupd = Lictemp::find($request->idlit);
        $liupd->cantidadlitemp = $request->calit;
        $liupd->update();
        return Lictemp::alias()->find($request->idlit);
    }
    public function confirmlic($id){
        $storep = Lic::find($id);
        if ($storep->stateadj == 1) {
            $storep->stateadj = 0;
        }else{
            $storep->stateadj = 0;
        }
        $storep->update();
    }
    public function confirmlica($id){
        $storep = Lic::find($id);
        if ($storep->stateresa == 1) {
            $storep->stateresa = 0;
        }else{
            $storep->stateresa = 1;
        }
        $storep->update();
    }
    public function confirmped($id){
        $storep = Ped::find($id);
        if ($storep->statep == 1) {
            $storep->statep = 0;
        }else{
            $storep->statep = 0;
        }
        $storep->update();
    }
    public function confirmpeca($id){
        $storep = Ped::find($id);
        if ($storep->stresa == 1) {
            $storep->stresa = 0;
        }else{
            $storep->stresa = 1;
        }
        $storep->update();
    }
    public function admlici($area){
        $avalaible = Licitacion::where("codeneg", $area)
                            ->orderByDesc("idli")
                            ->get();
        return DataTables::of($avalaible)->toJson();
    }
    //modulo cmopras mac registro step 1
    public function indexshop(){
        return view('compras::shopreg.index');
    }
    //end modulo compras
    public function descprim($id){
        $qDetail = "select itemnom as descpri
            from itempri 
            where itemcod = '$id'";
        $list = DB::select($qDetail);
        return DataTables::of($list)->toJson();

    }
    public function storeshop(Request $request)
    {
        $request->validate([
            'codigo' => 'required'
        ]);

        $storesh = new Shoppedido;
        $storesh->codigosh = $request->codigo;
        $storesh->descripcionsh = $request->descri;
        $storesh->unidadsh = $request->unimed;
        $storesh->cantidadsh = $request->cantid;
        $storesh->fechareqsh = $request->fecreq;
        $storesh->prioritysh = $request->priori;
        $storesh->stateevprov = 0;
        $storesh->statersprov = 0;
        $storesh->staterevlog = 0;
        $storesh->statearerev = 0;
        $storesh->staterevend = 0;
        $storesh->statelog = 0;
        $storesh->statesan = 0;
        $storesh->stateinv = 0;
        $storesh->fechainicio = $request->horas;
        $storesh->save();

        return 1;
    }
    public function indexshopbo(){
        return view('compras::shopban1.index');
    }
    public function shoplists(){
        $list = Shoppedido::alias()
                ->orderByDesc('idsh')
                ->get();
        return DataTables::of($list)->toJson();
    }
    public function asigdetshop($id){
        $list = Shoppedido::find($id);
        return view('compras::shopban1.elements.asigprov', compact('id','list'));
        
    }
    public function newproshop($id){
        $list = Shoppedido::find($id);
        return view('compras::shopban1.elements.regprov', compact('id','list'));
        
    }
    public function shdetstore(Request $request,$id)
    {
        $request->validate([
            'list' => 'required'
        ]);
        foreach ($request->list as $item){
            $detstore = new Shoppeddet();
            $detstore->idshped = $id;
            $detstore->nameprov = $item['codep'];
            $detstore->detalleprov = $item['descp'];
            $detstore->docrespprov = 0;
            $detstore->statelogi = 0;
            $detstore->statecali = 0;
            $detstore->statesani = 0;
            $detstore->stateinve = 0;
            $detstore->save();
        }
        return Shoppeddet::alias()->get();
    }
    public function detprovlist($id){
        $list = Shoppeddet::alias()
                ->where('idshped', $id)
                ->orderByDesc('idshdet')
                ->get();
        return DataTables::of($list)->toJson();
    }
    public function confirasig(Request $request){
        $li = Shoppedido::find($request->idshpe);
        $li->tipopedsh = $request->tipop;
        $li->detapedsh = $request->detap;
        $li->stateevprov = 1;
        $li->fechaenvp = $request->horas;
        $li->statersprov = 1;
        $li->staterevlog = 1;
        $li->fecharesprov = date('Y-m-d');
        $li->fechaatenlog = date('Y-m-d');
        $li->update();
        return Shoppedido::alias()->find($request->idshpe);
    }
    public function indexshopbt(){
        return view('compras::shopban2.index');
    }
    public function shoplistscon(){
        $list = Shoppedido::alias()
                ->where('stateevprov', 1)
                ->orderByDesc('idshopped')
                ->get();
        return DataTables::of($list)->toJson();
    }
    public function shoplisttipo($id){
        $query = "select idtp,descripcion,(select count(*) from docprov where doctipo = idtp and idpedshop = $id) as cant
            from shoptyped where idtp = 1 or idtp = 2 or idtp = 4";
        $list = DB::select($query);
        return DataTables::of($list)->toJson();
    }
    public function shoplisttipoaprov($id){
        $query = "select idtp,descripcion,(select count(*) from docprov where doctipo = idtp and idpedshop = $id) as cant
            from shoptyped where idtp = 1 or idtp = 2 or idtp = 4 or idtp = 5";
        $list = DB::select($query);
        return DataTables::of($list)->toJson();
    }
    public function shoplistsobs(){
        $list = Shoppedido::alias()
                ->where('statersprov', 2)
                ->orderByDesc('idshopped')
                ->get();
        return DataTables::of($list)->toJson();
    }
    public function provdetshop($id){
        $list = Shoppedido::find($id);
        return view('compras::shopban2.elements.asigprov', compact('id','list'));
        
    }
    public function provdetobs($id){
        $list = Shoppedido::find($id);
        return view('compras::shopban2.elements.obsrev', compact('id','list'));
        
    }
    private function saveFiles($file, $master, $model){
        $iOriginal = $file->store('documentipo');
        $docum = new Documenttipo;
        $docum->idpedshop = $master;
        $docum->doctipo = $model;
        $docum->docname = $file->getClientOriginalName();
        $docum->docsize = $file->getClientSize();
        $docum->docmime = $file->getClientMimeType();
        $docum->docextn = $file->getClientOriginalExtension();
        $docum->docurls = $iOriginal;
        $docum->save();
        
    }
    public function respprov(Request $request){
        
        $files = $request->file('files');
        $idped = $request->desc;

        if($files){
            foreach ($files as $item){
                $this->saveFiles($item, $idped, 1);
            }
        }
    }
    public function detprovrefresh(Request $request){
        
        $li = Shoppeddet::find($request->iddetsh);
        $pu = $request->presunish;
        $fi = $request->fim;
        
        $cantiatend = $request->canatsh;
        
        if ($request->tipop == 1) {
            $cuespa = $pu * $fi;
        }else{
            $cuespa = $pu * $fi * 6.96;
        }
        $ctespa = $cuespa * $cantiatend;
        $li->tipoprov = $request->tipop;
        $li->cantaten = $request->canatsh;
        $li->fecharesp = $request->fresp;
        $li->preciounit = $request->presunish;
        $li->incoterm = $request->inco;
        $li->facimp = $request->fim;
        $li->cuepa = $cuespa;
        $li->ctepa = $ctespa;
        $li->update();
        return Shoppeddet::alias()->find($request->iddetsh);
    }
    public function respprovdet(Request $request){
        
        $files = $request->file('files');
        $idped = $request->descpro;
        $tipo = $request->doctype;
        if($files){
            foreach ($files as $item){
                $this->saveFilesdet($item, $idped, $tipo, 1);
            }
        }
    }
    private function saveFilesdet($file, $master, $tipo, $model){
        $iOriginal = $file->store('documenprov');
        $docum = new Documentprov;
        $docum->idpedshop = $master;
        $docum->doctipo = $tipo;
        $docum->docname = $file->getClientOriginalName();
        $docum->docsize = $file->getClientSize();
        $docum->docmime = $file->getClientMimeType();
        $docum->docextn = $file->getClientOriginalExtension();
        $docum->docurls = $iOriginal;
        $docum->save();
    }
    
    public function detprovref($id){
        $query = "select idshdet as iddetsh,nameprov as namepsh,detalleprov as detpsh,cantaten as canatsh,preciounit as presunish,docrespprov as docprov,fechaenvp as fenvp,fecharesp as fresp,incoterm as inco,facimp as fim, count(docprov.*) as docs, statecali as stcal, statelogi as stlog, statesani as stsan, stateinve as stinv, obcal as oca, obsan as osa,oblog as olo,obinv as oin,tipoprov as tipop
        from shoppedadd
        left join docprov on docprov.idpedshop=shoppedadd.idshdet 
        where idshped = '$id'
        group by idshdet";
        $list = DB::select($query);
        return DataTables::of($list)->ToJson();
    }
    public function statesend($id){
        
        $li = Shoppeddet::find($id);
        $li->docrespprov = 1;
        $li->fechaenvp = date('Y-m-d');
        $li->update();
        return Shoppeddet::alias()->find($id);
    }
    public function indexshopbtr(){
        return view('compras::shopban3.index');
    }
    public function shoplistspen(){
        $list = Shoppedido::alias()
                ->where('statersprov', 1)
                ->orderByDesc('idshopped')
                ->get();
        return DataTables::of($list)->toJson();
    }
    public function revlogshop($id){
        $list = Shoppedido::find($id);
        return view('compras::shopban3.elements.asigprov', compact('id','list'));
        
    }
    public function listsdocsprov($id){
        $query = "select docname, docurls
            from docprov
            where idpedshop = $id";
        $list = DB::select($query);
        return DataTables::of($list)->ToJson();
    }
    public function listsdocstipo($id){
        $query = "select iddoctipo,docname, docurls
            from doctipo
            where idpedshop = $id";
        $list = DB::select($query);
        return DataTables::of($list)->ToJson();
    }
    public function listsdocsprovs($id,$tipodoc){
        $query = "select iddocprov,docname, docurls
            from docprov
            where idpedshop = $id and doctipo = $tipodoc";
        $list = DB::select($query);
        return DataTables::of($list)->ToJson();
    }
    public function revlogi(Request $request){
        
        $idped = $request->id;
        $li = Shoppedido::find($idped);
        $li->staterevlog = 1;
        $li->obsfrst = $request->desc;
        $li->fechaatenlog = date('Y-m-d');
        $li->update();
    }
    
    public function confirmobs(Request $request){
        $files = $request->file('files');
        $idped = $request->id;
        $li = Shoppedido::find($idped);
        $li->statersprov = 2;
        $li->staterevlog = 0;
        $li->obsfrst = $request->desc;
        $li->fechaatenlog = date('Y-m-d');
        $li->update();
    }
    private function saveFilesrev($file, $master, $model){
        $iOriginal = $file->store('documenshop');
        $docum = new Documentshop;
        $docum->idpedshop = $master;
        $docum->doctipo = $model;
        $docum->docname = $file->getClientOriginalName();
        $docum->docsize = $file->getClientSize();
        $docum->docmime = $file->getClientMimeType();
        $docum->docextn = $file->getClientOriginalExtension();
        $docum->docurls = $iOriginal;
        $docum->save();
    }
    public function indexcuadro(){
        return view('compras::shopban4.index');
    }
    public function shoplistsrevi(){
        $list = Shoppedido::alias()
                ->where('staterevlog', 1)
                ->orderByDesc('idshopped')
                ->get();
        return DataTables::of($list)->toJson();
    }
    public function cuadrocomp($id){
        $list = Shoppedido::find($id);
        $query = "select * from shopped join itempre on itempre.coditem = codigosh
        where idshopped = '$id'";
        $listtwo = DB::select($query);
        return view('compras::shopban4.elements.asigprov', compact('id','list','listtwo'));
        
    }
    public function detcuadro($id){
        $query = "select idshdet,nameprov as namepsh,detalleprov as detpsh,cantaten as canatsh,preciounit as presunish,incoterm as inco,cuepa as cue,ctepa as cte,facimp as fim,(round(((cuepa-itempre.costbol)/itempre.costbol),2) * 100) as comp
        from shoppedadd
        join shopped on shopped.idshopped = shoppedadd.idshped
        join itempre on shopped.codigosh = itempre.coditem
        where idshped = '$id'";
        $list = DB::select($query);
        return DataTables::of($list)->ToJson();
    }
    public function indexresprov(){
        return view('compras::shopban5.index');
    }
    public function slistrevprov(){
        $list = Shoppedido::alias()
                ->where('staterevlog', 1)
                ->orderByDesc('idshopped')
                ->get();
        return DataTables::of($list)->toJson();
    }
    public function listoarea(){
        $query = "select idshopped as idsh, codigosh as codsh, descripcionsh as descsh, cantidadsh as cansh,fechareqsh as freqsh, prioritysh as priosh,statearerev as starevsh 
        from shopped
        where statelog = '2' or statesan = '2' or staterevend = '2' or stateinv = '2'";
        $list = DB::select($query);
        return DataTables::of($list)->ToJson();
    }
    public function resprovshop($id){
        $list = Shoppedido::find($id);
        $docs = Documenttipo::where('idpedshop', $id)
                ->orderByDesc('iddoctipo')
                ->get();
        return view('compras::shopban5.elements.asigprov', compact('id','list','docs'));
        
    }
    public function provobs($id){
        $list = Shoppedido::find($id);
        $docs = Documenttipo::where('idpedshop', $id)
                ->orderByDesc('iddoctipo')
                ->get();
        return view('compras::shopban5.elements.obsamain', compact('id','list','docs'));
        
    }
    public function confirarea(Request $request){
        $li = Shoppedido::find($request->idshpe);
        $li->obsscnd = $request->obsasig;
        $li->arearevsh = $request->arearev;
        $li->arearevlo = $request->arelo;
        $li->arearevsa = $request->aresa;
        $li->arearevin = $request->arein;
        $li->fecharegrev = $request->horas;
        $li->statearerev = 1;
        if ($request->arein == 1) {
            $correoinv = [
                'gsiles@grupoalcos.com'
            ];
            $numero = count($correoinv);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correoinv[$x])
                ->send(new MessageSeg($li));
            }
        }elseif ($request->arein == 0 && $li->arearevlo == 1) {
            $correolog = [
                'rquispe@grupoalcos.com',
                'dleonardini@grupoalcos.com',
                'ngisbert@grupoalcos.com'
            ];
            $numero = count($correolog);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correolog[$x])
                ->send(new MessageSeg($li));
            }
        }elseif ($request->arein == 0 && $request->arelo == 0 && $request->aresa == 1) {
            $correosan = [
                'ctelleria@grupoalcos.com',
                'registrosanitario@grupoalcos.com'
            ];
            $numero = count($correosan);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correosan[$x])
                ->send(new MessageSeg($li));
            }
        }elseif ($request->arein == 0 && $request->arelo == 0 && $request->aresa == 0 && $request->arearev == 1) {
            $correocal = [
                'jpaucar@grupoalcos.com',
                'gconurana@grupoalcos.com',
                'bcallizaya@grupoalcos.com'
            ];
            $numero = count($correocal);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correocal[$x])
                ->send(new MessageSeg($li));
            }
        }
        $li->update();
        
        return Shoppedido::alias()->find($request->idshpe);
    }
    public function confirareat(Request $request){
        $docum = new Shoppedrev;
        $docum->idshped = $request->idshpe;
        $docum->tiporev = $request->tipoped;
        $docum->staterev = 0;
        $docum->fechaini = date('Y-m-d');
        $docum->save();
        return Shoppedrev::alias()->find($request->idshpe);
    }
    public function confareaobs(Request $request){
        $li = Shoppedido::find($request->idshpe);
        $li->obsscnd = $request->obsasig;
        $li->fecharegrev = date('Y-m-d');
        if($request->in == 2){
            $li->stateinv = 0;
            $li->update();
            $correoinv = [
                'gsiles@grupoalcos.com'
            ];
            $numero = count($correoinv);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correoinv[$x])
                ->send(new MessageSeg($li));
            }
        }elseif ($request->lo == 2) {
            $li->statelog = 0;
            $li->update();
            $correolog = [
                'rquispe@grupoalcos.com',
                'dleonardini@grupoalcos.com',
                'ngisbert@grupoalcos.com'
            ];
            $numero = count($correolog);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correolog[$x])
                ->send(new MessageSeg($li));
            }
        }elseif ($request->sa == 2) {
            $li->statesan = 0;
            $li->update();
            $correosan = [
                'ctelleria@grupoalcos.com',
                'registrosanitario@grupoalcos.com'
            ];
            $numero = count($correosan);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correosan[$x])
                ->send(new MessageSeg($li));
            }
        }elseif ($request->ca == 2) {
            $li->staterevend = 0;
            $li->update();
            $correocal = [
                'jpaucar@grupoalcos.com',
                'gconurana@grupoalcos.com',
                'bcallizaya@grupoalcos.com'
            ];
            $numero = count($correocal);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correocal[$x])
                ->send(new MessageSeg($li));
            }
        }else{
            Mail::to('haliaga@grupoalcos.com')
                ->send(new MessageSeg($li));
        }
        
        return Shoppedido::alias()->find($request->idshpe);
    }
    public function indexaprov(){
        return view('compras::shopban6.index');
    }
    public function listpenaprov(){
        
        $query = "select idshopped as idsh, codigosh as codsh, descripcionsh as descsh, cantidadsh as cansh,fechareqsh as freqsh, prioritysh as priosh,staterevend as strfinsh 
        from shopped
        where (arearevsh = '1' and arearevsa = '1' and statesan = '1' and arearevlo = '1' and statelog = '1' and arearevin = '1' and stateinv = '1') 
        or (arearevsh = '1' and arearevsa = '1' and statesan = '1' and arearevlo = '1' and statelog = '1' and arearevin = '0')
        or (arearevsh = '1' and arearevsa = '1' and statesan = '1' and arearevlo = '0' and arearevin = '1' and stateinv = '1')
        or (arearevsh = '1' and arearevsa = '0' and arearevlo = '1' and statelog = '1' and arearevin = '1' and stateinv = '1')
        or (arearevsh = '1' and arearevsa = '0' and arearevlo = '0' and arearevin = '1' and stateinv = '1')
        or (arearevsh = '1' and arearevsa = '0' and arearevlo = '1' and statelog = '1' and arearevin = '0')
        or (arearevsh = '1' and arearevsa = '1' and statesan = '1' and arearevlo = '0' and arearevin = '0')
        or (arearevsh = '1' and arearevsa = '0' and arearevlo = '0' and arearevin = '0') order By idshopped desc";
        $list = DB::select($query);
        return DataTables::of($list)->ToJson();
    }
    public function aprovshop($id){
        $list = Shoppedido::find($id);
        $docs = Documenttipo::where('idpedshop', $id)
                ->orderByDesc('iddoctipo')
                ->get();
        $revss = Shoppedrev::where('idshped', $id)
                ->where('tiporev', 4)
                ->get();
        return view('compras::shopban6.elements.asigprov', compact('id','list','docs','revss'));
        
    }
    
    public function aprovarea(Request $request){
        
        $files = $request->file('files');
        $idped = $request->descproadd;
        if($files){
            foreach ($files as $item){
                $this->saveFilesrev($item, $idped, 1);
            }
        }
    }
    public function filetipodel($id){
        $li = Documentprov::find($id);
        $li->delete();
        return 10;
    }
    public function indexrevlog(){
        return view('compras::shopbanlog.index');
    }
    public function indexrevinv(){
        return view('compras::shopbaninv.index');
    }
    public function indexrevsan(){
        return view('compras::shopbansan.index');
    }
    public function listlog(){
        $query = "select idshopped as idsh, codigosh as codsh, descripcionsh as descsh, cantidadsh as cansh,fechareqsh as freqsh, prioritysh as priosh,statelog as stlo 
        from shopped
        where (arearevlo = '1' and arearevin = '1' and stateinv = '1') or (arearevlo = '1' and arearevin = '0') order By idshopped desc";
        $list = DB::select($query);
        return DataTables::of($list)->ToJson();
    }
    public function listinv(){
        $list = Shoppedido::alias()
                ->where('statearerev', 1)
                ->where('arearevin', 1)
                ->orderByDesc('idshopped')
                ->get();
        return DataTables::of($list)->toJson();
    }
    public function listsan(){
        $query = "select idshopped as idsh, codigosh as codsh, descripcionsh as descsh, cantidadsh as cansh,fechareqsh as freqsh, prioritysh as priosh,statesan as stsa 
        from shopped
        where (arearevsa = '1' and arearevlo = '1' and statelog = '1' and arearevin = '1' and stateinv = '1') 
        or (arearevsa = '1' and arearevlo = '1' and statelog = '1' and arearevin = '0')
        or (arearevsa = '1' and arearevlo = '0' and arearevin = '1' and stateinv = '1')
        or (arearevsa = '1' and arearevlo = '0' and arearevin = '0') order By idshopped desc";
        $list = DB::select($query);
        return DataTables::of($list)->ToJson();
    }
    public function logshop($id){
        $list = Shoppedido::find($id);
        $docs = Documenttipo::where('idpedshop', $id)
                ->orderByDesc('iddoctipo')
                ->get();
        $rev = Shoppedrev::where('idshped', $id)
                ->where('tiporev', 2)
                ->get();
        return view('compras::shopbanlog.elements.asigprov', compact('id','list','docs','rev'));
        
    }
    public function invshop($id){
        $list = Shoppedido::find($id);
        $docs = Documenttipo::where('idpedshop', $id)
                ->orderByDesc('iddoctipo')
                ->get();
        $rev = Shoppedrev::where('idshped', $id)
                ->where('tiporev', 1)
                ->get();
        return view('compras::shopbaninv.elements.asigprov', compact('id','list','docs','rev'));
        
    }
    public function sanshop($id){
        $list = Shoppedido::find($id);
        $docs = Documenttipo::where('idpedshop', $id)
                ->orderByDesc('iddoctipo')
                ->get();
        $rev = Shoppedrev::where('idshped', $id)
                ->where('tiporev', 3)
                ->get();
        return view('compras::shopbansan.elements.asigprov', compact('id','list','docs','rev'));
        
    }
    public function conflog(Request $request){
        $li = Shoppedido::find($request->idshpe);
        $li->comentlog = $request->comentario;
        $li->statelog = 1;
        $li->ffinl = $request->horas;
        if ($request->san == 1) {
            $correosan = [
                'ctelleria@grupoalcos.com',
                'registrosanitario@grupoalcos.com'
            ];
            $numero = count($correosan);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correosan[$x])
                ->send(new MessageSeg($li));
            }
        }elseif ($request->san == 0 && $request->cal == 1) {
            $correocal = [
                'jpaucar@grupoalcos.com',
                'gconurana@grupoalcos.com',
                'bcallizaya@grupoalcos.com'
            ];
            $numero = count($correocal);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correocal[$x])
                ->send(new MessageSeg($li));
            }
        }else{
            $correocom = [
                'larce@grupoalcos.com',
                'wsoria@grupoalcos.com'
            ];
            $numero = count($correocom);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correocom[$x])
                ->send(new MessageLog($li));
            }
        }
        $li->update();
        $ter = Shoppedrev::find($request->revis);
        $ter->coment = $request->comentario;
        $ter->staterev = 1;
        $ter->fechafin = date('Y-m-d');
        $ter->update();

        return Shoppedido::alias()->find($request->idshpe);
    }
    public function confinv(Request $request){
        $li = Shoppedido::find($request->idshpe);
        $li->comentinv = $request->comentario;
        $li->stateinv = 1;
        $li->ffini = $request->horas;
        if ($request->log == 1) {
            $correolog = [
                'rquispe@grupoalcos.com',
                'dleonardini@grupoalcos.com',
                'ngisbert@grupoalcos.com'
            ];
            $numero = count($correolog);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correolog[$x])
                ->send(new MessageSeg($li));
            }
        }elseif ($request->log == 0 && $request->san == 1) {
            $correosan = [
                'ctelleria@grupoalcos.com',
                'registrosanitario@grupoalcos.com'
            ];
            $numero = count($correosan);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correosan[$x])
                ->send(new MessageSeg($li));
            }
        }elseif ($request->log == 0 && $request->san == 0 && $request->cal == 1) {
            $correocal = [
                'jpaucar@grupoalcos.com',
                'gconurana@grupoalcos.com',
                'bcallizaya@grupoalcos.com'
            ];
            $numero = count($correocal);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correocal[$x])
                ->send(new MessageSeg($li));
            }
        }else{
            $correocom = [
                'larce@grupoalcos.com',
                'wsoria@grupoalcos.com'
            ];
            $numero = count($correocom);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correocom[$x])
                ->send(new MessageInv($li));
            }
        }
        $li->update();
        $ter = Shoppedrev::find($request->revis);
        $ter->coment = $request->comentario;
        $ter->staterev = 1;
        $ter->fechafin = date('Y-m-d');
        $ter->update();
        return Shoppedido::alias()->find($request->idshpe);
    }
    public function confsan(Request $request){
        $li = Shoppedido::find($request->idshpe);
        $li->comentsan = $request->comentario;
        $li->statesan = 1;
        $li->ffins = $request->horas;
        if ($request->cal == 1) {
            $correocal = [
                'jpaucar@grupoalcos.com',
                'gconurana@grupoalcos.com',
                'bcallizaya@grupoalcos.com'
            ];
            $numero = count($correocal);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correocal[$x])
                ->send(new MessageSeg($li));
            }
        }else{
            $correocom = [
                'larce@grupoalcos.com',
                'wsoria@grupoalcos.com'
            ];
            $numero = count($correocom);
            for ($x=0;$x<$numero; $x++){
                Mail::to($correocom[$x])
                ->send(new MessageSan($li));
            }
        }
        $li->update();
        $ter = Shoppedrev::find($request->revis);
        $ter->coment = $request->comentario;
        $ter->staterev = 1;
        $ter->fechafin = date('Y-m-d');
        $ter->update();
        return Shoppedido::alias()->find($request->idshpe);
    }
    public function obsslog(Request $request){
        $li = Shoppedido::find($request->idshpe);
        $li->comentlog = $request->comentario;
        $li->statelog = 2;
        $li->update();
        $correocom = [
            'larce@grupoalcos.com',
            'wsoria@grupoalcos.com'
        ];
        $numero = count($correocom);
        for ($x=0;$x<$numero; $x++){
            Mail::to($correocom[$x])
            ->send(new MessageObs($li));
        }
        return Shoppedido::alias()->find($request->idshpe);
    }
    public function obssinv(Request $request){
        $li = Shoppedido::find($request->idshpe);
        $li->comentinv = $request->comentario;
        $li->stateinv = 2;
        $li->update();
        $correocom = [
            'larce@grupoalcos.com',
            'wsoria@grupoalcos.com'
        ];
        $numero = count($correocom);
        for ($x=0;$x<$numero; $x++){
            Mail::to($correocom[$x])
            ->send(new MessageObs($li));
        }
        return Shoppedido::alias()->find($request->idshpe);
    }
    public function obsscal(Request $request){
        $li = Shoppedido::find($request->idshpe);
        $li->obsthrd = $request->comentario;
        $li->staterevend = 2;
        $li->update();
        $correocom = [
            'larce@grupoalcos.com',
            'wsoria@grupoalcos.com'
        ];
        $numero = count($correocom);
        for ($x=0;$x<$numero; $x++){
            Mail::to($correocom[$x])
            ->send(new MessageObs($li));
        }
        return Shoppedido::alias()->find($request->idshpe);
    }
    public function appcal(Request $request){
        $li = Shoppedido::find($request->idshpe);
        $li->obsthrd = $request->comentario;
        $li->staterevend = 1;
        $li->ffinc = $request->horas;
        $li->fechaaprov = $request->horas;
        $correocom = [
            'larce@grupoalcos.com',
            'wsoria@grupoalcos.com'
        ];
        $numero = count($correocom);
        for ($x=0;$x<$numero; $x++){
            Mail::to($correocom[$x])
            ->send(new MessageCal($li));
        }        
        $li->update();
        $ter = Shoppedrev::find($request->revis);
        $ter->coment = $request->comentario;
        $ter->staterev = 1;
        $ter->fechafin = date('Y-m-d');
        $ter->update();
        return Shoppedido::alias()->find($request->idshpe);
    }
    public function obsssan(Request $request){
        $li = Shoppedido::find($request->idshpe);
        $li->comentsan = $request->comentario;
        $li->statesan = 2;
        $correocom = [
            'larce@grupoalcos.com',
            'wsoria@grupoalcos.com'
        ];
        $numero = count($correocom);
        for ($x=0;$x<$numero; $x++){
            Mail::to($correocom[$x])
            ->send(new MessageObs($li));
        }    
        $li->update();
        return Shoppedido::alias()->find($request->idshpe);
    }

    public function indexorden(){
        return view('compras::shopban7.index');
    }
    public function listapsh(){
        $query = "select idshopped as idsh, codigosh as codsh, descripcionsh as descsh, cantidadsh as cansh,fechareqsh as freqsh, prioritysh as priosh,statesan as stsa 
        from shopped
        where (arearevsa = '1' and arearevlo = '1' and arearevin = '1' and arearevsh = '1' and stateinv = '1' and statelog = '1' and statesan = '1' and staterevend = '1') 
            or (arearevsa = '1' and arearevlo = '1' and arearevin = '0' and arearevsh = '1' and stateinv = '0' and statelog = '1' and statesan = '1' and staterevend = '1') 
            or (arearevsa = '1' and arearevlo = '0' and arearevin = '0' and arearevsh = '1' and stateinv = '0' and statelog = '0' and statesan = '1' and staterevend = '1') 
            or (arearevsa = '0' and arearevlo = '0' and arearevin = '0' and arearevsh = '1' and stateinv = '0' and statelog = '0' and statesan = '0' and staterevend = '1')
            or (arearevsa = '1' and arearevlo = '0' and arearevin = '0' and arearevsh = '0' and stateinv = '0' and statelog = '0' and statesan = '1' and staterevend = '0')
            or (arearevsa = '0' and arearevlo = '1' and arearevin = '0' and arearevsh = '0' and stateinv = '0' and statelog = '1' and statesan = '0' and staterevend = '0')
            or (arearevsa = '0' and arearevlo = '0' and arearevin = '1' and arearevsh = '0' and stateinv = '1' and statelog = '0' and statesan = '0' and staterevend = '0') order By idshopped desc";
        $list = DB::select($query);
        return DataTables::of($list)->ToJson();
    }
    public function aprovdetshop($id){
        $list = Shoppedido::find($id);
        $docs = Documenttipo::where('idpedshop', $id)
                ->orderByDesc('iddoctipo')
                ->get();
        return view('compras::shopban7.elements.asigprov', compact('id','list','docs'));
        
    }
    public function sanaprov($id){
        $li = Shoppeddet::find($id);
        $li->statesani = 1;
        $li->update();
        return Shoppeddet::alias()->find($id);
        
    }
    public function sanreprov($id){
        $li = Shoppeddet::find($id);
        $li->statesani = 2;
        $li->update();
        return Shoppeddet::alias()->find($id);
        
    }
    public function logaprov($id){
        $li = Shoppeddet::find($id);
        $li->statelogi = 1;
        $li->update();
        return Shoppeddet::alias()->find($id);
        
    }
    public function logreprov($id){
        $li = Shoppeddet::find($id);
        $li->statelogi = 2;
        $li->update();
        return Shoppeddet::alias()->find($id);
        
    }
    public function calaprov($id){
        $li = Shoppeddet::find($id);
        $li->statecali = 1;
        $li->update();
        return Shoppeddet::alias()->find($id);
        
    }
    public function calreprov($id){
        $li = Shoppeddet::find($id);
        $li->statecali = 2;
        $li->update();
        return Shoppeddet::alias()->find($id);
        
    }
    public function invaprov($id){
        $li = Shoppeddet::find($id);
        $li->stateinve = 1;
        $li->update();
        return Shoppeddet::alias()->find($id);
        
    }
    public function invreprov($id){
        $li = Shoppeddet::find($id);
        $li->stateinve = 2;
        $li->update();
        return Shoppeddet::alias()->find($id);
        
    }
    public function cleanobsprov($id){
        $li = Shoppeddet::find($id);
        $li->obcal = "";
        $li->oblog = "";
        $li->obsan = "";
        $li->obinv = "";
        $li->update();
        return Shoppeddet::alias()->find($id);
        
    }
    public function regobin(Request $request){
        
        $li = Shoppeddet::find($request->iddetsh);
        $li->obinv = $request->oin;
        $li->update();
        return Shoppeddet::alias()->find($request->iddetsh);
    }
    public function regoblo(Request $request){
        
        $li = Shoppeddet::find($request->iddetsh);
        $li->oblog = $request->olo;
        $li->update();
        return Shoppeddet::alias()->find($request->iddetsh);
    }
    public function regobsa(Request $request){
        
        $li = Shoppeddet::find($request->iddetsh);
        $li->obsan = $request->osa;
        $li->update();
        return Shoppeddet::alias()->find($request->iddetsh);
    }
    public function regobca(Request $request){
        
        $li = Shoppeddet::find($request->iddetsh);
        $li->obcal = $request->oca;
        $li->update();
        return Shoppeddet::alias()->find($request->iddetsh);
    }
}