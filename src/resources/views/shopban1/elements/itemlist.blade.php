<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-list"></i>
        <h3 class="box-title">Seleccion de Proveedores</h3>
    </div>
    <div class="box-body no-pad-top">

        <div class="mailbox-controls">

            <div class="pull-right">
                <div class="btn-group">
                    <button id="btn-add-product" class="btn btn-primary btn-xs" style="margin-right: 5px"><i class="fa fa-plus">Agregar</i>
                    </button>
                </div>
            </div>
        </div>

        <table class="display compact nowrap" id="prod-list">
            <thead>
            <tr>
                <th class="text-left">Codigo</th>
                <th class="text-left">Nombre</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    var prod_forma;
    var enviost = {{ $list->stateevprov }};
    $(document).ready(function() {
        if (enviost == '1') {
            $("#btn-add-product").prop("disabled", true);
        }
        var testneg = {{ $list->idshopped }};
        $('#newprov').attr('href', '/compras/shopbone/newprove/'+testneg);

        prod_list = $('#prod-list').DataTable({
            ordering: false,
            paging: false,
            scrollY: 150,
            dom: 'lrtip',
            ajax: '/compras/transfer/list/provee/{{ $list->codigosh }}',
            select: {
                style: 'multi'
            },
            columnDefs: [
                {
                    targets: 0,
                    data: "codep"
                },
                {
                    targets: 1,
                    data: "descp"
                }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
                select: {
                    rows: {
                        _: "<br>Usted ha seleccionado %d filas",
                        0: "<br>Haga clic en una fila para seleccionarlo",
                        1: "<br>Solo 1 fila seleccionada"
                    }
                },
            }
        });

        $('#all-select').on('click', function(){
            prod_forma.rows().select();
        });

        $('#list-select').on('click', function(){
            prod_list.rows().select();
        });

        $('#all-deselect').on('click', function(){
            prod_forma.rows().deselect();
        });

        $('#list-deselect').on('click', function(){
            prod_list.rows().deselect();
        });

        $("#btn-add-product").on('click', function(){
            var oData = prod_list.rows('.selected').data().toArray();
            var saiSelect = $.map(oData, function(o) { return o["codep"]; });
            if(saiSelect.length > 0){
                axios.post('/compras/shopbone/shdetpost/{{ $id }}', {'list' : oData})
                    .then(function (response) {
                        saiSelect = [];

                        prod_list.ajax.reload();
                        prod_list.columns.adjust().draw();

                        prod_forma.ajax.reload();
                        prod_forma.columns.adjust().draw();
                        toastrSuccess();
                    })
                    .catch(function (error) {
                        toastrSuccess();
                        //console.log(oData);
                        $("#btn-reg").prop("disabled", false);
                        location.reload();
                    });

            }else{
                 toastr.error('Debe seleccionar al menos un item!!!');
            }
        });

    });
</script>

