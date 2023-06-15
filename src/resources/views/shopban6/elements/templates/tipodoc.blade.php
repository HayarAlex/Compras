<div class="modal fade mdl-list-table" id="mdl-list-table">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="clode" onclick="hideModalList()">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title sel9" id="mdl-list-new-head">2</h4>
            </div>
        	<div class="box box-default">
			    <div class="box-body no-pad-top">
			        <table id="prod-list" class="display compact nowrap">
			            <thead>
			            <tr>
			                <th class="text-center">Documentos</th>
                            <th class="text-center">Cantidad</th>
			                <th width="10%"></th>
			            </tr>
			            </thead>
			        </table>
			    </div>
			</div>
        </div>
    </div>
</div>
<script>
    $(document).on("click", "a.updateinfo", function () {
        var codigo = $(this).attr("data-nom");
        var nompro = $(this).attr("data-des");
        //console.log(codigo);
        $('.sel5').val(codigo);
        
        $('.sel9').text("Documentos - "+nompro);
        $('#descpro').prop('readonly', true);
        $('#doctype').prop('readonly', true);

        $('#prod-list').DataTable({
            ordering: false,
            paging: false,
            scrollY: 400,
            dom: 'lrtip',
            ajax: {
                url: "/compras/shopbtwo/listtipo/"+codigo,
            },
            columnDefs: [
                {
                    targets: 0,
                    className: "text-rigth",
                    data: "descripcion"
                },
                {
                    targets: 1,
                    className: "text-rigth",
                    data: "cant"
                },
                {
                    targets: 2,
                    className: "text-center",
                    data: function (data) {
                        return '<a class="docinfo" onclick="showModalListdoc(' + data.idtp + ','+ codigo +')" :data-nom="poque">' +
                            '<i class="fa fa-list"></i>' +
                            '</a>';
                    }
                },
                
            ],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
            }
        });

    });
    function hideModalList(folder){
        $('#mdl-list-table').modal('hide');
        $('#prod-list').DataTable().destroy();
    }
    function senddoc () {

        var form = $('#form-addp')[0];
        var form_data = new FormData(form);

        $("#btn-createpro").prop("disabled", true);
        formForms = $('#form-add');
        console.log(form_data.get("descpro"));

        axios.post('/compras/shopbtwo/registerdet', form_data,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                },
                onUploadProgress: progressEvent => {
                    console.log(progressEvent.loaded / progressEvent.total)
                }
            }).then(function(){
                toastrSuccess();
                $('#mdl-list-table').modal('hide');
                location.reload();
            }).catch(function(error){
                toastrWarning(error);
                $("#btn-createpro").prop("disabled", false);
            });
    }
    $(document).ready(function () {
        
    });
    function showModalListadd(folder){
        console.log(folder);
        if (folder == 1) {
            $('#mdl-list-new').modal('show');
            $('.sel6').val('1');
        }else if (folder == 2) {
            $('#mdl-list-new').modal('show');
            $('.sel6').val('2');
        }else{
            $('#mdl-list-new').modal('show');
            $('.sel6').val('3');
        }
        
    }
    function showModalListdoc(folder,cod){
        console.log(cod);
        console.log(folder);
        if (folder == 1) {
            $('#mdl-list-file').modal('show');
            dtFilestipo = $('#dt-filestipod').DataTable({
                ordering: false,
                paging: false,
                scrollY: 150,
                dom: 'lrtip',
                ajax: {
                    url: "/compras/shopbtwo/listdoctp/"+cod+"/"+folder,
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
                                        <i class="fa fa-eye"></i>
                                    </a>`;
                            return download;
                        }
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
                }
            });
        }else if (folder == 2) {
            $('#mdl-list-file').modal('show');
            dtFilestipo = $('#dt-filestipod').DataTable({
                ordering: false,
                paging: false,
                scrollY: 150,
                dom: 'lrtip',
                ajax: {
                    url: "/compras/shopbtwo/listdoctp/"+cod+"/"+folder,
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
                                        <i class="fa fa-eye"></i>
                                    </a>`;
                            return download;
                        }
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
                }
            });
        }else{
            $('#mdl-list-file').modal('show');
            dtFilestipo = $('#dt-filestipod').DataTable({
                ordering: false,
                paging: false,
                scrollY: 150,
                dom: 'lrtip',
                ajax: {
                    url: "/compras/shopbtwo/listdoctp/"+cod+"/"+folder,
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
                                        <i class="fa fa-eye"></i>
                                    </a>`;
                            return download;
                        }
                    }
                ],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
                }
            });
        }
        
    }
    function downloadAdjunto(link){
        window.open("/storage/"+link,'Adjunto','width=600,height=400')
    }
    function destroyTableas() {
        $('#mdl-list-file').modal('hide');
        $('#dt-filestipod').DataTable().destroy();
    }
    function deletingAdjunto(id){
        console.log(id);
        axios.put('/compras/shopbtwo/delfilet/'+ id)
            .then(function (response) {
                toastrSuccess();
            })
            .catch(function (error) {
                toastrWarning(error);
            })
            .then(function(response){
                console.log("cambio estado");
                //window.location.href = "/compras/admtender/showla/"+testneg;
                window.location.reload();
            });
    }
</script>