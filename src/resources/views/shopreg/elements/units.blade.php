<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-paper-plane-o"></i>
        <h3 class="box-title">Nuevo Pedido</h3>
    </div>
    <div class="box-body">
        <form id="form-add" >
            <table  style="float: left;" width="100%">
                <tr > 
                    <th width="35%">CODIGO<label style="color: red">*</label></th>
                    <td width="55%" class='no-padding' >
                        {!! Former::select('cprd', '')
                                  ->class('sel1 form-control input-sm text-uppercase') !!}
                    </td>
                    
                </tr>
                <tr > 
                    <th width="35%">DESCRIPCION</th>
                    <td width="55%" class='no-padding' >
                        <input type="text" id="description" class="sel2 form-control input-sm text-uppercase" placeholder="Descripcion" disabled="">
                    </td>
                    
                </tr>
                <tr>
                    <th width="35%" >UNIDAD DE MEDIDA</th>
                    <td width="65%" class='no-padding'>
                        <input type="text" id="unidad" class="sel3 form-control input-sm text-uppercase" placeholder="Unidad de medida" disabled="">
                    </td>
                </tr>
                <tr > 
                    <th width="35%">CANTIDAD<label style="color: red">*</label></th>
                    <td width="55%" class='no-padding' >
                        <input type="number" id="nombremed" class="sel4 form-control input-sm text-uppercase" placeholder="Cantidad">
                    </td>
                    
                </tr>
                <tr > 
                    <th width="35%">FECHA REQUERIDA</th>
                    <td width="55%" class='no-padding' >
                        <input type="date" id="nombremed" class="sel5 form-control input-sm text-uppercase" placeholder="Cantidad">
                    </td>
                    
                </tr>
                <tr > 
                    <th width="35%">PRIORIDAD</th>
                    <td width="55%" class='no-padding' >
                        <input type="radio" id="rotsh" name="sex" value="1" checked style="margin-right: 5px"><label for="rotx">NORMAL</label>
                        <input type="radio" id="rotsm" name="sex" value="2" style="margin-right: 5px;margin-left: 10px"><label for="rotx">URGENTE</label>
                    </td>
                    
                </tr>
            </table>
        </form>
    </div>
    <div class="box-footer text-right">
        <button id="btn-create" class="btn btn-info">
            <span class="fa fa-save"> Registrar</span>
        </button>
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function() {

        $('#cprd').select2({
            ajax: {
                url: '/compras/transfer/list/arts',
                data: function (params) {
                    return {
                        srch: params.term
                    };
                },
                dataType: 'json',
                processResults: function (data) {
                    //console.log(data);
                    return {
                        results: data.map(function (item) {
                            return {
                                id: item.cart,
                                text: item.cart
                            };
                        })
                    }
                },
                cache: true
            },

            allowClear: true,
            placeholder: 'CODIGO PRODUCTO',
            minimumInputLength: 4

        });
        $('#cprd').change(function(){
            testdes();
            testnomb();
        });
        $('#btn-create').on('click', function(){
            send();
        });

    });

    function testnomb(){
        //console.log('test function');
        var codval = document.getElementById('cprd').value;
        axios.get('/compras/transfer/list/dataitem/'+codval)
            .then(function (response) {

                //console.log(response.data.data[0]);
                
                var uni = response.data.data[0].unid;
                $("#unidad").val(uni);
            })
            .then(function () {
            });
    }
    function testdes(){
        //console.log('test function');
        var codval = document.getElementById('cprd').value;
        axios.get('/compras/shopreg/detaitem/'+codval)
            .then(function (response) {

                var des = response.data.data[0].descpri;
                $("#description").val(des);
            })
            .then(function () {
            });
    }
    function send () {

        $("#btn-create").prop("disabled", true);
        formForms = $('#form-add');
        var hoy = new Date();
        var hora = hoy.getHours() + ':' + hoy.getMinutes() + ':' + hoy.getSeconds();
        var fecha = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear();
        var fechaYHora = fecha + ' ' + hora;
        var vcod = document.querySelector('.sel1').value;
        var vdes = document.querySelector('.sel2').value;
        var vumd = document.querySelector('.sel3').value;
        var vcan = document.querySelector('.sel4').value;
        var vfre = document.querySelector('.sel5').value;
        if (document.getElementById("rotsh").checked) {
            //console.log("captura");
            var vpri= document.getElementById("rotsh").value;
        }else{
            vpri = document.getElementById("rotsm").value;
        }

        var obj = {
            codigo:vcod,
            descri:vdes,
            unimed:vumd,
            cantid:vcan,
            fecreq:vfre,
            priori:vpri,
            horas:fechaYHora
        };
        console.log(obj);
        axios.post('/compras/shopreg/shoppost', obj)
            .then(function (response) {
                toastrSuccess();
                window.location.href = "/compras/shopbone";
                //location.reload();
            })
            .catch(function (error) {
            });
    }
</script>
