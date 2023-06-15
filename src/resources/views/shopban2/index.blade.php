@extends('adminlte.fragment')
@section('style')
    {!! Html::style('bower/datatables.net-dt/css/jquery.dataTables.min.css') !!}
    {!! Html::style('bower/datatables.net-fixedcolumns-dt/css/fixedColumns.dataTables.min.css') !!}
    {!! Html::style('bower/datatables.net-buttons-dt/css/buttons.dataTables.min.css') !!}
@endsection

@section('script')
    {!! Html::script('bower/datatables.net/js/jquery.dataTables.min.js') !!}
    {!! Html::script('bower/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js') !!}
    {!! Html::script('bower/datatables.net-buttons/js/dataTables.buttons.min.js') !!}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') !!}
    {!! Html::script('bower/datatables.net-buttons/js/buttons.html5.min.js') !!}
@endsection

@section('content')
    <h2 class="page-header">Bandeja de Pedidos Consultados - Compras MAC</h2>

    <div id="app" class="row">

        <div class="col-md-10">
            @include("compras::shopban2.elements.navtabs")
        </div>
    </div>
@endsection
