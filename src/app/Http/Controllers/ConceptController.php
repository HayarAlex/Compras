<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Liffe\Compras\App\Models\Local\Asignated;
use Liffe\Compras\App\Models\Local\Concept;
use Liffe\Compras\App\Models\Local\Revalue;
use Liffe\Compras\App\Models\Local\Store;
use Liffe\Compras\App\Models\Sai\iAgenda;
use Liffe\Compras\App\Models\Sai\iClass;
use Liffe\Compras\App\Models\Sai\iConcept;
use Liffe\Compras\App\Models\Sai\iCostCenter;
use Liffe\Compras\App\Models\Sai\iType;
use Liffe\Compras\App\Models\Sai\iUsers;
use Yajra\DataTables\Facades\DataTables;

class ConceptController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listProperty(Request $request)
    {
        $search = $request->srch;
        return Concept::concept(Concept::CONC_PROP, $search);
    }

    public function listTipeActive(Request $request)
    {
        $search = $request->srch;
        return Concept::concept(Concept::CONC_TACT, $search);
    }

    public function listRegional(Request $request)
    {
        $search = $request->srch;
        return Concept::concept(Concept::CONC_REGN, $search);
    }


    public function listActives(Request $request)
    {
        $search = $request->srch;
        return Concept::concept(Concept::CONC_AFIJ, $search);
    }

    public function listReqs(Request $request)
    {
        $search = $request->srch;
        return Concept::concept(Concept::CONC_TREQ, $search);
    }

    public function listImpuesto(Request $request)
    {
        $search = $request->srch;
        return Concept::concept(Concept::CONC_TIMP, $search);
    }

    public function listMoneda(Request $request)
    {
        $search = $request->srch;
        return Concept::concept(Concept::CONC_TMON, $search);
    }

    public function listStates(Request $request)
    {
        $search = $request->srch;
        return iConcept::concept(iConcept::CONC_STTE, $search);
    }

    public function listTypes(Request $request)
    {
        $search = $request->srch;
        return iType::combo();
    }

    public function listGroup(Request $request)
    {
        $type = $request->ctpo;
        return iClass::groups($type);
    }

    public function listSubGroup(Request $request)
    {
        $type = $request->ctpo;
        $grup = $request->cgru;
        return iClass::subGroups($type, $grup);
    }

    public function listProviders(Request $request)
    {
        $search = $request->srch;
        return iAgenda::providers($search);
    }

    public function listUsers(Request $request){
        $search = $request->srch;
        return iUsers::actives($search);
    }

    public function listStores(Request $request){
        $search = $request->srch;
        return Store::actives($search);
    }

    public function listHitory($id){
        $list = Asignated::alias()
            ->where('afaxucact', $id)
            ->orderBy('afaxufcrd', 'DESC')
            ->get();
        return DataTables::make($list)->toJson();
    }

    //----- file config
    public function dtTypes(Request $request)
    {
        $list = iType::list();
        return DataTables::make($list)->toJson();
    }

    public function dtRevalues(Request $request)
    {
        $list = Revalue::list();
        return DataTables::make($list)->toJson();
    }

    public function dtDocs()
    {
        $list = Concept::concept(Concept::CONC_TDOC, "");
        return DataTables::make($list)->toJson();
    }

    public function dtUnits(){
        $list = Concept::concept(Concept::CONC_REGN, "");
        return DataTables::make($list)->toJson();
    }


    ///----------------reports concepts
    public function listCostCenter(Request $request){
        $search = $request->srch;
        return iCostCenter::combo($search);
    }

    ///---- combs
    public function comboRegional(){
        return Concept::combo(Concept::CONC_REGN);
    }

}
