@extends('layouts.master')

@section('title')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
      @if(isset($message) && $message != '' && isset($sql) && !count($sql))
      <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Atención! </strong> {{ $message }}
    </div>
    @endif
    <div class="panel panel-danger">
        <div class="panel-heading">
            {{ Form::open(array('role' => 'form')) }}
            <div class="row">
                <div class="form-group col-xs-4 col-md-2">
                    {{ Form::label('negocio', 'Negocio (*)', array('class' => 'control-label ')) }}
                    {{ Form::select('negocio', array('' => '', 'fija' => 'Fija',  'movil' => 'Movil' ), Input::old('negocio'), array('class' => 'form-control'))  }}
                    <small class="help-block">{{ $errors->first('negocio') }}</small>
                </div>
                <div class="form-group col-xs-4 col-md-2">
                    {{ Form::label('cuenta', 'Cuenta', array('class' => 'control-label')) }}
                    <input type="text" name="cuenta" value="{{ Input::old('cuenta') }}" class="form-control" autocomplete="off">
                    <small class="help-block">{{ $errors->first('cuenta') }}</small>
                </div>
                <div class="form-group col-xs-4 col-md-2">
                    {{ Form::label('tipodoc', 'Tipo Documento', array('class' => 'control-label')) }}
                    {{ Form::select('tipodoc', array('' => '', '1' => 'Boleta',  '13' => 'Factura', '20' => 'Nota de credito' ), Input::old('tipos'), array('class' => 'form-control'))  }}
                    <small class="help-block">{{ $errors->first('tipodoc') }}</small>
                </div>
                <div class="form-group col-xs-4 col-md-2">
                    {{ Form::label('folio', 'Folio', array('class' => 'control-label')) }}
                    <input type="text" name="folio" value="{{ Input::old('folio') }}" class="form-control" autocomplete="off">
                    <small class="help-block">{{ $errors->first('folio') }}</small>
                </div>
                <div class="form-group col-xs-4 col-md-2">
                    {{ Form::label('correo', 'Correo', array('class' => 'control-label')) }}
                    <input type="text" name="correo" value="{{ Input::old('correo') }}" class="form-control" autocomplete="off">
                    <small class="help-block">{{ $errors->first('correo') }}</small>
                </div>
                <div class="form-group col-xs-4 col-md-2" style="margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">Consultar</button>
                    <button type="button" class="btn btn-default">Limpiar</button>
                </div>
            </div>
            {{ Form::close() }}   
        </div>
        @if(isset($sql) && count($sql))
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <th>Cuenta</th>
                        <th>Numero Ciclo</th>
                        <th>Tipo Documento</th>
                        <th>Folio</th>
                        <th>Fecha Emisión</th>
                        <th>Fecha Vencimiento</th>
                        <th>Correo</th>
                        <th>Fecha Envío</th>
                        <th>Fecha Lectura</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                    </thead>
                    <tbody>
                        @foreach($sql as $key => $value)
                        <tr>
                            <td>{{ $value->cuenta }}</td>
                            <td>{{ $value->numerociclo }}</td>
                            <td>{{ $value->tipodoc }}</td>
                            <td>{{ $value->folio }}</td>
                            <td>{{ $value->fechaemi }}</td>
                            <td>{{ $value->fechaven }}</td>
                            <td>{{ $value->mail }}</td>
                            <td>{{ $value->fecenvio }}</td>
                            <td>{{ $value->fechalectura }}</td>
                            <td>{{ $value->estadoenvio }}</td>
                            <td>{{ $value->observaciones }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
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
