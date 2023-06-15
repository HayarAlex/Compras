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
<div class="modal fade mdl-list-new" id="mdl-list-new">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="clode" onclick="hideModalList()">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title sel9" id="mdl-list-new-head"></h4>
            </div>
            <div class="modal-body">
                <form id="form-addp" enctype="multipart/form-data">

                    <table class="table table-condensed table-striped">
                        <tr>
                            <th width="15%">N° PROVEEDOR</th>
                            <td width="35%" class='no-padding'>
                                {!! Former::text('descpro', '')
                                          ->class('sel5 form-control input-sm text-uppercase') !!}
                            </td>
                            
                        </tr>
                        <tr>
                            <th width="15%">DOC</th>
                            <td width="35%" class='no-padding'>
                                {!! Former::text('doctype', '')
                                          ->class('sel6 form-control input-sm text-uppercase') !!}
                            </td>
                        </tr>
                        <tr>
                            <th width="35%">ARCHIVOS ADJUNTOS</th>
                            <td width="65%" class='no-padding'>
                                <input type="file" id='files' name="files[]" multiple class="sel2 form-control input-sm">
                            </td>
                        </tr>
                        
                    </table>
                </form>
                <div class="box-footer text-right">
                    <button id="btn-createpro" class="btn btn-success btn-sm" onclick="senddoc()">
                        <span class="fa fa-plus"> Agregar doc.</span>
                    </button>
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
                            '</a>'+'&nbsp;'+
                            '<a onclick="showModalListadd(' + data.idtp + ')">' +
                            '<i class="fa fa-plus-circle"></i>' +
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
        }else if (folder == 3){
            $('#mdl-list-new').modal('show');
            $('.sel6').val('3');
        }else{
            $('#mdl-list-new').modal('show');
            $('.sel6').val('4');
        }
        
    }
    function showModalListdoc(folder,cod){
        console.log(cod);
        console.log(folder);
        if (folder == 1) {
            $('#mdl-list-file').modal('show');
            dtFilestipo = $('#dt-filestipo').DataTable({
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
                            remove = `<a href="#" onclick="deletingAdjunto('${data.iddocprov}')">
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
        }else if (folder == 2) {
            $('#mdl-list-file').modal('show');
            dtFilestipo = $('#dt-filestipo').DataTable({
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
                            remove = `<a href="#" onclick="deletingAdjunto('${data.iddocprov}')">
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
        }else{
            $('#mdl-list-file').modal('show');
            dtFilestipo = $('#dt-filestipo').DataTable({
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
                            remove = `<a href="#" onclick="deletingAdjunto('${data.iddocprov}')">
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
        }
        
    }
    function downloadAdjunto(link){
        window.open("/storage/"+link,'Adjunto','width=600,height=400')
    }
    function destroyTablea() {
        $('#mdl-list-file').modal('hide');
        $('#dt-filestipo').DataTable().destroy();
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