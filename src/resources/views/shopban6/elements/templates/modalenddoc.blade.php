<div class="modal fade mdl-list-win" id="mdl-list-win">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="clode" onclick="hideModalList()">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title sel9" id="mdl-list-win-head"></h4>
            </div>
            <div class="modal-body">
                <form id="form-addf" enctype="multipart/form-data">

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
                    <button id="btn-addfin" class="btn btn-success btn-sm" onclick="senddocf()">
                        <span class="fa fa-plus"> Agregar doc.</span>
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>