<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Registrar nuevo proveedor</h3>
    </div>

    <div class="box-body">
        <div class="box-body text-center">  
            <a id="newprov" class="btn btn-app">
                <i class="fa fa-truck"></i> Proveedor
            </a>
        </div>

    </div>
</div>
<script>
    var prod_forma;
    $(document).ready(function() {
        var testneg = {{ $list->idshopped }};
        $('#newprov').attr('href', '/compras/shopbone/newprove/'+testneg);

        

    });
</script>

