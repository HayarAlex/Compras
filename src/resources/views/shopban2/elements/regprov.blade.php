@extends('adminlte.fragment')
@section('style')
    {!! Html::style('bower/select2/dist/css/select2.min.css')!!}
    {!! Html::style('bower/datatables.net-dt/css/jquery.dataTables.min.css') !!}
    {!! Html::script('bower/vue/dist/vue.js') !!}
@endsection

@section('script')
    {!! Html::script('bower/datatables.net/js/jquery.dataTables.min.js') !!}
    {!! Html::script('bower/datatables.net-select/js/dataTables.select.min.js')!!}

    {!! Html::script('bower/select2/dist/js/select2.min.js') !!}
    {!! Html::script('bower/select2/dist/js/i18n/es.js') !!}
@endsection

@section('content')
    <h2 class="page-header">Formulario de Registro Nuevo Proveedor</h2>

    <div id="app" class="row">
        <div class="col-md-3" id="info">
            @include("compras::shopban1.elements.provinfo")

        </div>
        <div class="col-md-4" id="info">
            @include("compras::shopban1.elements.provreg")

        </div>
    </div>
@endsection
