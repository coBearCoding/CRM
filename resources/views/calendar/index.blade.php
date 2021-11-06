@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
@stop

@section('js')

@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-config icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Gestión
            <div class="page-title-subheading">Calendario
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="main-card mb-3 card">
        <div class="card-body">
            <div id="calendar-bg-events"></div>
        </div>
    </div>

@stop






