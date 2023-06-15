<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-file-o"></i>
        <h3 class="box-title">Carga de archivos tipo</h3>
    </div>
    <div class="box-body" style="margin-bottom: -25px;">
        <form id="form-add" enctype="multipart/form-data">
            <table class="table table-condensed table-striped">
                <tr>
                    <th width="35%">N° PEDIDO</th>
                    <td width="65%" class='no-padding'>
                        {!! Former::text('desc', '')
                                  ->class('sel3 form-control input-sm text-uppercase')
                                  ->value($list->idshopped) !!}
                    </td>
                </tr>
                <tr>
                    <th width="35%">ARCHIVOS TIPO</th>
                    <td width="65%" class='no-padding'>
                        <input type="file" id='files' name="files[]" multiple class="sel1 form-control input-sm">
                    </td>
                </tr>
                
            </table>
        </form>
    </div>
    <div class="box-footer text-right">
        <button id="btn-createfile" class="btn btn-success" onclick="send()">
            <span class="fa fa-floppy-o"> Guardar</span>
        </button>
    </div>
</div>

<script>
    var area = "1020";
    var idpedido = {{ $list->idshopped }};
    var enviost = {{ $list->statersprov }};
    $(document).ready(function() {
        $('#desc').prop('readonly', true);

        $('#ref').on('click', function(){
            window.location.reload();
        });
        
        
    });

    function send () {

        var form = $('#form-add')[0];
        var form_data = new FormData(form);

        $("#btn-createfile").prop("disabled", true);
        formForms = $('#form-add');
        var vdesc = document.querySelector('.sel3').value;
        var vfile = document.querySelector('.sel1').value;

        var obj = {
            desc:vdesc,
            files:vfile,
        };
        //console.log(obj);
        var filename = document.querySelector('.sel1').value;
        if (filename == "") {
            console.log('no se cargo el archivo tipo');
        }else{
            axios.post('/compras/shopbtwo/register', form_data,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: progressEvent => {
                        console.log(progressEvent.loaded / progressEvent.total)
                    }
                }).then(function(){
                    toastrSuccess();
                    $("#btn-createfile").prop("disabled", false);
                    //window.location.href = "/compras/shopbtwo";
                }).catch(function(error){
                    toastrWarning(error);
                    $("#btn-createfile").prop("disabled", false);
                });
        }

        
    }
</script>