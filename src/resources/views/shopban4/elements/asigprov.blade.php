@extends('adminlte.fragment')
@section('style')
    {!! Html::style('bower/select2/dist/css/select2.min.css')!!}
    {!! Html::style('bower/datatables.net-dt/css/jquery.dataTables.min.css')!!}

    {!! Html::style('https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css')!!}
    {!! Html::style('bower/datatables.net-fixedcolumns-dt/css/fixedColumns.dataTables.min.css') !!}
@endsection

@section('script')
    {!! Html::script('bower/axios/dist/axios.min.js') !!}
    {!! Html::script('bower/select2/dist/js/select2.min.js') !!}
    {!! Html::script('bower/select2/dist/js/i18n/es.js') !!}

    {!! Html::script('bower/lodash/dist/lodash.min.js') !!}
    {!! Html::script('bower/vue/dist/vue.js') !!}
    {!! Html::script('bower/datatables.net/js/jquery.dataTables.min.js') !!}



    {!! Html::script('bower/jquery-cascading-dropdown/dist/jquery.cascadingdropdown.min.js') !!}
    {!! Html::script('https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js') !!}
    {!! Html::script('bower/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js') !!}
    {!! Html::script('bower/datatables.net-select/js/dataTables.select.min.js') !!}
@endsection

@section('content')
    <h2 class="page-header">Pendientes de revisión por Logistica</h2>

    <div id="app" class="row">
        <div class="col-md-7">
            @include('compras::shopban4.elements.iteminfo')
        </div>
        <div class="col-md-4">
            @include('compras::shopban4.elements.itemsai')
        </div>
    </div>
    <div id="app" class="row">
        <div class="col-md-11">
            @include('compras::shopban4.elements.itemreg')
        </div>
    </div>
@endsection
