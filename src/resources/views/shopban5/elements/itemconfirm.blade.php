<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-paper-plane-o"></i>
        <h3 class="box-title">Seleccion area de revisión</h3>
    </div>
    <div class="box-body" style="margin-bottom: -25px;">
        <form id="form-add" >
            <table class="table table-condensed table-striped">
                <tr > 
                    <th width="35%">AREA DE REVISION</th>
                    <td width="65%" class='no-padding' >
                        <select class="sel8 form-control input-sm text-uppercase" name="tymed" id="tymed" multiple>
                            <option value="1">Inv. Desarrollo</option>
                            <option value="2">Logistica</option>
                            <option value="3">Registro Sanitario</option>
                            <option value="4">Calidad</option>
                        </select>
                    </td>
                </tr>
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
    new MultiSelectTag('tymed')

    var area = "1020";
    var idpedido = {{ $list->idshopped }};
    var envi = {{ $list->statearerev }};
    
    $(document).ready(function() {
        $('#desc').prop('readonly', true);
        //console.log(idpedido);
        //console.log(envi);
        if (envi == '1') {
            $("#btn-create").prop("disabled", true);
        }

        $('#ref').on('click', function(){
            window.location.reload();
        });
        
    });


    function sendo () {

        var form = $('#form-add')[0];
        var form_data = new FormData(form);

        $("#btn-create").prop("disabled", true);
        formForms = $('#form-add');
        var hoy = new Date();
        var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
        var fecha = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear();
        var fechaYHora = fecha + ' ' + hora;
        var varea = document.querySelector('.sel8').value;
        var vobsa = document.querySelector('.sel9').value;
        var sjs = $("#tymed :selected").map((_, e) => e.value).get();
        var cnt = sjs.length;
        var max = Math.max(...sjs);
        
        console.log(sjs);
        
        if (cnt >= 1) {
            for (var i = 0; i < cnt; i++) {
                var obj = {
                    idshpe:idpedido,
                    tipoped:sjs[i],
                    obsasig:vobsa,
                };
                console.log(obj);
                axios.put('/compras/shopbfive/confasig', obj)
                    .then(function (response) {
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
        }else{
            cal = 1;
        }
        var cal=0;
        var log=0;
        var san=0;
        var inv=0;
        for (var j = 0; j < cnt; j++) {
            if (sjs[j] == 1) {
                console.log('revision inv');
                inv = 1;
            }else if (sjs[j] == 2) {
                console.log('revision log');
                log = 1;
            }else if (sjs[j] == 3) {
                console.log('revision san');
                san = 1;
            }else if (sjs[j] == 4) {
                console.log('revision cal');
                cal = 1;
            }
        }
        var objm = {
            idshpe:idpedido,
            arearev:cal,
            arelo:log,
            aresa:san,
            arein:inv,
            obsasig:vobsa,
            horas:fechaYHora,
        };
        console.log(obj);
        axios.put('/compras/shopbfive/confasigm', objm)
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
