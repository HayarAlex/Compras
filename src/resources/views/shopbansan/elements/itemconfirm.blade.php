<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-paper-plane-o"></i>
        <h3 class="box-title">Confirmar revision</h3>
    </div>
    <div class="box-body" style="margin-bottom: -25px;">
        <form id="form-add" >
            <table class="table table-condensed table-striped">
                
                <tr>
                    <th width="35%">COMENTARIO</th>
                    <td width="65%" class='no-padding'>
                        {!! Former::text('fen', '')
                                  ->class('sel5 form-control input-sm text-uppercase')->autocomplete('off')!!}
                    </td>
                </tr>
                
            </table>
        </form>
    </div>
    <div class="box-footer text-right">
        <button id="btn-create" class="btn btn-success btn-sm" onclick="send()">
            <span class="fa fa-send"> Confirmar Pedido</span>
        </button>
        <button id="btn-observ" class="btn btn-warning btn-sm" onclick="observar()">
            <span class="fa fa-send"> Observado</span>
        </button>
    </div>
</div>

<script>
    var area = "1020";
    var hoy = new Date();
    var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
    var fecha = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear();
    var fechaYHora = fecha + ' ' + hora;
    var idpedido = {{ $list->idshopped }};
    var enviost = {{ $list->statesan }};
    var revi = {{ $rev[0]->idshrev }};
    var scal = {{ $list->arearevsh }};
    var ssan = {{ $list->arearevsa }};
    var slog = {{ $list->arearevlo }};
    var sinv = {{ $list->arearevin }};
    $(document).ready(function() {
        $('#desc').prop('readonly', true);
        if (enviost == '1' || enviost == '2') {
            $("#btn-create").prop("disabled", true);
            $("#btn-observ").prop("disabled", true);
        }
        $('#ref').on('click', function(){
            window.location.reload();
        });
        
        
    });

    function send () {

        var form = $('#form-add')[0];
        var form_data = new FormData(form);

        $("#btn-create").prop("disabled", true);
        formForms = $('#form-add');
        var vcoment = document.querySelector('.sel5').value;

        var obj = {
            idshpe:idpedido,
            comentario:vcoment,
            revis:revi,
            cal:scal,
            san:ssan,
            log:slog,
            inv:sinv,
            horas:fechaYHora
        };
        console.log(obj);
        axios.put('/compras/shopban/confirmsan', obj)
            .then(function (response) {
                toastrSuccess();
                window.location.href = "/compras/shopban";
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
    function observar () {

        var form = $('#form-add')[0];
        var form_data = new FormData(form);

        $("#btn-create").prop("disabled", true);
        $("#btn-observ").prop("disabled", true);
        formForms = $('#form-add');
        var vdesc = document.querySelector('.sel5').value;

        var obj = {
            idshpe:idpedido,
            comentario:vdesc
        };
        //console.log(obj);

        axios.put('/compras/shopban/observation', obj)
            .then(function (response) {
                toastrSuccess();
                window.location.href = "/compras/shopban";
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