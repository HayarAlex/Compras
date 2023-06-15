<?php

/*****************************************
 *   RUTAS DEL MODULO DE ACTIVOS FIJOS   *
 *****************************************/

use Liffe\Compras\App\Models\Local\Asignated;

Route::prefix('active')->group(function () {
    Route::get('/', 'ActiveController@index');
    Route::get('register', 'ActiveController@register');
    Route::post('/', 'ActiveController@store');
    Route::post('info-buy/{id}', 'ActiveController@buyInfo');
    Route::get('edit/{id}', 'ActiveController@show');
    Route::delete('remove/{id}', 'ActiveController@remove');

    Route::post('responsable/{id}', 'ActiveController@activeResponsable');
    Route::post('store/{id}', 'ActiveController@activeStore');

    Route::get('gallery/{act}/{docs}', 'GalleryController@index');
    Route::get('gallery-load/{act}/{docs}', 'GalleryController@load');
    Route::get('gallery/list/{act}/{doc}', 'GalleryController@gallery');
    Route::delete('gallery/remove/{id}', 'GalleryController@remove');

    Route::get("get-info/{id}", "ActiveController@getInfo");
    Route::get("get-detail/{id}", "ActiveController@getDetail");

    Route::post("put-info", "ActiveController@mupdate");

});

Route::prefix('state')->group(function () {
    Route::get('default', 'StatesController@listDefault');
    Route::get('transitory', 'StatesController@listTransitory');
    Route::get('custodia', 'StatesController@listCustodia');
    Route::get('activo', 'StatesController@listActive');
});

Route::prefix('concept')->group(function () {
    Route::get('property', 'ConceptController@listProperty');
    Route::get('tipe-active', 'ConceptController@listTipeActive');
    Route::get('regional', 'ConceptController@listRegional');
    Route::get('active', 'ConceptController@listActives');
    Route::get('requires', 'ConceptController@listReqs');

    Route::get('state', 'ConceptController@listStates');

    Route::get('moneda', 'ConceptController@listMoneda');
    Route::get('impuesto', 'ConceptController@listImpuesto');

    Route::get('type', 'ConceptController@listTypes');
    Route::get('group', 'ConceptController@listGroup');
    Route::get('sub-group', 'ConceptController@listSubGroup');
    Route::get('providers', 'ConceptController@listProviders');
    Route::get('users', 'ConceptController@listUsers');
    Route::get('store', 'ConceptController@listStores');

    Route::get('history/{id}', 'ConceptController@listHitory');

    //--- tables
    Route::get('dttype', 'ConceptController@dtTypes');
    Route::get('dtrevalue', 'ConceptController@dtRevalues');

    //--- docs
    Route::get('dtdocs', 'ConceptController@dtDocs');
    Route::get('dtRegionals', 'ConceptController@dtUnits');

    //----- sections reports
    Route::get('cost-center', 'ConceptController@listCostCenter');


    ///-----combos
    Route::get('comb-regional', 'ConceptController@comboRegional');

});

