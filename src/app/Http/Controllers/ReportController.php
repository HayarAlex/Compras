<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Liffe\Compras\App\Models\Local\Active;
use Liffe\Compras\App\Models\Sai\iActive;
use Milon\Barcode\DNS2D;
use PDF;

class ReportController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    public function generateCode($id){
        $active = Active::alias()->find($id);
        $code   = "{$active->encd}";
        $qrcode =  DNS2D::getBarcodeHTML($code, "QRCODE");
        return $qrcode;
    }

    public function actaEntrega($id)
    {
        ini_set('max_execution_time', 120);

        //--- Load Info from database
        //--- load information here
        $active = Active::alias()->find($id);

//        dd($active);

        PDF::SetTitle('Acta Recepcion : ');

        $this->getHeader($active, "EGRESO B.");
        $this->getFooter();

        $this->notaBody($active);

        $name = "acta_nro_{$active->nrod}_{$active->gest}";
        PDF::Output($name);
    }


    private function notaBody($active)
    {

        PDF::SetMargins(15, 34, 15);
//        PDF::SetAutoPageBreak(TRUE, 40);
        PDF::SetHeaderMargin(8);
        PDF::SetFooterMargin(8);

        PDF::AddPage();
        PDF::SetFont('courier', '', 8);

        //---
        $mxvalor = $active->fmon * $active->vttl;
        $impuestos =  ($mxvalor * ($active->pimp/100));
        $valoracts =  $mxvalor - $impuestos;
        if($active->cimp == 2){
            $impuestos = ($mxvalor * $active->pimp)/(100-$active->pimp);
            $valoracts = $mxvalor + $impuestos;
//            $valoracts = $mxvalor;
            $mxvalor = $mxvalor + $impuestos;

            $impuesto = number_format(round($impuestos, 2), 2);
            $valoract = number_format(round($valoracts, 2), 2);
            $mxvalor = number_format(round($mxvalor, 2), 2);

            $valoract_x = number_format(round($valoracts, 2), 2);

        }
        if($active->cimp == 1){
            $valoract = $mxvalor - $impuestos;
            $valoracts = $mxvalor;

            $impuesto = number_format(round($impuestos, 2), 2);
            $valoract = number_format(round($valoract, 2), 2);
            $mxvalor = number_format(round($mxvalor, 2), 2);

            $valoract_x = number_format(round($valoracts, 2), 2);
        }

        if($active->cimp == 3){
            $impuestos = 0;
            $valoract = $mxvalor - $impuestos;
            $valoracts = $mxvalor;

            $impuesto = number_format(round($impuestos, 2), 2);
            $valoract = number_format(round($valoract, 2), 2);
            $mxvalor = number_format(round($mxvalor, 2), 2);

            $valoract_x = number_format(round($valoracts, 2), 2);

        }


//        $impuesto = number_format(round($impuestos, 2), 2);
//        $valoract = number_format(round($valoracts, 2), 2);
//        $mxvalor = number_format(round($mxvalor, 2), 2);

//        dd($mxvalor);

        $noteInfo = <<<EOD
            <style>
                .th_line{
                    font-weight: bolder;
                    border-bottom: 1px solid #ddd;
                }
            </style>
            <table border="0" cellpadding="1">
                <thead>
                    <tr>
                        <th class="th_line" colspan="5" align="left">DOCUMENTACIÓN RESPALDATORIA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="2%"></td>
                        <th width="17%">REGIONAL</th>
                        <td width="3%"> : </td>
                        <td width="80%">{$active->nreg}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="2%"></td>
                        <th>PROVEEDOR</th>
                        <td> : </td>
                        <td>{$active->nprv}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="2%"></td>
                        <th>NRO DOCUMENTO</th>
                        <td> : </td>
                        <td>{$active->ndoc}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="2%"></td>
                        <th>TIPO DOCUMENTO</th>
                        <td> : </td>
                        <td>{$active->nimp}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="2%"></td>
                        <th>NOTA DE REMISION</th>
                        <td> : </td>
                        <td>{$active->nrms}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="2%"></td>
                        <th>COTIZACION</th>
                        <td> : </td>
                        <td>{$active->cotz}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="2%"></td>
                        <th>MONEDA</th>
                        <td> : </td>
                        <td>{$active->nmon}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="2%"></td>
                        <th>VALOR TOTAL</th>
                        <td> : </td>
                        <td>{$valoract_x}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="2%"></td>
                        <th>TIPO DE CAMBIO</th>
                        <td> : </td>
                        <td>{$active->fmon}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="2%"></td>
                        <th>ORDEN DE COMPRA</th>
                        <td> : </td>
                        <td>{$active->otrb}</td>
                        <td width="2%"></td>
                    </tr>
                </tbody>
            </table>
EOD;



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
                <thead>
                    <tr>
                        <th align="center" width="5%">No</th>
                        <th align="center" width="40%">DESCRIPCION</th>
                        <th align="center" width="10%">CODIGO</th>
                        <th align="center" width="15%">RESPONSABLE</th>
                        <th align="center" width="10%">VALOR (BS)</th>
                        <th align="center" width="20%">PARTIDA O RUBRO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td align="center" width="5%">1</td>
                        <td width="40%">{$active->desc}</td>
                        <td align="center" width="10%">{$active->encd}</td>
                        <td align="center" width="15%">{$active->nrsp}</td>
                        <td width="10%" class="numeric-td">{$valoract}</td>
                        <td align="center" width="20%">{$active->nrbr}</td>
                    </tr>
                    <tr>
                        <th width="70%" style="text-align: right">VALOR DE REGISTRO EN LIBROS</th>
                        <td width="10%" class="numeric-td">{$valoract}</td>
                        <td class="td-no-margin" width="20%" rowspan="4"></td>
                    </tr>
                    <tr>
                        <th width="70%" style="text-align: right">VALOR IMPOSITIVO</th>
                        <td width="10%" class="numeric-td">{$impuesto}</td>
                    </tr>
                    <tr>
                        <th width="70%" style="text-align: right">VALOR TOTAL DE LA COMPRA</th>
                        <td width="10%" class="numeric-td">{$mxvalor}</td>
                    </tr>
                    <tr>
                        <td class="td-no-hidden" colspan="2"></td>
                    </tr>
                </tbody>
            </table>
EOD;
        //---

        $noteObs = <<<EOD
            <style>
                .th_line{
                    font-weight: bolder;
                    border-bottom: 1px solid #ddd;
                }
            </style>
            <table border="0" cellpadding="1">
                <thead>
                    <tr>
                        <th class="th_line" colspan="2" align="left">OBSERVACIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="2%"></td>
                        <td width="96%">{$active->obsr}</td>
                    </tr>
                </tbody>
            </table>
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
                                    <td width="95%">Todo Activo adquirido por la empresa tiene que ser registrado por el Responsable de Activos Fijos para lo cual la unidad solicitante o el departamento de compras es responsables en brindar la información completa para el registro.
                                    </td>
                                    <td width="2%"></td>
                                </tr>
                                <tr>
                                    <td width="3%"><b>2.</b></td>
                                    <td>La asignación de Activos al custodio final para su uso, resguardo y cuidado estará determinado por la Unidad solicitante de la compra, si no existiese un custodio especifico asignado, el custodio será el Gerente, jefe o representante de la unidad solicitante hasta su posterior designación a un custodio final.
                                    </td>
                                    <td width="2%"></td>
                                </tr>
                                <tr>
                                    <td width="3%"><b>3.</b></td>
                                    <td>La entrega o asignación de Activos tendrá que ser coordinada de manera obligatoria con el Responsable de Activos Fijos.
                                    </td>
                                    <td width="2%"></td>
                                </tr>
                                <tr>
                                    <td width="3%"><b>4.</b></td>
                                    <td>La NO información de la compra de un Activo al Responsable de Activos Fijos es una falta el cual es perjudicial al control de los bienes que tiene Grupo Alcos.
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
                                <tr><td style="text-align: center">REPRESENTANTE Ó DEPARTAMENTO COMPRAS</td></tr>
                            </table>
                        </td>
                        <td width="50%">
                            <table>
                                <tr><th></th></tr>
                                <tr><td style="text-align: center">RESPONSABLE ACTIVOS FIJOS</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
EOD;

        PDF::writeHTML($noteInfo, true, false, true, false, '');
        PDF::writeHTML($noteItem, true, false, true, false, '');
        PDF::writeHTML($noteObs, true, false, true, false, '');
        PDF::writeHTML($noteInstructive, true, false, true, false, '');

        PDF::SetFont('courier', '', 7);
        PDF::writeHTML($signed, true, false, true, false, '');
    }

    private function getLogo(){
        return K_PATH_IMAGES.'/logopdf.png';
    }

    private function getHeader($active, $title)
    {
        PDF::setHeaderCallback(function($pdf) use ($active, $title){

            $code   = "{$active->encd}|{$active->corr}";
            $qrcode =  DNS2D::getBarcodePNG($code, "QRCODE");
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
                            <tr><td><b style="font-size: 13px">ACTA DE RECEPCIÓN DE ACTIVOS</b></td></tr>
                            <tr><td></td></tr>
                            <tr><th><p style="font-size: 10px">ACTA DE RECEPCIÓN ALCOS No. {$active->nrod}/{$active->gest}</p></th></tr>
                            <tr><th><p style="font-size: 10px">FECHA DE ADQUISICIÓN: {$active->fbuy}</p></th></tr>
                        </table>
                    </td>
                    <td width="20%">
                        <table border="0" align="right">
                        <tr>
                            <td>
                            <img style="width: 50px; height: 50px; text-align: center" src="@{$qrcode}" alt="barcode"   />
                            </td>
                        </tr>
                        <tr><td>AF-ACT-RECP</td></tr>
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

}
