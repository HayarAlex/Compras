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
                    <h2 style="font-size:20px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Administración Compras - MAC - Asignacion de revision</h2>
                  </td>
                </tr>
                  <td style="padding:0;">
                    <table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                      <tr>
                        <td id="grl">
                          <p id="texto">N° PEDIDO : </p>
                        </td>
                        <td id="prm">&nbsp;</td>
                        <td id="seg">
                          <p id="textores">{{ $temail['idshopped'] }}</p>
                        </td>
                      </tr>
                      <tr>
                        <td id="grl">
                          <p id="texto">COD PEDIDO : </p>
                        </td>
                        <td id="prm">&nbsp;</td>
                        <td id="seg">
                          <p id="textores">{{ $temail['codigosh'] }}</p>
                        </td>
                      </tr>
                      <tr>
                        <td id="grl">
                          <p id="texto">NOMBRE PRODUCTO : </p>
                        </td>
                        <td id="prm">&nbsp;</td>
                        <td id="seg">
                          <p id="textores">{{ $temail['descripcionsh'] }}</p>
                        </td>
                      </tr>
                      <tr>
                        <td id="grl">
                          <p id="texto">FECHA REQUERIDA : </p>
                        </td>
                        <td id="prm">&nbsp;</td>
                        <td id="seg">
                          <p id="textores">{{ $temail['fechareqsh'] }}</p>
                        </td>
                      </tr>
                      <tr>
                        <td id="grl">
                          <p id="texto">ASIGNACION DE REVISION :</p>
                        </td>
                        <td id="prm">&nbsp;</td>
                        <td id="seg">
                          <p id="textores">{{ $temail['fecharegrev'] }}</p>
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






