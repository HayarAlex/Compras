<?php

namespace Liffe\Compras\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Liffe\Compras\App\Models\Local\Active;
use Liffe\Compras\App\Models\Local\Asignation;
use Liffe\Compras\App\Models\Sai\iActive;
use Milon\Barcode\DNS2D;
use PDF;

class ReportAsignController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function generateCode($id){
        $active = Active::alias()->find($id);
        $code   = "{$active->encd}";
        $qrcode =  DNS2D::getBarcodeHTML($code, "QRCODE");
        return $qrcode;
    }

    public function actaAsignacion($id)
    {
        ini_set('max_execution_time', 120);


        $active = Active::alias()->find($id);
        $iactive = iActive::finder($active->encd);//iActive::alias()->find($active->encd);

//        dd($iactive);

        $asignacion = Asignation::find($active->encd);
        if(!$asignacion){
            $asignacion = new Asignation;
            $asignacion->afndccact = $active->encd;
            $asignacion->save();
        }

        PDF::SetTitle('Acta Asignacion : ');

        $this->getHeader($active, $asignacion);
        $this->getFooter();

        $this->notaAsignacion($active, $iactive);

        $name = "asignacion_nro_{$active->nrod}_{$active->gest}";
        PDF::Output($name);
    }

    private function notaAsignacion($active, $iactive){
        PDF::SetMargins(15, 34, 15);
//        PDF::SetAutoPageBreak(TRUE, 40);
        PDF::SetHeaderMargin(8);
        PDF::SetFooterMargin(8);

        PDF::AddPage();
        PDF::SetFont('courier', '', 8);

        $noteInfo = <<<EOD
            <style>
                .th_line{
                    font-weight: bolder;
                    border-bottom: 1px solid #ddd;
                }
            </style>
            <table border="0" cellpadding="1">
                <tbody>
                    <tr>
                        <td colspan="5" align="left"></td>
                    </tr>
                    <tr>
                        <td colspan="5" align="left"></td>
                    </tr>
                    <tr>
                        <td width="6%"></td>
                        <th width="17%">ACTA DE RECEPCIÓN ALCOS</th>
                        <td width="3%"> : </td>
                        <td width="70%">No. {$active->nrod}/{$active->gest}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="6%"></td>
                        <th>RESPONSABLE DE CUSTODIO</th>
                        <td> : </td>
                        <td>{$active->crsp} - {$active->nrsp}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <th class="th_line" colspan="5" align="left">ACTIVO</th>
                    </tr>
                    <tr>
                        <td width="6%"></td>
                        <th>CODIGO</th>
                        <td> : </td>
                        <td>{$active->encd}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="6%"></td>
                        <th>DETALLE</th>
                        <td> : </td>
                        <td>{$active->desc}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="6%"></td>
                        <th>NRO. DE SERIE</th>
                        <td> : </td>
                        <td>{$active->nsre}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="6%"></td>
                        <th>ESTADO</th>
                        <td> : </td>
                        <td>{$active->nstt}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="6%"></td>
                        <th>VIDA UTIL</th>
                        <td> : </td>
                        <td>{$iactive->vidu} MESES</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <th class="th_line" colspan="5" align="left">RUBRO</th>
                    </tr>
                    <tr>
                        <td width="6%"></td>
                        <th>TIPO</th>
                        <td> : </td>
                        <td>{$active->ctpo} - {$active->ntpo}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="6%"></td>
                        <th>GRUPO</th>
                        <td> : </td>
                        <td>{$active->cgru} - {$active->ngru}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="6%"></td>
                        <th>SUB GRUPO</th>
                        <td> : </td>
                        <td>{$active->csgr} - {$active->nsgr}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <th class="th_line" colspan="5" align="left">UNIDAD</th>
                    </tr>
                    <tr>
                        <td width="6%"></td>
                        <th>UNIDAD DE NEGOCIO</th>
                        <td> : </td>
                        <td>{$iactive->uneg} - {$iactive->nung}</td>
                        <td width="2%"></td>
                    </tr>
                    <tr>
                        <td width="6%"></td>
                        <th>CENTRO DE COSTO</th>
                        <td> : </td>
                        <td>{$iactive->ccos} - {$iactive->ncos}</td>
                        <td width="2%"></td>
                    </tr>
                </tbody>
            </table>
EOD;


        $mobser = $iactive->obs1 . $iactive->obs2 . $iactive->obs3;
        $observations = <<<EOD
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
                        <td width="6%"></td>
                        <td width="94%">{$mobser}</td>
                    </tr>
                </tbody>
            </table>

EOD;


        /*
         * <table border="0" cellpadding="1">
                <thead>
                    <tr>
                        <th class="th_line" colspan="2" align="left">OBSERVACIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td width="6%"></td>
                        <td width="94%">test</td>
                    </tr>
                </tbody>
            </table>
         * */
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
                                    <td width="95%">La activación de todo bien será realizada por el Responsable de Activos Fijos para su respectiva asignación.
                                    </td>
                                    <td width="2%"></td>
                                </tr>
                                <tr>
                                    <td width="3%"><b>2.</b></td>
                                    <td>A cada funcionario de la Institución se le asignará bajo registro escrito, el mobiliario y/o equipo necesario para el buen desempeño de sus funciones y este será el custodio de los mismos.
                                    </td>
                                    <td width="2%"></td>
                                </tr>
                                <tr>
                                    <td width="3%"><b>3.</b></td>
                                    <td>Todo funcionario que utilice bienes muebles de la Institución, responderá por la pérdida o deterioro culposo en el uso irracional de los bienes.
                                    </td>
                                    <td width="2%"></td>
                                </tr>
                                <tr>
                                    <td width="3%"><b>4.</b></td>
                                    <td>Todo funcionario que tenga bienes a su cargo, deberá informar a su Jefe inmediato y al Responsable de Activos Fijos, de cualquier extravío o robo o daño del bien asignado a más tardar 24 horas.
                                    </td>
                                    <td width="2%"></td>
                                </tr>
                                <tr>
                                    <td width="3%"><b>5.</b></td>
                                    <td>Los responsables del custodio de activos de las distintas unidades deben velar porque los codigos de activos impreso o señalado en los bienes no se deterioren, aun cuando sean sometidos a labores de mantenimiento, reparación y/o modificaciones.
                                    </td>
                                    <td width="2%"></td>
                                </tr>
                                <tr>
                                    <td width="3%"><b>6.</b></td>
                                    <td>En caso que el codigo de un activo sea borrado por cualquier causa, deberá ser informado al Responsable de Activos Fijos para que se emita una copia del codigo y se coloque nuevamente.
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
                                <tr><td style="text-align: center">RESPONSABLE DEL CUSTODIO</td></tr>
                            </table>
                        </td>
                    </tr>
                </table>
EOD;
//
        PDF::writeHTML($noteInfo, true, false, true, false, '');
        PDF::writeHTML($observations, true, false, true, false, '');
        PDF::writeHTML($noteInstructive, true, false, true, false, '');

        PDF::SetFont('courier', '', 7);
        PDF::writeHTML($signed, true, false, true, false, '');
    }

    private function getLogo(){
        return K_PATH_IMAGES.'/logo.png';
    }

    private function getHeader($active, $asignation)
    {
        PDF::setHeaderCallback(function($pdf) use ($active, $asignation){

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
                            <tr><td><b style="font-size: 13px">ALTA Y ASIGNACION DE ACTIVOS</b></td></tr>
                            <tr><td></td></tr>
                            <tr><th><p style="font-size: 10px">ACTA DE ASIGNACION ALCOS No. {$asignation->afndccorr}</p></th></tr>
<!--                            <tr><th><p style="font-size: 10px">FECHA DE ADQUISICIÓN: </p></th></tr>-->
                        </table>
                    </td>
                    <td width="20%">
                        <table border="0" align="right">
                        <tr>
                            <td>
                            <img style="width: 50px; height: 50px; text-align: center" src="@{$qrcode}" alt="barcode"   />
                            </td>
                        </tr>
                        <tr><td>AF-ACT-ASGN</td></tr>
                    </table>
                    </td>
                </tr>
            </table>
            <table border="0.5"></table>
EOD;
            $pdf->writeHTML($tbl, true, false, true, false, '');
        });
    }


    //---- new header for alta de asignacion
