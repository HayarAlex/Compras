<div class="modal fade mdl-list-file" id="mdl-list-file">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="destroyTablea()">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title sel9" id="mdl-list-file-head"></h4>
            </div>
            <div class="modal-body">

                <table id="dt-files" class="display compact nowrap" style="width:100%">
                    <thead>
                    <tr>
                        <th width="95%">DETALLE ARCHIVO</th>
                        <th width="5%" class="text-right"></th>
                    </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</div>
<script>
    var dtFiles;
    $(document).on("click", "a.updateinfo", function () {
        var codigo = $(this).attr("data-nom");
        var nompro = $(this).attr("data-des");
        $('.sel9').text("Documentos - "+nompro);
        console.log(codigo);
        dtFiles = $('#dt-files').DataTable({
            ordering: false,
            paging: false,
            scrollY: 150,
            dom: 'lrtip',
            ajax: {
                url: "/compras/shopbthree/listdoc/"+codigo,
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
                        return download;
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
        dtFiles.destroy();
    }
</script>