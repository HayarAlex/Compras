<div class="box box-default">
    <div class="box-body">
        <div class="clearfix">

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li><a href="#tab-transitory" data-toggle="tab">Observados</a></li>
                    <li class="active"><a href="#tab-pending" data-toggle="tab">Asignacion</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab-pending">
                        @include('compras::shopban5.elements.units')
                    </div>

                    <div class="tab-pane" id="tab-transitory">
                        @include('compras::shopban5.elements.obsarea')
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var currentTab = $(e.target).attr("href");
            switch (currentTab) {
                case '#tab-pending' :
                    units.ajax.reload();
                    units.columns.adjust().draw();
                    break;
                case '#tab-transitory' :
                    obser.ajax.url('/compras/shopbfive/listobsa').load();
                    obser.columns.adjust().draw();
                    break;
            }
        });
    });

</script>