Route::prefix('store')->group(function () {
    Route::get('', 'StoreController@index');
    Route::post('', 'StoreController@store');
    Route::put('', 'StoreController@refresh');
    Route::delete('{id}', 'StoreController@remove');

    Route::get('list', 'StoreController@lists');
});
Route::prefix('tender')->group(function () {
    Route::get('', 'StoreController@indexl');
    Route::post('lipost', 'StoreController@listore');
    Route::put('liput', 'StoreController@liupdate');
    Route::put('{id}', 'StoreController@confirmlic');

    Route::get('listt', 'StoreController@lilists');
    Route::get("showl/{id}", "StoreController@showl");
    Route::get("infol/{id}", "StoreController@infol");
    Route::get('list/{id}', 'StoreController@liclists');
    Route::get("{id}", "StoreController@licshow");
    Route::post('art', 'StoreController@artstore');
    Route::get('list-order/{id}', 'StoreController@listOrder');
    Route::put('', 'StoreController@artrefresh');
});
Route::prefix('admtender')->group(function () {
    Route::get('', 'StoreController@indexal');
    Route::get("showla/{id}", "StoreController@showla");
    Route::get("/dt/lici/{id}", "StoreController@admlici");
    Route::get("{id}", "StoreController@licshowa");
    Route::put('', 'StoreController@admartrefresh');
    Route::get('list/{id}', 'StoreController@admliclists');
    Route::put('{id}', 'StoreController@confirmlica');    
});
Route::prefix('diarymed')->group(function () {
    Route::get('', 'StoreController@indexmed');
    Route::post('diarypost', 'StoreController@diarystore');
    Route::put('diaryupdate', 'StoreController@refreshmed');
});
Route::prefix('diaryconfig')->group(function () {
    Route::get('/', 'StoreController@indexmedcon');
    Route::get('users', 'StoreController@indexusdi');
    Route::get('users-units/{id}', 'StoreController@userUnitdi');
    Route::get('units-users/{id}', 'StoreController@unitUserdi');
    Route::post('sync-units', 'StoreController@syncUnitsdi');
});
Route::prefix('diarylist')->group(function () {
    Route::get('', 'StoreController@indexmedlist');
    Route::get("showl/{id}", "StoreController@showlistmed");
    Route::get('med-units/{id}', 'StoreController@medUnit');
});
Route::prefix('almorder')->group(function () {
    Route::get('', 'StoreController@indexalmped');
    Route::get('list/{id}', 'StoreController@palists');
    Route::get("showformad", "StoreController@showformad");
    Route::get("showformlo", "StoreController@showformlo");
    Route::get("showformin", "StoreController@showformin");
    Route::get("showformpri", "StoreController@showformpri");
    Route::post('alpost', 'StoreController@alstore');

    Route::get("detad/{id}", "StoreController@alshow");
    Route::get("lot/{id}", "StoreController@lotshow");
    Route::get("ins/{id}", "StoreController@insshow");
    Route::get("pri/{id}", "StoreController@prishow");
    Route::post('aldetpost/{id}', 'StoreController@aldetstore');
    Route::get("peddet/{id}", "StoreController@detlist");
    Route::get("peddetpri/{id}", "StoreController@detprilist");
    Route::put('', 'StoreController@detrefresh');
    Route::put('confirmpa/{id}', 'StoreController@confirmpeda');
    Route::put('deleteped/{id}', 'StoreController@deletepe');
    Route::post('artdet', 'StoreController@artdetstore');
    

    Route::put('liput', 'StoreController@liupdate');

    Route::get('listt', 'StoreController@lilists');
    Route::get("showl/{id}", "StoreController@showl");
    Route::get("infol/{id}", "StoreController@infol");
    
    
    Route::post('art', 'StoreController@artstore');
    Route::get('list-order/{id}', 'StoreController@listOrder');
});
Route::prefix('almadmin')->group(function () {
    Route::get('', 'StoreController@indexalmadm');
    Route::get('list/{id}', 'StoreController@admlists');
    Route::get("showformad", "StoreController@admformad");
    Route::get("showformlo", "StoreController@admformlo");
    Route::get("showformin", "StoreController@admformin");
    Route::get("showformpri", "StoreController@admformpri");
    Route::get("showformrep", "StoreController@admformrep");

    Route::post('repost', 'StoreController@reportedata');
    Route::get('show/{type}/{init}/{end}', 'StoreController@showrep');
    Route::get('dt-show/{type}/{init}/{end}', 'StoreController@dtreport');

    Route::get("detad/{id}", "StoreController@aladm");
    Route::get("lot/{id}", "StoreController@lotadm");
    Route::get("ins/{id}", "StoreController@insadm");
    Route::get("pri/{id}", "StoreController@priadm");

    Route::post('aldetpost/{id}', 'StoreController@aldetstore');
    Route::get("peddet/{id}", "StoreController@detlist");
    Route::get("peddetpri/{id}", "StoreController@detprilist");
    Route::put('acfe', 'StoreController@fecref');
    Route::put('', 'StoreController@statedet');
    Route::put('confirmpa/{id}', 'StoreController@conpedal');
    Route::put('acfe/{id}', 'StoreController@deletepe');
    Route::post('artdet', 'StoreController@artdetstore');
    

    Route::put('liput', 'StoreController@liupdate');

    Route::get('listt', 'StoreController@lilists');
    Route::get("showl/{id}", "StoreController@showl");
    Route::get("infol/{id}", "StoreController@infol");
    
    
    Route::post('art', 'StoreController@artstore');
    Route::get('list-order/{id}', 'StoreController@listOrder');
});
Route::prefix('order')->group(function () {
    Route::get('', 'StoreController@indexo');
    Route::get("showo/{id}", "StoreController@showo");
    Route::get("infoo/{id}", "StoreController@infoo");
    Route::post('pepost', 'StoreController@pestore');
    Route::get('list/{id}', 'StoreController@pedlists');
    Route::get("{id}", "StoreController@pedshow");
    Route::post('art', 'StoreController@artstoreo');
    Route::get('list-order/{id}', 'StoreController@pelistOrder');
    Route::put('', 'StoreController@peartrefresh');
    Route::put('{id}', 'StoreController@confirmped');
    Route::delete('{id}', 'StoreController@removeped');

    Route::post('op', 'StoreController@storep');
    Route::get('listp', 'StoreController@listas');
});
Route::get('unitspe', 'StoreController@units');
Route::get('unitsli', 'StoreController@unitslic');
Route::get('unitsdia', 'StoreController@unitsdia');
Route::prefix('orderconfig')->group(function () {
    Route::get('/', 'StoreController@indexco');
    Route::get('users', 'StoreController@indexus');
    Route::get('users-units/{id}', 'StoreController@userUnit');
    Route::get('units-users/{id}', 'StoreController@unitUser');
    Route::post('sync-units', 'StoreController@syncUnits');
});
Route::prefix('tenderconfig')->group(function () {
    Route::get('/', 'StoreController@indexcoli');
    Route::get('users', 'StoreController@indexusli');
    Route::get('users-units/{id}', 'StoreController@userUnitli');
    Route::get('units-users/{id}', 'StoreController@unitUserli');
    Route::post('sync-units', 'StoreController@syncUnitsli');
});
Route::prefix('pedido')->group(function () {
    Route::get('', 'StoreController@indexo');
    Route::post('opp', 'StoreController@storepp');
    Route::put('', 'StoreController@refreshp');
    Route::delete('{id}', 'StoreController@removep');

    Route::get('listp', 'StoreController@listas');
});
Route::prefix('listorder')->group(function () {
    Route::get('', 'StoreController@indexol');
    Route::get("showlp/{id}", "StoreController@showlp");
    Route::get('list/{id}', 'StoreController@apedlists');
    Route::get("{id}", "StoreController@pedshowa");
    Route::put('', 'StoreController@pedartrefresh');
    Route::put('{id}', 'StoreController@confirmpeca'); 

    Route::post('op', 'StoreController@storep');

    Route::get('listp', 'StoreController@listas');
});
Route::prefix('ordert')->group(function () {
    Route::get('', 'StoreController@indexo');
    Route::post('opt', 'StoreController@storet');
    Route::put('', 'StoreController@refresht');
    Route::delete('{id}', 'StoreController@removet');

    Route::get('listt', 'StoreController@listast');
});

