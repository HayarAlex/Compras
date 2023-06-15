<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-exclamation"></i>
        <h3 class="box-title">Observacion de Revision</h3>
    </div>
    
    <div class="row">
        <div class="col-md-12 text-center">
            <table class="table table-striped table-condensed">
                <tr>
                    <th>Obs Inv. Desarrollo</th>
                    <td width="60%" class="text-right text-uppercase">
                        {{ $list->comentinv }}
                    </td>
                </tr>
                <tr>
                    <th>Obs Logistica</th>
                    <td width="60%" class="text-right text-uppercase">
                        {{ $list->comentlog }}
                    </td>
                </tr>
                <tr>
                    <th>Obs Reg. Saniario</th>
                    <td width="60%" class="text-right text-uppercase">
                        {{ $list->comentsan }}
                    </td>
                </tr>
                <tr>
                    <th>Obs Calidad</th>
                    <td width="60%" class="text-right text-uppercase">
                        {{ $list->obsthrd }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>