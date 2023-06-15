<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-list"></i>
        <h3 class="box-title">Precio Unitario Presupuestado</h3>
    </div>

    <div class="box-body">
        <table style="float: left;" width="100%">
            <tr>
                <th>Codigo</th>
                <td width="60%" class="text-right text-uppercase">
                    {{ $list->codigosh }}
                </td>
            </tr>
            <tr>
                <th>Costo unitario ref. sai</th>
                <td width="60%" class="text-right text-uppercase">
                    {{ $listtwo[0]->costbol }}
                </td>
            </tr>
            <tr>
                <th>Total costo ref. sai</th>
                <td width="60%" class="text-right text-uppercase">
                    <p id="test"></p>
                </td>
            </tr>
        </table>
    </div>
</div>
<script>
    var area = "1020";
    var costuni = {{ $listtwo[0]->costbol }};
    var cant = {{ $list->cantidadsh }};
    $(document).ready(function() {
        var multi = costuni * cant ;
        $('#test').html(multi); 
        
    });
</script>

