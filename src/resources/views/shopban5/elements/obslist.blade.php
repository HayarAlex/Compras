 <div class="box box-default" id="app-list">
    <div class="box-header with-border">
        <i class="fa fa-list"></i>
        <h3 class="box-title">Detalle de Proveedores</h3>
    </div>
    <div class="box-body">
        <table id="dt-list" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th width="5%" class="text-center no-padding">CODIGO</th>
                <th width="15%" class="text-center no-padding">DESCRIPCIÓN</th>
                <th width="15%" class="text-center no-padding">OBS CALIDAD</th>
                <th width="15%" class="text-center no-padding">OBS REG SAN</th>
                <th width="15%" class="text-center no-padding">OBS LOGISTICA</th>
                <th width="15%" class="text-center no-padding">OBS INV DES</th>
                <th width="10%" class="text-center no-padding">N° DOCUMENTOS</th>
                <th width="10%"></th>
            </tr>
            </thead>
            <tbody>
                <tr is="row-item" v-for="item in lists" :key="item.iddetsh" :item.sync="item"></tr>
            </tbody>
        </table>
    </div>

    {{--<pre>@{{ $data }}</pre>--}}
</div>
@include('compras::shopban5.elements.templates.row-itemo')
@include('compras::shopban2.elements.templates.modaltipo')
@include('compras::shopban2.elements.templates.modaldocprov')

<script>
    var listtable;
    var vm;
    var totalBuy = 0;

    function loadTable() {
        listtable = $('#dt-list').DataTable({
            ordering: false,
            paging: false,
            scrollY: 250,
            dom: 'lrtip',
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json",
            }
        });
    }

    function destroyTable() {
        listtable.destroy();
    }

    $(document).ready(function () {
        
        Vue.component("row-item", {
            template: "#tmpl-rows",
            props: ['item','iosl'],
            data: function () {
                return {
                    editing: false,
                    errors: [],
                    draft: {}
                }
            },
            methods: {
                edit: function () {
                    this.draft   = JSON.parse(JSON.stringify(this.item));
                    this.editing = true;
                },
                cancel: function () {
                    this.editing = false;
                },
                update: function () {
                    var vms = this;
                    destroyTable();
                    axios.put('/compras/shopbtwo', this.draft)
                        .then(function (response) {
                            
                            toastrSuccess();
                            location.reload();
                        })
                        .catch(function (error) {
                            toastrWarning(error);
                        })
                        .then(function(){
                            loadTable();
                        });
                },
                remove: function () {
                    var vm = this;
                    destroyTable();
                    axios.delete('/compras/tender'+vm.item.idli)
                        .then(function (response) {
                            var removed = vm.$parent.lists.indexOf(vm.item);
                            vm.$parent.lists.splice(removed, 1);
                            toastrSuccess();
                        })
                        .catch(function (error) {
                            toastrWarning(error);
                        })
                        .then(function(){
                            loadTable();
                        });
                }
            }
        });

        // main function
        vm = new Vue({
            el: '#app-list',
            data: {
                lists: [],
                units: []
            },
            methods: {
                getData: function() {
                    axios.get('/compras/shopbtwo/provdet/{{ $id }}')
                        .then(function (response) {
                            vm.lists = response.data.data;
                            var dataprov = [];
                            dataprov = response.data.data;
                            //console.log(vm.lists);
                            
                        })
                        .then(function () {
                            loadTable();
                        });
                }
            },

            mounted: function () {
                this.getData();
            },
        });

    });
    function changestate(){

    }
    function showModalList(folder){
        $('#mdl-list-table').modal('show');
    }
    $(document).on("click", "a.obsrev", function () {
        var codigo = $(this).attr("data-ida");
        console.log(codigo);
        destroyTable();
        axios.put('/compras/shopbfive/obsrev/'+codigo)
            .then(function (response) {
                
                toastrSuccess();
                location.reload();
            })
            .catch(function (error) {
                toastrWarning(error);
            })
            .then(function(){
                loadTable();
            });
    });

</script>