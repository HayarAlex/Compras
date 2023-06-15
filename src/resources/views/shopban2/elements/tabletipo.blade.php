<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-file-o"></i>
        <h3 class="box-title">Archivos Tipo</h3>
    </div>

    <div class="box-body">
        <table id="dt-filestipo" class="display compact nowrap" style="width:100%">
            <thead>
            <tr>
                <th width="95%">DETALLE ARCHIVO</th>
                <th width="5%" class="text-right"></th>
            </tr>
            </thead>
        </table>

    </div>
</div>
<script>
    var dtFilestipo;
    var idpedido = {{ $list->idshopped }};
    $(document).ready(function () {
        $('.sel9').text("Documentos - ");
        dtFilestipo = $('#dt-filestipo').DataTable({
            ordering: false,
            paging: false,
            scrollY: 150,
            dom: 'lrtip',
            ajax: {
                url: "/compras/shopbtwo/listdoct/"+idpedido,
            },
            columnDefs: [
                {
                    targets: 0,
                    className: "text-uppercase",
                    data: "docname"
                },
                {
                    targets: 1,
                    className: "text-right",
                    data: function(data){
                        link = "'"+data.docurls+"'";

                        download = `<a href="#" onclick="downloadAdjunto('${data.docurls}')">
                                    <i class="fa fa-download"></i>
                                </a>`;
                        remove = `<a href="#" onclick="deletingAdjunto('${data.iddoctipo}')">
                                    <i class="fa fa-trash"></i>
                                </a>`;
                        return download+" "+remove;
                    }
                }
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
            }
        });
    });

    function downloadAdjunto(link){
        window.open("/storage/"+link,'Adjunto','width=600,height=400')
    }
    function destroyTablea() {
        dtFilestipo.destroy();
    }
    function deletingAdjunto(id){
        axios.put('/compras/shopbtwo/delfilet/'+ id)
            .then(function (response) {
                toastrSuccess();
            })
            .catch(function (error) {
                toastrWarning(error);
            })
            .then(function(response){
                console.log("cambio estado");
                //window.location.href = "/copmras/admtender/showla/"+testneg;
                window.location.reload();
            });
    }
</script>

