<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-bell-o"></i>
        <h3 class="box-title">Informacion Pedido</h3>
    </div>

    <div class="box-body">
        <table class="table table-striped table-condensed">
            <tr>
                <th>N° Pedido</th>
                <td width="60%" class="text-right text-uppercase">
                    {{ $list->idshopped }}
                </td>
            </tr>
            <tr>
                <th>Codigo</th>
                <td width="60%" class="text-right text-uppercase">
                    {{ $list->codigosh }}
                </td>
            </tr>
            <tr>
                <th>Descripcion</th>
                <td width="60%" class="text-right text-uppercase">
                    {{ $list->descripcionsh }}
                </td>
            </tr>
            <tr>
                <th>Cantidad Req</th>
                <td width="60%" class="text-right text-uppercase">
                    {{ $list->cantidadsh }}
                </td>
            </tr>
            <tr>
                <th>Fecha Req</th>
                <td width="60%" class="text-right text-uppercase">
                    {{ $list->fechareqsh }}
                </td>
            </tr>
            <tr>
                <th>Priridad</th>
                @if($list->prioritysh == 1)
                <td width="60%" class="text-right text-uppercase">
                    Normal
                </td>
                @else
                <td width="60%" class="text-right text-uppercase">
                    Urgente
                </td>
                @endif
            </tr>
        </table>

    </div>
</div>

