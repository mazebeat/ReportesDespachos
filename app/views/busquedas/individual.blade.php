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
                    {{ Form::label('negocio', 'Negocio', array('class' => 'control-label ')) }}
                    {{ Form::select('negocio', array('fija' => 'Fija',  'movil' => 'Movil' ), null, array('class' => 'form-control'))  }}
                </div>
                <div class="col-md-2">
                    {{ Form::label('cuenta', 'Cuenta', array('class' => 'control-label')) }}
                    <input type="text" value="">
                </div>
                <div class="col-md-2">
                    {{ Form::label('tipos', 'Tipo Documento', array('class' => 'control-label')) }}
                    {{ Form::select('tipos', array('1' => 'Boleta',  '13' => 'Factura', '20' => 'Nota de credito' ), null, array('class' => 'form-control'))  }}
                </div>
                 <div class="col-md-2">
                    {{ Form::label('cuenta', 'Folio', array('class' => 'control-label')) }}
                    <input type="text" value="">
                </div>
                 <div class="col-md-2">
                    {{ Form::label('cuenta', 'Correo', array('class' => 'control-label')) }}
                    <input type="text" value="">
                </div>
                <div class="col-md-2" style="margin-top: 24px;">
                    <button type="button" class="btn btn-default">Consultar</button>
                    <button type="button" class="btn btn-default">Limpiar</button>
                </div>
                {{ Form::close() }}   
                <div class="clearfix"></div>      
            </div>            
            <div class="panel-body">               
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
