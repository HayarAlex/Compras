<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Liffe\Compras\App\Models\Mysql\Zone;
use Liffe\Compras\app\Core\Transfer\Transfer;
use Yajra\DataTables\Facades\DataTables;

class TransferController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('compras::transfer.index');
    }

    public function indexEdit(){
        return view('compras::transfer_mode.index');
    }

    public function listActives($user){
        $query = "select 
                    afmaecodi as codi,
                    afmaedscr as detl,
                    afcondesc as stat
                  from afmae inner join afcon
                    on afmaestat = afconcorr and afconpref = 3
                  where afmaeresp = $user
                  and afmaemtvo is null";
        $list = DB::connection("informix")->select($query);
        return DataTables::of($list)->toJson();
    }

    public function getResponsable($userId){
        $query = "select first 1
                    suempcemp as cemp,
                    suempnemp as nemp,
                    suempuneg as cung,
                    suempccos as ccos,
                    cnunedesc as nung,
                    cnccodesc as ncos
                  from suemp inner join cnune
                    on suempuneg = cnuneuneg inner join cncco
                    on suempccos = cnccoccos
                  where suempcemp = $userId";
        $user = DB::connection("informix")->select($query);
        if(!$user){
            $query = "select first 1
                     gbagecage as cemp,
                     gbagenomb as nemp,
                     gbageuneg as cung
                  from gbage 
                  where gbagecage = $userId";
            $user = DB::connection("informix")->select($query);
        }
        return count($user) > 0 ? response()->json($user[0]) : "";
    }

    public function listResponsables(Request $request){
        $request->validate([
            "srch" => "required"
        ]);
        $user = strtoupper($request->srch);

//        $query = "select
//                    suempcemp as cemp,
//                    suempnemp as nemp,
//                    suempuneg as cung,
//                    suempccos as ccos,
//                    cnunedesc as nung,
//                    cnccodesc as ncos
//                  from suemp inner join cnune
//                    on suempuneg = cnuneuneg inner join cncco
//                    on suempccos = cnccoccos
//                  where suempnemp like '%$user%'";

        $query = "select 
                     gbagecage as cemp,
                     gbagenomb as nemp,
                     gbageuneg as cung
                  from gbage 
                  where gbagecage >= 10000
                      and gbagecage <= 999999
                      and gbagestat = 1
                      and gbagenomb like '%$user%'";
        $user = DB::connection("informix")->select($query);
        return $user;
    }
    public function listEspecialidades(Request $request){
        
        $request->validate([
            "srch" => "required"
        ]);
        $user = strtoupper($request->srch);

        $query = "select 
                     gbrubrubr as cesp,
                     gbrubdesc as desp
                  from gbrub
                  where gbrubrubr between 600 and 699 and gbrubdesc like '%$user%' ";
        $user = DB::connection("informix")->select($query);
        return $user;
    }
    public function listEspeup($id){

        $query = "select 
                     gbrubrubr as cesp,
                     gbrubdesc as desp
                  from gbrub
                  where gbrubrubr between 600 and 699 and gbrubrubr = $id";
        $user = DB::connection("informix")->select($query);
        return $user;
    }
    public function listZonup($id){
        $query = "select 
                    codigo_zona as czona,
                    nombre_zona as dzona 
                  from dm_zonas 
                  where codigo_zona = $id and codigo_zona is not null group by codigo_zona ";
        
        $user = DB::connection('zonas')->select($query);
        return $user;
    }
    public function listZonas($id){
        
        

        $query = "select 
                    codigo_zona as czona,
                    nombre_zona as dzona 
                  from dm_zonas
                  where codigo_unidad = $id and codigo_zona is not null group by codigo_zona ";
        
        $user = DB::connection('zonas')->select($query);
        return $user;
    }

    public function listCustom(Request $request){

        $request->validate([
            "srch" => "required"
        ]);
        $user = $request->srch;

        $query = "select SpecialtyName as desp 
                  from AVA_MVSystem_ALCOS.Administration.Customer
                  where SpecialtyName like '%$user%'";
        
        $user = DB::connection('sqlsrv')->select($query);
        return $user;
    }

    public function listZonamed($id){
        $query = "select 
                    codigo_zona as czona,
                    nombre_zona as dzona 
                  from dm_zonas 
                  where codigo_unidad = $id and codigo_zona is not null group by codigo_zona ";
        
        $user = DB::connection('zonas')->select($query);
        return $user;
    }

    public function listArticulos(Request $request){
        
        $request->validate([
            "srch" => "required"
        ]);
        $user = strtoupper($request->srch);

        $query = "select 
                     inartcart as cart,
                     inartdesc as dart,
                     inconabre as unid
                  from inart, incon
                  where inartumut = inconcorr and inconpref = 5 and (inartcart like '%$user%' or inartdesc like '%$user%')";
        $user = DB::connection("informix")->select($query);
        return $user;
    }
    public function listInstitutos(Request $request){
        
        $request->validate([
            "srch" => "required"
        ]);
        $usern = strtoupper($request->srch);
        $userc = intval($request->srch);

//        $query = "select
//                    suempcemp as cemp,
//                    suempnemp as nemp,
//                    suempuneg as cung,
//                    suempccos as ccos,
//                    cnunedesc as nung,
//                    cnccodesc as ncos
//                  from suemp inner join cnune
//                    on suempuneg = cnuneuneg inner join cncco
//                    on suempccos = cnccoccos
//                  where suempnemp like '%$user%'";

        $query = "select 
                     gbagecage as cins,
                     gbagenomb as dins
                  from gbage
                  where gbagecage > 999999 
                      and gbagedpto = 27 
                      and gbagecage = '$userc'
                      or gbagenomb like '%$usern%'";
        $user = DB::connection("informix")->select($query);
        return $user;
    }
    //consulta para almacenes lotes
    public function listLotes(Request $request){
        
        $request->validate([
            "srch" => "required"
        ]);
        $usern = strtoupper($request->srch);

        $query = "select 
                     pdophordp as idorden,
                     pdophndoc as idlote
                  from pdoph
                  where pdophndoc like '%$usern%'";
        $user = DB::connection("informix")->select($query);
        return $user;
    }
    public function listProd($id){
        $usern = strtoupper($id);
        $query = "select 
                     pdophordp as idord
                  from pdoph
                  where pdophndoc = '$usern'";
        $list = DB::connection("informix")->select($query);
        return DataTables::of($list)->toJson();
    }
    public function listMedag($id){
        $usern = strtoupper($id);
        $query = "select gbagecage as id,gbageappa as pat,gbageapma as mat,gbagenoms as nom, gbagerubr as codesp,gbrub.gbrubdesc as espdesc, CONCAT(gbagedir1,gbagedir2) as dir, gbagezona as zon
        from gbage
        join gbrub on gbrubrubr = gbagerubr
        where gbagepais = $id and gbagetipo = 10 order by gbagecage desc";
        $list = DB::connection("informix")->select($query);
        return DataTables::of($list)->toJson();
    }
    public function listNomprod($ord, $mat){
        $usern = strtoupper($mat);
        $query = "select inartdesc as desc
                  from inart 
                  join pdopd on pdopdprod = inartcart 
                  where pdopdprod ='$usern' and pdopdordp = $ord";
        $list = DB::connection("informix")->select($query);
        return DataTables::of($list)->toJson();
    }
    public function listDataitem($ord){
        $query = "select
                     inartdesc as dart,
                     inconabre as unid
                  from inart, incon
                  where inartumut = inconcorr and inconpref = 5 and inartcart like '%$ord%'";
        $list = DB::connection("informix")->select($query);
        return DataTables::of($list)->toJson();
    }
    //agenda consulta de codigo
    public function listCodenew($code, $lim){
        $cini = intval($code);
        $cend = intval($lim);
        $query = "select max(gbagecage) as ultimo
                  from gbage
                  where gbagetipo = 10 and gbagecage between $cini and $cend";
        $list = DB::connection("informix")->select($query);
        return DataTables::of($list)->toJson();
    }
    public function listOrden($id){

        $query = "select 
                     pdopdordp as valord,
                     pdopdprod as prod
                  from pdopd
                  where pdopdordp = $id";
        $list = DB::connection("informix")->select($query);
        return DataTables::of($list)->toJson();
    }
    public function listRece($id){
        $usern = strtoupper($id);
        $query = "select 
                      pdrininsu as insu,
                      pdrincant as cant,
                      inart.inartdesc as nomb
                  from pdrin 
                  join inart on inartcart = pdrininsu 
                  where pdrinprod = '$usern' and pdrinnrec = 1 and (inartcgru = 501 or inartcgru = 502)";
        $list = DB::connection("informix")->select($query);
        return DataTables::of($list)->toJson();
    }
    public function listProvee($id){
        $usern = strtoupper($id);
        $query = "select 
                      gbage.gbagecage as codep,
                      gbage.gbagenomb as descp
                  from cocpv
                  join gbage on cocpvcpvd = gbagecage
                  where cocpvcart = '$usern'";
        $list = DB::connection("informix")->select($query);
        return DataTables::of($list)->toJson();
    }
    public function showDispo($id){
        $usern = strtoupper($id);
        $query = "select inaalcart , sum(inaalstot) as suma from inaal where inaalcart = '$usern' and inaalcalm in (34,29) group by inaalcart";
        $list = DB::connection("informix")->select($query);
        return DataTables::of($list)->toJson();
    }
    public function showDispoin($id){
        $usern = strtoupper($id);
        $query = "select inaalcart , sum(inaalstot) as suma from inaal where inaalcart = '$usern' and inaalcalm in (35) group by inaalcart";
        $list = DB::connection("informix")->select($query);
        return DataTables::of($list)->toJson();
    }
    public function showDispopri($id){
        $usern = strtoupper($id);
        $query = "select inaalcart , sum(inaalstot) as suma from inaal where inaalcart = '$usern' and inaalcalm in (23,24) group by inaalcart";
        $list = DB::connection("informix")->select($query);
        return DataTables::of($list)->toJson();
    }
    public function listRecelo($id){
        $usern = strtoupper($id);
        $query = "select 
                      pdrininsu as insu,
                      pdrincant as cant,
                      inart.inartdesc as nomb
                  from pdrin 
                  join inart on inartcart = pdrininsu 
                  where pdrinprod = '$usern' and pdrinnrec = 1 and pdrininsu not like '%CS%' and pdrininsu not like '%AES%' and pdrininsu not like '%CL%' and pdrininsu not like '%BA%' and pdrininsu not like '%BE%'";
        $list = DB::connection("informix")->select($query);
        return DataTables::of($list)->toJson();
    }
    public function listArti(Request $request){
        
        $request->validate([
            "srch" => "required"
        ]);
        $user = strtoupper($request->srch);

//        $query = "select
//                    suempcemp as cemp,
//                    suempnemp as nemp,
//                    suempuneg as cung,
//                    suempccos as ccos,
//                    cnunedesc as nung,
//                    cnccodesc as ncos
//                  from suemp inner join cnune
//                    on suempuneg = cnuneuneg inner join cncco
//                    on suempccos = cnccoccos
//                  where suempnemp like '%$user%'";

        $query = "select 
                     inartcart as cart,
                     inartdesc as dart
                  from inart
                  where inartcart like '%$user%'";
        $user = DB::connection("informix")->select($query);
        return $user;
    }

    public function transfer(Request $request){
        $request->validate([
            "orig" => "required",
            "dest" => "required",
            "actv" => "required"
        ]);
        $execute = new Transfer($request->orig, $request->dest, $request->actv);
        $execute->setGlosa($request->glsa);
        $execute->execute();
    }

    public function transferCustom(Request $request){
        $request->validate([
            "orig" => "required",
            "dest" => "required",
            "actv" => "required",
            "tcos" => "required",
            "tung" => "required"
        ]);

        $ccos = json_decode($request->tcos);
        $uneg = json_decode($request->tung);

        $execute = new Transfer($request->orig, $request->dest, $request->actv);
        $execute->setData($uneg, $ccos);
        $execute->setGlosa($request->glsa);
        $execute->execute();
    }

}
