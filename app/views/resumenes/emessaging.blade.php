@extends('layouts.master')

@section('title')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-danger">
            <div class="panel-heading">
                {{ Form::open(array()) }}
                <div class="col-md-2">
                    {{ Form::label('negocio', 'Tipo/Negocio', array('class' => 'control-label ')) }}
                    {{ Form::select('negocio', array('df' => 'Envio Despacho Fija',  'dm' => 'Envio Despacho Movil', 'edm' => 'No-Ciclo', 'ref' => 'Re-Envios ', 'rem' => 'Re-Despacho' ), null, array('class' => 'form-control'))  }}
                </div>
                <div class="col-md-3">
                    {{ Form::label('fecha', 'Fecha Desde', array('class' => 'control-label')) }}
                    <input type="text" value="" size="16" data-date-minviewmode="months" data-date-viewmode="years" da-date-formaatt="mm/yyyy" class="form-control form-control-inline input-medium default-date-picker">
                </div>
                <div class="col-md-3">
                    {{ Form::label('fecha', 'Fecha Hasta', array('class' => 'control-label')) }}
                    <input type="text" value="" size="16" data-date-minviewmode="months" data-date-viewmode="years" da-date-formaatt="mm/yyyy" class="form-control form-control-inline input-medium default-date-picker">
                </div>
                <div class="col-md-1" style="margin-top: 24px;">
                    {{ Form::label('consultar', 'Consultar', array('class' => 'control-label sr-only' )) }}
                    <button type="button" class="btn btn-default">Consultar</button>
                </div>
                {{ Form::close() }}
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <table class="table table-hover table-responsive">
                    <thead>
                        <th>Profile Name</th>
                        <th>Temporary Delivery Failure</th>
                        <th>Content Failure</th>
                        <th>Permanent Delivery Failure</th>
                        <th>Unknown Delivery Failure</th>
                        <th>Replied To</th>
                        <th>Opened/Clicked Through</th>
                        <th>Out of Office Replies</th>
                        <th>Total Messages Sent</th>
                    </thead>
                    <tbody>                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('file-style')
{{ HTML::style('js/bootstrap-datepicker/css/datepicker-custom.css') }}
{{ HTML::style('js/bootstrap-timepicker/css/timepicker.css') }}
{{ HTML::style('js/bootstrap-colorpicker/css/colorpicker.css') }}
{{ HTML::style('js/bootstrap-daterangepicker/daterangepicker-bs3.css') }}
{{ HTML::style('js/bootstrap-datetimepicker/css/datetimepicker-custom.css') }}
@endsection

@section('text-style')
<style>
</style>
@endsection

@section('file-script')
<!--pickers plugins-->
{{ HTML::script('js/bootstrap-datepicker/js/bootstrap-datepicker.js') }}
{{ HTML::script('js/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}
{{ HTML::script('js/bootstrap-daterangepicker/moment.min.js') }}
{{ HTML::script('js/bootstrap-daterangepicker/daterangepicker.js') }}
{{ HTML::script('js/bootstrap-colorpicker/js/bootstrap-colorpicker.js') }}
{{ HTML::script('js/bootstrap-timepicker/js/bootstrap-timepicker.js') }}

<!--pickers initialization-->
{{ HTML::script('js/pickers-init.js') }}
@endsection

@section('text-script')
<script>
</script>
@endsection
