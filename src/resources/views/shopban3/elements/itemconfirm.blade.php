<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-paper-plane-o"></i>
        <h3 class="box-title">Respuesta</h3>
    </div>
    <div class="box-body" style="margin-bottom: -25px;">
        <form id="form-add" enctype="multipart/form-data">
            <table class="table table-condensed table-striped">
                
                <tr>
                    <th width="35%">OBSERVACIONES</th>
                    <td width="65%" class='no-padding'>
                        {!! Former::text('obser', '')
                                  ->class('sel3 form-control input-sm text-uppercase')!!}
                    </td>
                </tr>
                
                
            </table>
        </form>
    </div>
    <div class="box-footer text-right">
        <button id="btn-create" class="btn btn-success btn-sm" onclick="send()">
            <span class="fa fa-send"> Aprobado</span>
        </button>
        <button id="btn-observ" class="btn btn-warning btn-sm" onclick="observar()">
            <span class="fa fa-send"> Observado</span>
        </button>
    </div>
</div>

<script>
    var area = "1020";
    var idpedido = {{ $list->idshopped }};
    var enviost = {{ $list->staterevlog }};
    $(document).ready(function() {
        if (enviost == '1') {
            $("#btn-create").prop("disabled", true);
            $("#btn-observ").prop("disabled", true);
        }
        $('#desc').prop('readonly', true);

        $('#ref').on('click', function(){
            window.location.reload();
        });
        
        
    });

    function send () {

        var form = $('#form-add')[0];
        var form_data = new FormData(form);

        $("#btn-create").prop("disabled", true);
        $("#btn-observ").prop("disabled", true);
        formForms = $('#form-add');
        var vdesc = document.querySelector('.sel3').value;

        var obj = {
            id:idpedido,
            desc:vdesc,
        };
        console.log(obj);
        axios.put('/compras/shopbthree/register', obj)
            .then(function (response) {
                toastrSuccess();
                window.location.href = "/compras/shopbthree";
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
        var vdesc = document.querySelector('.sel3').value;

        var obj = {
            id:idpedido,
            desc:vdesc,
        };
        //console.log(obj);

        axios.put('/compras/shopbthree/observation', obj)
            .then(function (response) {
                toastrSuccess();
                window.location.href = "/compras/shopbthree";
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