Route::prefix('report')->group(function () {
    Route::get('acta-entrega/{id}', 'ReportController@actaEntrega');
    Route::get('generate-code/{id}', 'ReportController@generateCode');
    Route::get('acta-asignacion/{id}', 'ReportAsignController@actaAsignacion');

    Route::get('list-transfer/{source}/{target}', 'ReportTransferController@listTransfer');
    Route::get('acta-transfer/{code}', 'ReportTransferController@actaTransfer');
});

Route::prefix('config')->group(function () {
    Route::get('/', 'ConfigController@index');
    Route::get('types', 'ConfigController@types');

    Route::post('type', 'ConfigController@storeType');
    Route::delete('type', 'ConfigController@removeType');

    //--- docs
    Route::get('docs', 'DocsController@index');

    Route::post('docs', 'DocsController@store');
    Route::put('docs', 'DocsController@refresh');
    Route::delete('docs/{id}', 'DocsController@remove');
    Route::get('docs/list', 'DocsController@lists');
});


//--------- SECTION REPORTS
Route::prefix('reports')->group(function () {
    Route::get("/", "ReportSaiController@index");
    Route::get("cost-center", "ReportSaiController@showCostCenter");
    Route::get("branch", "ReportSaiController@showBranch");
    Route::get("active", "ReportSaiController@showActive");
    Route::get("assignment", "ReportSaiController@showAssignment");
    Route::get("general", "ReportSaiController@showGeneral");

    Route::post("cost-center", "ReportSaiController@costCenter");
    Route::post("branch", "ReportSaiController@barnch");
    Route::post("active", "ReportSaiController@active");
    Route::post("assignment", "ReportSaiController@assignment");
    Route::post("general", "ReportSaiController@general");
});


//=====================================================================================================
//=====================================================================================================
//=====================================================================================================
Route::prefix('kardex')->group(function () {
   Route::get("main", "KardexController@index");
   Route::get("list", "KardexController@getAll");
   Route::get("show/{id}", "KardexController@show");
   Route::get("inf/{id}", "KardexController@getActive");
   Route::put("{id}", "KardexController@refresh");

   Route::get("search", "KardexController@showSearch");
   Route::get("search/{id}", "KardexController@shower");
   Route::post("search", "KardexController@search");
});

