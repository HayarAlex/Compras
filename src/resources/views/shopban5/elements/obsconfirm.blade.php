<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-paper-plane-o"></i>
        <h3 class="box-title">Seleccion area de revisión</h3>
    </div>
    <div class="box-body" style="margin-bottom: -25px;">
        <form id="form-add" >
            <table class="table table-condensed table-striped">
                <tr>
                    <th width="35%">OBSERVACIONES</th>
                    <td width="65%" class='no-padding'>
                        {!! Former::text('fen', '')
                                  ->class('sel9 form-control input-sm text-uppercase')->autocomplete('off')!!}
                    </td>
                </tr>
                
            </table>
        </form>
    </div>
    <div class="box-footer text-right">
        <button id="btn-create" class="btn btn-success" onclick="sendo()">
            <span class="fa fa-send"> Registrar</span>
        </button>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script>
<script>

    var area = "1020";
    var idpedido = {{ $list->idshopped }};
    var envi = {{ $list->statearerev }};
    var c = {{ $list->staterevend }};
    var l = {{ $list->statelog }};
    var s = {{ $list->statesan }};
    var i = {{ $list->stateinv }};
    
    $(document).ready(function() {
        $('#desc').prop('readonly', true);
        //console.log(idpedido);
        //console.log(envi);

        $('#ref').on('click', function(){
            window.location.reload();
        });
        
    });


    function sendo () {

        var form = $('#form-add')[0];
        var form_data = new FormData(form);

        $("#btn-create").prop("disabled", true);
        formForms = $('#form-add');
        var vobsa = document.querySelector('.sel9').value;
        
        var obj = {
            idshpe:idpedido,
            obsasig:vobsa,
            lo:l,
            sa:s,
            ca:c,
            in:i,
        };
        console.log(obj);
        axios.put('/compras/shopbfive/confobs', obj)
            .then(function (response) {
                toastrSuccess();
                window.location.href = "/compras/shopbfive";
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
