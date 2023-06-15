<div class="box box-default" id="app-list">
    <div class="box-header with-border">
        <i class="fa fa-check-square-o"></i>
        <h3 class="box-title">Proveedores Asignados</h3>
    </div>
    <div class="box-body">
        <table id="dt-list" class="table table-bordered table-striped table-hover">
            <thead>
            <tr>
                <th width="30%" class="text-center no-padding">CODIGO</th>
                <th width="40%" class="text-center no-padding">DESCRIPCIÓN</th>
                <th width="30%" class="text-center no-padding">CONFIRMACION ENVIO CORREO</th>
            </tr>
            </thead>
            <tbody>
                <tr is="row-item" v-for="item in lists" :key="item.idia" :item.sync="item"></tr>
            </tbody>
        </table>
    </div>

    {{--<pre>@{{ $data }}</pre>--}}
</div>
@include('compras::shopban1.elements.templates.row-item')

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
            props: ['item'],
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
                update: function ($id) {
                    var vms = this;
                    //console.log($id);
                    destroyTable();
                    axios.put('/compras/shopbone/sendpro/'+ $id)
                        .then(function (response) {
                            Vue.set(vms.$parent.lists, vms.$parent.lists.indexOf(vms.item), response.data);
                            vms.editing = false;
                            toastrSuccess('Se registro correctamente');
                            loadTable();
                        })
                        .catch(function (error) {
                            toastrWarning(error);
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
                    axios.get('/compras/shopbone/provdet/{{ $id }}')
                        .then(function (response) {
                            vm.lists = response.data.data;
                            console.log(vm.lists);
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

</script>