Route::prefix('transfer')->group(function () {
    Route::get("main", "TransferController@index");
    Route::get("main_edit", "TransferController@indexEdit");
    Route::get("responsable/{id}", "TransferController@getResponsable");
    Route::get("actives/{id}", "TransferController@listActives");

    Route::get("list/med/{id}", "TransferController@listMedag");
    Route::get("list/zonmed/{id}", "TransferController@listZonamed");
    Route::get("list/especialidadupdate/{id}", "TransferController@listEspeup");
    Route::get("list/zonaupdate/{id}", "TransferController@listZonup");
    Route::get("list/espe", "TransferController@listEspecialidades");
    Route::get("list/zona/{id}", "TransferController@listZonas");
    Route::get("list/customsrv", "TransferController@listCustom");
    Route::get("list/users", "TransferController@listResponsables");
    Route::get("list/arts", "TransferController@listArticulos");
    Route::get("list/inst", "TransferController@listInstitutos");
    Route::get("list/lote", "TransferController@listLotes");
    Route::get("list/prod/{id}", "TransferController@listProd");
    Route::get("list/orden/{id}", "TransferController@listOrden");
    Route::get("list/rece/{id}", "TransferController@listRece");
    Route::get("list/provee/{id}", "TransferController@listProvee");
    Route::get("list/nomprod/{ord}/{mat}", "TransferController@listNomprod");
    Route::get("list/dataitem/{ord}", "TransferController@listDataitem");
    Route::get("list/codenew/{code}/{limi}", "TransferController@listCodenew");
    Route::get("list/dispo/{id}", "TransferController@showDispo");
    Route::get("list/dispoin/{id}", "TransferController@showDispoin");
    Route::get("list/dispopri/{id}", "TransferController@showDispopri");
    Route::get("list/recelot/{id}", "TransferController@listRecelo");
    Route::get("list/artsp", "TransferController@listArti");
    Route::post("/", "TransferController@transfer");
    Route::post("custom", "TransferController@transferCustom");
});

Route::prefix('transfer-area')->group(function () {
    Route::get("main", "TransferAreaController@index");

    Route::get("comb-area", "TransferAreaController@combAreas");
    Route::get("responsable/{id}", "TransferAreaController@getResponsable");
    Route::get("actives/{id}", "TransferAreaController@listActives");
//
    Route::post("/", "TransferAreaController@transfer");
});

/* *
 * NEW FEATURES
 * */
Route::prefix('area')->group(function () {
    Route::get("main", "AreaController@index");
    Route::get("register", "AreaController@register");
    Route::get("show/{id}", "AreaController@show");

    Route::get("showp/{id}", "AreaController@showp");

    Route::post('/', 'AreaController@store');
    Route::put('/', 'AreaController@refresh');
    Route::delete('{id}', 'AreaController@remove');

    Route::get('list/{id}', 'AreaController@lists');

    Route::get('listp/{id}', 'AreaController@listsp');

    Route::get('list', 'AreaController@listsAll');
    Route::get("info/{id}", "AreaController@info");

    Route::get("infop/{id}", "AreaController@infop");
});