//    private function getHeader($active, $title){
//
//        PDF::setHeaderCallback(function($pdf) use ($active, $title){
//
//            $code   = "{$active->encd}|{$active->corr}";
//            $qrcode = ""; //DNS2D::getBarcodePNG($code, "QRCODE");
//            $pdf->SetFont('courier', null, 8);
//
//            $style = array(
//                'border' => 2,
//                'vpadding' => 'auto',
//                'hpadding' => 'auto',
//                'fgcolor' => array(0,0,0),
//                'bgcolor' => false,
//                'module_width' => 1,
//                'module_height' => 1
//            );
//
//            $logo = $this->getLogo();
//
//            $tbl = <<<EOD
//            <table border="0">
//                <tr>
//                    <td width="20%">
//                        <table>
//                            <tr>
//                                <td>
//                                    <img src="{$logo}" width="60" height="60">
//                                </td>
//                            </tr>
//                        </table>
//                    </td>
//                    <td width="60%">
//                        <table border="0" align="center">
//                            <tr><td></td></tr>
//                            <tr><td></td></tr>
//                            <tr><td></td></tr>
//                            <tr><td><b style="font-size: 13px">ALTA Y ASIGNACION DE ACTIVOS</b></td></tr>
//                            <tr><td></td></tr>
//                            <tr><td></td>code / </tr>
//                            <tr><td></td></tr>
//                        </table>
//                    </td>
//                    <td width="20%">
//                        <table border="0" align="right">
//                        <tr>
//                            <td>
//                            <img style="width: 50px; height: 50px; text-align: center" src="@{$qrcode}" alt="barcode"   />
//                            </td>
//                        </tr>
//                        <tr><td>REGISTRO: {$active->fbuy}</td></tr>
//                    </table>
//                    </td>
//                </tr>
//            </table>
//            <table border="0.5"></table>
//EOD;
//            $pdf->writeHTML($tbl, true, false, true, false, '');
//        });
//    }

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
