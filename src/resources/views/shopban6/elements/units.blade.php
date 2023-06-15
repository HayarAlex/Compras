<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-list"></i>
        <h4 class="box-title">Lista Pedidos Pendientes de Revision Calidad</h4>
    </div>
    <div class="box-body no-pad-top">
        <table id="prod-list" class="display compact nowrap">
            <thead>
            <tr>
                <th class="text-center">N° PEDIDO</th>
                <th class="text-center">CODIGO</th>
                <th class="text-center">DESCRIPCION</th>
                <th class="text-center">CANTIDAD REQ</th>
                <th class="text-center">FECHA REQ</th>
                <th class="text-center">PRIORIDAD</th>
                <th class="text-center">ESTADO</th>
                <th width="10%"></th>
            </tr>
            </thead>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#prod-list').DataTable({
            ordering: false,
            paging: false,
            scrollY: 400,
            dom: 'lrtip',
            ajax: {
                url: "/compras/shopbsix/list",
            },
            columnDefs: [
                {
                    targets: 0,
                    className: "text-center",
                    data: "idsh"
                },
                {
                    targets: 1,
                    className: "text-center",
                    data: "codsh"
                },
                {
                    targets: 2,
                    className: "text-center",
                    data: "descsh"
                },
                {
                    targets: 3,
                    className: "text-center",
                    data: "cansh"
                },
                {
                    targets: 4,
                    className: "text-center",
                    data: "freqsh"
                },
                {
                    targets: 5,
                    className: "text-center",
                    data: function (data) {
                        if (data.priosh == 1) {
                            return '<label style="font-weight: normal;">Normal</label>';
                        }else{
                            return '<label style="font-weight: normal;">Urgente</label>';
                        }
                        
                    }
                },
                {
                    targets: 6,
                    className: "text-center",
                    data: function (data) {
                        if (data.strfinsh == 0) {
                            return '<a href="">' +
                                '<i class="fa fa-close"></i>' +
                                '</a>';
                        }else if (data.strfinsh == 2) {
                            return '<a href="">' +
                                '<i class="fa fa-exclamation-triangle"></i>' +
                                '</a>';
                        }else{
                            return '<a href="">' +
                                '<i class="fa fa-check"></i>' +
                                '</a>';
                        }
                        
                    }
                },
                {
                    targets: 7,
                    className: "text-center",
                    data: function (data) {
                        return '<a href="/compras/shopbsix/prove/' + data.idsh + '">' +
                            '<i class="fa fa-arrow-circle-right"></i>' +
                            '</a>';
                    }
                },
                
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
            }
        });
    });
</script>
