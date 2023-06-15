<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-paper-plane-o"></i>
        <h3 class="box-title">Clasificacion de compra</h3>
    </div>
    <div class="box-body" style="margin-bottom: -25px;">
        <form id="form-add">
            <table class="table table-condensed table-striped">
                <tr > 
                    <th width="35%">TIPO</th>
                    <td width="55%" class='text-right' >
                        <input type="radio" id="rot" name="rotulo" value="0" checked style="margin-right: 5px;"><label for="rot">Nuevo</label>
                        <input type="radio" id="rotn" name="rotulo" value="1" style="margin-right: 5px;margin-left: 10px"><label for="rotn">Recurrente</label>
                    </td>
                    
                </tr>
                <tr > 
                    <th width="35%">DETALLE</th>
                    <td width="55%" class='text-right' >
                        <input type="radio" id="det" name="detalle" value="0" checked style="margin-right: 5px"><label for="det">Local</label>
                        <input type="radio" id="detn" name="detalle" value="1" style="margin-right: 5px;margin-left: 10px"><label for="detn">Importado</label>
                    </td>
                    
                </tr>
                
            </table>
        </form>
    </div>
    <div class="box-footer text-right">
        <button id="btn-create" class="btn btn-success" onclick="send()">
            <span class="fa fa-floppy-o"> Registrar</span>
        </button>
    </div>
</div>

<script>
    var area = "1";
    var idpedido = {{ $list->idshopped }};
    var enviost = {{ $list->stateevprov }};

    $(document).ready(function() {
        var tes;
        if (enviost == '1') {
            $("#btn-create").prop("disabled", true);
        }
        $('#ref').on('click', function(){
            window.location.reload();
        });
        
        
    });

    function send () {

        $("#btn-create").prop("disabled", true);
        formForms = $('#form-add');
        var hoy = new Date();
        var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
        var fecha = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear();
        var fechaYHora = fecha + ' ' + hora;
        if (document.getElementById("rotn").checked) {
            //console.log("captura");
            var vtip= document.getElementById("rotn").value;
        }else{
            vtip = document.getElementById("rot").value;
        }
        if (document.getElementById("detn").checked) {
            //console.log("captura");
            var vdet= document.getElementById("detn").value;
        }else{
            vdet = document.getElementById("det").value;
        }

        var obj = {
            idshpe:idpedido,
            tipop:vtip,
            detap:vdet,
            horas:fechaYHora
        };
        console.log(obj);
        axios.put('/compras/shopbone/confasig', obj)
            .then(function (response) {
                toastrSuccess();
                window.location.href = "/compras/shopbone";
            })
            .catch(function (error) {
                toastrWarning(error);
            })
            .then(function(response){
                console.log("cambio estado");
                //window.location.href = "/compras/almorder/showformad";
                //window.location.reload();
            });
        
        
    }
</script>