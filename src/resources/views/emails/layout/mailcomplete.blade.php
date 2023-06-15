<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="x-apple-disable-message-reformatting">
  <title></title>
  <style>
    table, td, div, h1, p {font-family: Arial, sans-serif;}
  </style>
</head>
<body style="margin:0;padding:0;">
  <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
    <tr>
      <td align="center" style="padding:0;">
        <table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
          <tr>
            <td style="padding:36px 30px 42px 30px;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                <tr>
                  <td style="padding:0 0 36px 0;color:#153643;">
                    <h2 style="font-size:20px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Administración Tickets - Almacen / Atención Completa del pedido</h2>
                  </td>
                </tr>
                  <td style="padding:0;">
                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                      @switch(true)
                        @case($temail['tiped'] == '1')
                          <tr>
                            <td id="grl">
                              <p id="texto">TIPO PEDIDO : </p>
                            </td>
                            <td id="prm">&nbsp;</td>
                            <td id="seg">
                              <p id="textores">PEDIDO ADICIONAL</p>
                            </td>
                          </tr>
                          @break
                        @case($temail['tiped'] == '2')
                          <tr>
                            <td id="grl">
                              <p id="texto">TIPO PEDIDO : </p>
                            </td>
                            <td id="prm">&nbsp;</td>
                            <td id="seg">
                              <p id="textores">PEDIDO POR LOTE</p>
                            </td>
                          </tr>
                          @break
                        @case($temail['tiped'] == '3')
                          <tr>
                            <td id="grl">
                              <p id="texto">TIPO PEDIDO : </p>
                            </td>
                            <td id="prm">&nbsp;</td>
                            <td id="seg">
                              <p id="textores">PEDIDO DE INSUMOS</p>
                            </td>
                          </tr>
                          @break
                        @case($temail['tiped'] == '4')
                          <tr>
                            <td id="grl">
                              <p id="texto">TIPO PEDIDO : </p>
                            </td>
                            <td id="prm">&nbsp;</td>
                            <td id="seg">
                              <p id="textores">PEDIDO MATERIA PRIMA</p>
                            </td>
                          </tr>
                          @break
                      @endswitch
                      <tr>
                        <td id="grl">
                          <p id="texto">COD PEDIDO : </p>
                        </td>
                        <td id="prm">&nbsp;</td>
                        <td id="seg">
                          <p id="textores">{{ $temail['idpeal'] }}</p>
                        </td>
                      </tr>
                      @if($temail['tiped'] == '1' || $temail['tiped'] == '2' )
                      <tr>
                        <td id="grl">
                          <p id="texto">N° DE LOTE : </p>
                        </td>
                        <td id="prm">&nbsp;</td>
                        <td id="seg">
                          <p id="textores">{{ $temail['numlote'] }}</p>
                        </td>
                      </tr>
                      <tr>
                        <td id="grl">
                          <p id="texto">ORDEN DE PRODUCCION : </p>
                        </td>
                        <td id="prm">&nbsp;</td>
                        <td id="seg">
                          <p id="textores">{{ $temail['ordprod'] }}</p>
                        </td>
                      </tr>
                      <tr>
                        <td id="grl">
                          <p id="texto">COD MATERIAL : </p>
                        </td>
                        <td id="prm">&nbsp;</td>
                        <td id="seg">
                          <p id="textores">{{ $temail['timat'] }}</p>
                        </td>
                      </tr>
                      <tr>
                        <td id="grl">
                          <p id="texto">DESCRIPCION : </p>
                        </td>
                        <td id="prm">&nbsp;</td>
                        <td id="seg">
                          <p id="textores">{{ $temail['descprod'] }}</p>
                        </td>
                      </tr>
                      @endif
                      <tr>
                        <td id="grl">
                          <p id="texto">FECHA REQUERIDA : </p>
                        </td>
                        <td id="prm">&nbsp;</td>
                        <td id="seg">
                          <p id="textores">{{ $temail['pfecha'] }}</p>
                        </td>
                      </tr>
                      <tr>
                        <td id="grl">
                          <p id="texto">OBSERACION : </p>
                        </td>
                        <td id="prm">&nbsp;</td>
                        <td id="seg">
                          <p id="textores">{{ $temail['observacionpeal'] }}</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td style="padding:30px;background:#FFC73D;">
              <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
                <tr>
                  <td style="padding:0;width:50%;" align="left">
                    <p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                      GrupoAlcos S.A. - Manttiss System v.2.0.2<br/>
                    </p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
<style type="text/css">
    #texto{
        margin:0 0 12px 0;
        font-size:13px;
        line-height:24px;
        font-family:Arial,sans-serif;
        font-weight: bold;
    }
    #textores{
        margin:0 0 12px 0;
        font-size:13px;
        line-height:24px;
        font-family:Arial,sans-serif;
    }
    #seg{
        width:260px;
        padding:0;
        vertical-align:top;
        color:#153643;
    }
    #prm{
        width:20px;
        padding:0;
        font-size:0;
        line-height:0;
    }
    #grl{
        width:260px;
        padding:0;
        vertical-align:top;
        color:#153643;
    }
</style>






