<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Liffe\Compras\App\Models\Local\Transfer;
use Milon\Barcode\DNS2D;
use PDF;
use Yajra\DataTables\Facades\DataTables;

class ReportTransferController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function generateCode($master){
        $code   = "{$master->corr}|{$master->sres}|{$master->tres}";
        return DNS2D::getBarcodePNG($code, "QRCODE");
    }

    public function listTransfer($source, $target){
        $list = Transfer::alias()
            ->where("aftrmscrs", $source)
            ->where("aftrmtcrs", $target)
            ->orderby("aftrmcorr", "DESC")
            ->get();
        return DataTables::of($list)->toJson();
    }

    public function actaTransfer($id){
        ini_set('max_execution_time', 120);

        $master = Transfer::alias()->find($id);
        PDF::SetTitle('Acta Transferencia');

        $this->getHeader($master);
        $this->getFooter();

        $this->notaBody($master);

        $name = "acta_transferencia_nro_{$master->corr}";
        PDF::Output($name);
    }

    private function getLogo(){
        return K_PATH_IMAGES.'/logopdf.png';
    }

    private function getHeader($master){

        PDF::setHeaderCallback(function($pdf) use ($master){

            $qrcode = $this->generateCode($master);
            $pdf->SetFont('courier', null, 8);

            $style = array(
                'border' => 2,
                'vpadding' => 'auto',
                'hpadding' => 'auto',
                'fgcolor' => array(0,0,0),
                'bgcolor' => false,
                'module_width' => 1,
                'module_height' => 1
            );

            $logo = $this->getLogo();

            $tbl = <<<EOD
            <table border="0">
                <tr>
                    <td width="20%">
                        <table>
                            <tr>
                                <td>
                                    <img src="{$logo}" width="60" height="60">
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="60%">
                        <table border="0" align="center">
                            <!--<tr><td></td></tr>-->
                            <tr><td><b style="font-size: 13px">TRASPASO DE ACTIVOS</b></td></tr>
                            <tr><td></td></tr>
                            <tr><th><p style="font-size: 10px">FECHA DE TRASPASO:  {$master->fcrd}</p></th></tr>
                            <tr><th><p style="font-size: 10px">NRO. DE TRASPASO: {$master->encd}</p></th></tr>
                        </table>
                    </td>
                    <td width="20%">
                        <table border="0" align="right">
                        <tr>
                            <td>
                            <img style="width: 50px; height: 50px; text-align: center" src="@{$qrcode}" alt="barcode"   />
                            </td>
                        </tr>
                        <tr><td>AF-ACT-TRSP</td></tr>
                    </table>
                    </td>
                </tr>
            </table>
            <table border="0.5"></table>
EOD;
            $pdf->writeHTML($tbl, true, false, true, false, '');
        });
    }

    private function getFooter(){
        PDF::setFooterCallback(function($pdf) {
            $pagination = $pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages();
            $printdate = date('d-m-Y H:i:s');
            $pdf->SetFont('courier', null, 8);
            $footer = <<<EOD
                <table border="0.5"></table>
                <br style="margin-top: 10px">
                <table border="0" style="margin-top: 5px">
                    <tr>
                        <td align="left">Pag. {$pagination}</td>
                        <td align="center"></td>
                        <td align="right">{$printdate}</td>
                    </tr>
                </table>
EOD;

            $pdf->writeHTML($footer, true, false, false, false, '');
        });
    }

    private function notaBody($master){
        PDF::SetMargins(15, 34, 15);
//        PDF::SetAutoPageBreak(TRUE, 40);
        PDF::SetHeaderMargin(8);
        PDF::SetFooterMargin(8);

        PDF::AddPage();
        PDF::SetFont('courier', '', 8);

        $isource = <<<EOD
            <table border="0" cellpadding="1">
                <tbody>
                    <tr>
                        <td class="th_line" colspan="3" align="center">
                            ORIGEN
                        </td>
                    </tr>
                    <tr>
                        <td width="32%">RESPONSABLE</td>
                        <td width="3%">:</td>
                        <td width="65%">{$master->scrs} {$master->sres}</td>
                    </tr>
                    <tr>
                        <td width="32%">CARGO</td>
                        <td width="3%">:</td>
                        <td width="65%">{$master->scar}</td>
                    </tr>
                    <tr>
                        <td width="32%">UNIDAD NEGOCIO</td>
                        <td width="3%">:</td>
                        <td width="65%">{$master->snun} {$master->sung}</td>
                    </tr>
                    <tr>
                        <td width="32%">CENTRO COSTO</td>
                        <td width="3%">:</td>
                        <td width="65%">{$master->snct} {$master->scct}</td>
                    </tr>
                </tbody>
            </table>
EOD;

        $itarget = <<<EOD
            <table border="0" cellpadding="1">
                <tbody>
                    <tr>
                        <th class="th_line" colspan="3" align="center">
                            DESTINO
                        </th>
                    </tr>
                    <tr>
                        <th width="32%">RESPONSABLE</th>
                        <td width="3%">:</td>
                        <td width="65%">{$master->tcrs} {$master->tres}</td>
                    </tr>
                    <tr>
                        <td width="32%">CARGO</td>
                        <td width="3%">:</td>
                        <td width="65%">{$master->tcar}</td>
                    </tr>
                    <tr>
                        <td width="32%">UNIDAD NEGOCIO</td>
                        <td width="3%">:</td>
                        <td width="65%">{$master->tnun} {$master->tung}</td>
                    </tr>
                    <tr>
                        <td width="32%">CENTRO COSTO</td>
                        <td width="3%">:</td>
                        <td width="65%">{$master->tnct} {$master->tcct}</td>
                    </tr>
                </tbody>
            </table>
EOD;

        $first = <<<EOD
            <style>
                .th_line{
                    font-weight: bolder;
                    border-bottom: 1px solid #ddd;
                }
            </style>
            <table border="0" cellpadding="1">
                <tbody>
                    <tr>
                        <td width="50%">
                            {$isource}
                        </td>
                        <td width="50%">
                            {$itarget}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table border="0" cellpadding="1">
                                <tr>
                                    <td width="16%">GLOSA</td>
                                    <td width="2%">:</td>
                                    <td width="82%">{$master->glsa}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
EOD;

        $mtransfer = "";
        $qDetail = "select
                    aftrdctrm as ctrm,
                    aftrdencd as encd,
                    aftrddesc as desc,
                    aftrdcstd as cstd,
                    aftrdnstd as nstd,
                    CAST (aftrdcont AS INTEGER) as cont
                  from aftrd
                  where aftrdctrm = $master->corr
                  order by cont";
//        $tdetail = TransferDetail::alias()
//            ->where("aftrdctrm", $master->corr)
////            ->orderBy("aftrdcont", "ASC")
//            ->get();

        $tdetail = DB::select($qDetail);

        foreach ($tdetail as $item){
            $mtransfer .= <<<EOD
                    <tr>
                        <td align="right" width="5%">{$item->cont}</td>
                        <td align="center" width="15%">{$item->encd}</td>
                        <td width="65%">{$item->desc}</td>
                        <td align="center" width="15%">{$item->nstd}</td>
                    </tr>
EOD;
        }

        $noteItem = <<<EOD
            <style>
                .numeric-td{
                    font-size: 6px;
                    vertical-align: text-top;
                    text-align: right;
                }
                th{
                    font-weight: bolder;
                    background-color: silver;
                    color: white;
                }
                .td-no-margin{
                    border-right: 0.5px white;
                    border-bottom: 0.5px white;
                }
                .td-no-hidden{
                    border: 0.5px white;
                }
            </style>

            <table border="0.05" cellpadding="1">
                <tbody>
                    <tr>
                        <th align="center" width="5%">No</th>
                        <th align="center" width="15%">CODIGO</th>
                        <th align="center" width="65%">DESCRIPCIÓN</th>
                        <th align="center" width="15%">ESTADO</th>
                    </tr>

                    {$mtransfer}
                </tbody>
            </table>
EOD;

        $noteObs = <<<EOD
            <style>
                .th_line{
                    font-weight: bolder;
                    border-bottom: 1px solid #ddd;
                }
            </style>
            <table border="0" cellpadding="1">
                <tbody>
                    <tr>
                        <th class="th_line" colspan="2" align="left">OBSERVACIONES</th>
                    </tr>
                    <tr>
                        <td width="2%"></td>
                        <td width="96%"></td>
                    </tr>
                </tbody>
            </table>
            <br><br><br>
EOD;

        $noteInstructive = <<<EOD
            <style>
                td{
                    text-align: justify;
                    text-justify: inter-word;
                    margin: 3px;
                }
            </style>
            <table border="0.05" cellpadding="1">
                <tbody>
                    <tr>
                        <td width="100%">
                            <table border="0" cellpadding="1">
                                <tr><td colspan="3"></td></tr>
                                <tr>
                                    <td width="3%"><b>1.</b></td>
                                    <td width="95%">
                                    La asignación de Activos al custodio final para su uso, resguardo y cuidado estará determinado por la unidad solicitante, si no existiese un custodio especifico asignado, el custodio será el Gerente, jefe o representante de la unidad solicitante hasta su posterior designación a un custodio final.
                                    </td>
                                    <td width="2%"></td>
                                </tr>
                                <tr>
                                    <td width="3%"><b>2.</b></td>
                                    <td>
                                    A la aceptacion de este documento el nuevo responsable asume el custodio del activo para su uso, resguardo y cuidado.
                                    </td>
                                    <td width="2%"></td>
                                </tr>

                                <tr><td colspan="3"></td></tr>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
EOD;

        $signed = <<<EOD
                <style>
                    th{
                        font-weight: bolder;
                        border-bottom: 1px solid #808080;
                    }
                </style>
                <br><br><br><br><br><br><br><br>
                <table border="0" cellpadding="3">
                    <tr>
                        <td width="50%">
                            <table>
                                <tr><th></th></tr>
                                <tr><td style="text-align: center">RESPONSABLE ACTIVOS FIJOS</td></tr>
                            </table>
                        </td>
                        <td width="50%">
                            <table>
                                <tr><th></th></tr>
                                <tr><td style="text-align: center">RESPONSABLE ASIGNADO DE ACTIVOS</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
EOD;

        PDF::writeHTML($first, true, false, true, false, '');
        PDF::writeHTML($noteItem, true, false, true, false, '');
        PDF::writeHTML($noteObs, true, false, true, false, '');
        PDF::writeHTML($noteInstructive, true, false, true, false, '');

        PDF::SetFont('courier', '', 7);
        PDF::writeHTML($signed, true, false, true, false, '');
    }

}
