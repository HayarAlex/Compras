<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Liffe\Compras\app\Core\Reports\ActiveReport;
use Liffe\Compras\app\Core\Reports\AssignmentReport;
use Liffe\Compras\app\Core\Reports\BranchReport;
use Liffe\Compras\app\Core\Reports\CostCenterReport;
use Liffe\Compras\app\Core\Reports\GeneralReport;
use Liffe\Compras\App\Http\Exports\ActiveExport;
use Liffe\Compras\App\Http\Exports\AssignmentExport;
use Liffe\Compras\App\Http\Exports\BranchExport;
use Liffe\Compras\App\Http\Exports\CostCenterExport;
use Liffe\Compras\App\Http\Exports\StateExport;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class ReportSaiController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('compras::reports.index');
    }

    public function showCostCenter(){
        return view('compras::reports.costCenter');
    }
    public function showBranch(){
        return view('compras::reports.branch');
    }
    public function showActive(){
        return view('compras::reports.active');
    }
    public function showAssignment(){
        return view('compras::reports.assignment');
    }
    public function showGeneral(){
        return view('compras::reports.general');
    }

    public function costCenter(Request $request){
        //TODO
        // x cost center
        // all cost center

        $params = null;
        if($request->ccos){
            $salida = json_decode($request->ccos);
            $params = $salida->corr;
        }


        $query = (new CostCenterReport($params))->execute();
//        return Excel::download(new Cost, 'invoices.xlsx');
        return Excel::download(new CostCenterExport($query), date('YmdHis').'_CentrosCosto.xlsx');
    }

    public function barnch(Request $request){
        //TODO
        // x unit
        // all unit
        $params = null;
        if($request->uneg){
            $salida = json_decode($request->uneg);
            $params = $salida->encd;
        }


        $query = (new BranchReport($params))->execute();
        return Excel::download(new BranchExport($query), date('YmdHis').'_Regional.xlsx');
    }

    public function active(Request $request){
        //TODO
        // x revaluo
        // x sin revaluo
        $params = null;
        if($request->ccos){
            $salida = json_decode($request->ccos);
            $params = $salida->corr;
        }


        $query = new ActiveReport($params);
//        return Excel::download(new Cost, 'invoices.xlsx');
        return Excel::download(new ActiveExport($query->revaluo(), $query->noRevaluo()), date('YmdHis').'_Revaluo.xlsx');
    }

    public function assignment(Request $request){
        //TODO
        // x responsable
        // x unit - x all
        $params = null;
        $user = "";
        if($request->cemp){
            $salida = json_decode($request->cemp);
            $params = $salida->cemp;
            $user = $salida->desc;
        }

        $query = (new AssignmentReport($params))->execute();
        return Excel::download(new AssignmentExport($query, $user), date('YmdHis').'_Asignacion.xlsx');
    }

    public function general(Request $request){
        //TODO
        // x Rango de fechas

        $request->validate([
            "dint" => "required",
            "dend" => "required",
        ]);

        $response = null;
        $params = $request->all();

        $query = (new GeneralReport($params))->execute();
        return Excel::download(new StateExport($query), date('YmdHis').'_EstadoActivo.xlsx');
    }

}
