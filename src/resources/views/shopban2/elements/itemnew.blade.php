<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-user-plus"></i>
        <h3 class="box-title">Nuevo proveedor</h3>
    </div>
    <div class="box-footer text-right">
        <button id="btn-create" class="btn btn-success btn-xs" onclick="send()">
            <span class="fa fa-plus"> Nuevo Proveedor</span>
        </button>
    </div>
</div>

<script>
    var area = "1";
    var idpedido = {{ $list->idpeal }};
    $(document).ready(function() {
        var tes;
        //console.log(area);
        document.getElementById("fen").disabled = true;

        $('#ref').on('click', function(){
            window.location.reload();
        });
        
        
    });
    function add(){
        if (document.getElementById("rotn").checked) {
            //console.log("captura");
            document.getElementById("fen").disabled = false;
        }else{
            document.getElementById("fen").disabled = true;
        }
    }

    function send () {

        $("#btn-create").prop("disabled", true);
        formForms = $('#form-add');
        var vfe = document.querySelector('.sel4').value;
        if (document.getElementById("rot").checked) {
            //console.log("captura");
            var vpri= document.getElementById("rot").value;
            axios.put('/compras/almadmin/confirmpa/'+ idpedido)
                .then(function (response) {
                    toastrSuccess();
                })
                .catch(function (error) {
                    toastrWarning(error);
                })
                .then(function(response){
                    console.log("cambio estado");
                    window.location.href = "/compras/almadmin/showformad";
                    //window.location.reload();
                });
        }else{
            var obj = {
                idped:idpedido,
                fec:vfe
            };
            //console.log(obj);
            axios.put('/compras/almadmin/acfe', obj)
                .then(function (response) {
                    toastrSuccess();
                    window.location.href = "/compras/almadmin/showformad";
                    
                })
                .catch(function (error) {
                });
        }
        
        
    }
</script>