Route::prefix('active-area')->group(function () {
    Route::get("main", "ActiveAreaController@index");
    Route::get("{id}", "ActiveAreaController@show");
    Route::post("/", "ActiveAreaController@store");
    Route::delete("/", "ActiveAreaController@destroy");

    Route::get("/dt/actives", "ActiveAreaController@activeAvalaible");
    Route::get("/dt/area/{id}", "ActiveAreaController@activeArea");

    Route::get("/dt/areap/{id}", "ActiveAreaController@activeAreap");

    Route::get("mtesters", "ActiveAreaController@destroy");
});
Route::prefix('modorder')->group(function () {
    Route::get("main", "ActiveAreaController@indexp");
    Route::get("showm/{id}", "StoreController@showm");
    Route::get("/dt/areap/{id}", "StoreController@activeAreap");
    Route::get("/dt/areapd/{id}", "StoreController@activeAreapd");
    Route::get("{id}", "ActiveAreaController@showp");
    Route::post("/", "ActiveAreaController@store");
    Route::delete("/", "ActiveAreaController@destroy");
    Route::put("/change/{id}", "ActiveAreaController@changestate");

    Route::get("/dt/actives", "ActiveAreaController@activeAvalaible");
    Route::get("/dt/area/{id}", "ActiveAreaController@activeArea");

    Route::get("mtesters", "ActiveAreaController@destroy");
});
Route::prefix('liorrep')->group(function () {
    Route::get("main", "StoreController@indexliorrep");
    Route::get("showm/{id}", "StoreController@showm");
    Route::get("/dt/areap/{id}", "StoreController@activeAreap");
    Route::get("/dt/areapd/{id}", "StoreController@activeAreapd");
    Route::get("{id}", "ActiveAreaController@showp");
    Route::post("/", "ActiveAreaController@store");
    Route::delete("/", "ActiveAreaController@destroy");
    Route::put("/change/{id}", "ActiveAreaController@changestate");

    Route::get("/dt/actives", "ActiveAreaController@activeAvalaible");
    Route::get("/dt/area/{id}", "ActiveAreaController@activeArea");

    Route::get("mtesters", "ActiveAreaController@destroy");
});
Route::get("/reload", function(){
    ini_set('max_execution_time', 120);
    $list = \Liffe\Actives\App\Models\Sai\iActive::where("afmaeresp", "<>", 120070)->get();//whereNull('afmaedscr')->get();
//    foreach ($list as $item){
//        $item->afmaeresp = 120070;
//        $item->update();
//    }
    dd($list);
});

Route::get("center-user", function(){
    $list = \Liffe\Actives\App\Models\Local\Asignated::where("afaxucrsp", "<>", 1)->get();
    foreach ($list as $item){

        $query = "select suempccos as ccos
                  from suemp
                  where suempcemp = $item->afaxucrsp";

        $list = DB::connection("informix")->select($query);

        if($list){
            $item->afaxuccos = $list[0]->ccos;
            $item->save();
        }

    }
    dd("Close !!!");
});

Route::get("test-state", function(){

//    $list = Asignated::all();
//    dd($list->toArray());

//    $code = "1000";
//
//    $respons = new Asignated;
//    $respons->centroCosto($code);
//    $respons->afaxucact = $code;
//    $respons->afaxucrsp = $code;
//    $respons->afaxunrsp = $code;
//    $respons->afaxufasg = date("Y-m-d");
//    $respons->afaxuactv = 1;
//    $respons->save();
});

Route::prefix('shopreg')->group(function () {
    Route::get('', 'StoreController@indexshop')->name('compras.registro');
    Route::get("detaitem/{id}", "StoreController@descprim");
    Route::post('shoppost', 'StoreController@storeshop');
});

Route::prefix('shopbone')->group(function () {
    Route::get('', 'StoreController@indexshopbo')->name('compras.bandejapedidos');
    Route::get('list', 'StoreController@shoplists');
    Route::get("asig/{id}", "StoreController@asigdetshop");
    Route::get("newprove/{id}", "StoreController@newproshop");
    Route::post('shdetpost/{id}', 'StoreController@shdetstore');
    Route::get("provdet/{id}", "StoreController@detprovlist");
    Route::put('confasig', 'StoreController@confirasig');
    Route::put('sendpro/{id}', 'StoreController@statesend');
});

Route::prefix('shopbtwo')->group(function () {
    Route::get('', 'StoreController@indexshopbt');
    Route::get('list', 'StoreController@shoplistscon');
    Route::get('listtipo/{id}', 'StoreController@shoplisttipo');
    Route::get('listtipoa/{id}', 'StoreController@shoplisttipoaprov');
    Route::get('listobs', 'StoreController@shoplistsobs');
    Route::get("prove/{id}", "StoreController@provdetshop");
    Route::get("proveobs/{id}", "StoreController@provdetobs");
    Route::get("newprove/{id}", "StoreController@newproshop");
    Route::post('shdetpost/{id}', 'StoreController@shdetstore');
    Route::get("provdet/{id}", "StoreController@detprovref");
    Route::get("detdoc/{id}", "StoreController@countdocs");
    Route::put('confasig', 'StoreController@confirasig');
    Route::post('register', 'StoreController@respprov');
    Route::put('', 'StoreController@detprovrefresh');
    Route::post('registerdet', 'StoreController@respprovdet');
    Route::get('listdoct/{id}', 'StoreController@listsdocstipo');
    Route::get('listdoctp/{id}/{tipo}', 'StoreController@listsdocsprovs');
    Route::put('delfilet/{id}', 'StoreController@filetipodel');
});

Route::prefix('shopbthree')->group(function () {
    Route::get('', 'StoreController@indexshopbtr');
    Route::get('list', 'StoreController@shoplistspen');
    Route::get("prove/{id}", "StoreController@revlogshop");
    Route::get('listdoc/{id}', 'StoreController@listsdocsprov');
    Route::put('register', 'StoreController@revlogi');
    Route::put('observation', 'StoreController@confirmobs');
});

Route::prefix('shopbfour')->group(function () {
    Route::get('', 'StoreController@indexcuadro')->name('compras.cuadro_comp');
    Route::get('list', 'StoreController@shoplistsrevi');
    Route::get("prove/{id}", "StoreController@cuadrocomp");
    Route::get("provdet/{id}", "StoreController@detcuadro");
    Route::get('listdoc/{id}', 'StoreController@listsdocsprov');
    Route::post('register', 'StoreController@revlogi');
});
Route::prefix('shopbfive')->group(function () {
    Route::get('', 'StoreController@indexresprov')->name('compras.asignacion_rev');
    Route::get('list', 'StoreController@slistrevprov');
    Route::get("prove/{id}", "StoreController@resprovshop");
    Route::get('show/{code}', 'StoreController@resume');
    Route::put('confasig', 'StoreController@confirareat');
    Route::put('confasigm', 'StoreController@confirarea');
    Route::get('listdoc/{id}', 'StoreController@listsdocsprov');
    Route::get('listobsa', 'StoreController@listoarea');
    Route::get("provobs/{id}", "StoreController@provobs");
    Route::put('confobs', 'StoreController@confareaobs');
    Route::put('obsrev/{id}', 'StoreController@cleanobsprov');
});
Route::prefix('shopbsix')->group(function () {
    Route::get('', 'StoreController@indexaprov')->name('compras.rev_calidad');
    Route::get('list', 'StoreController@listpenaprov');
    Route::get("prove/{id}", "StoreController@aprovshop");

    Route::get('show/{code}', 'StoreController@resume');
    Route::post('confaprov', 'StoreController@aprovarea');
    Route::get('listdoc/{id}', 'StoreController@listsdocsprov');
    Route::put('observation', 'StoreController@obsscal');
    Route::put('aproba', 'StoreController@appcal');
    Route::put('apro/{id}', 'StoreController@calaprov');
    Route::put('repro/{id}', 'StoreController@calreprov');
    Route::put('', 'StoreController@regobca');
});
Route::prefix('shopblog')->group(function () {
    Route::get('', 'StoreController@indexrevlog')->name('compras.rev_logistica');
    Route::get('list', 'StoreController@listlog');
    Route::get("info/{id}", "StoreController@logshop");
    Route::put('confirmlog', 'StoreController@conflog');
    Route::put('observation', 'StoreController@obsslog');
    Route::put('apro/{id}', 'StoreController@logaprov');
    Route::put('repro/{id}', 'StoreController@logreprov');
    Route::put('', 'StoreController@regoblo');
});
Route::prefix('shopbinv')->group(function () {
    Route::get('', 'StoreController@indexrevinv')->name('compras.rev_investigacion_des');
    Route::get('list', 'StoreController@listinv');
    Route::get("info/{id}", "StoreController@invshop");
    Route::put('confirminv', 'StoreController@confinv');
    Route::put('observation', 'StoreController@obssinv');
    Route::put('apro/{id}', 'StoreController@invaprov');
    Route::put('repro/{id}', 'StoreController@invreprov');
    Route::put('', 'StoreController@regobin');
});
Route::prefix('shopban')->group(function () {
    Route::get('', 'StoreController@indexrevsan')->name('compras.rev_reg_sanitario');
    Route::get('list', 'StoreController@listsan');
    Route::get("info/{id}", "StoreController@sanshop");
    Route::put('confirmsan', 'StoreController@confsan');
    Route::put('observation', 'StoreController@obsssan');
    Route::put('apro/{id}', 'StoreController@sanaprov');
    Route::put('repro/{id}', 'StoreController@sanreprov');
    Route::put('', 'StoreController@regobsa');
});
Route::prefix('shopbsev')->group(function () {
    Route::get('', 'StoreController@indexorden')->name('compras.ped_aprobados');
    Route::get('list', 'StoreController@listapsh');
    Route::get("pedi/{id}", "StoreController@aprovdetshop");

    Route::get('show/{code}', 'StoreController@resume');
    Route::put('confaprov', 'StoreController@aprovarea');
    Route::get('listdoc/{id}', 'StoreController@listsdocsprov');
    Route::put('observation', 'StoreController@obsscal');
});