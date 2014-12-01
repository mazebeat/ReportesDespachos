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
                    {{ Form::label('negocio', 'Tipo/Negocio (*)', array('class' => 'control-label ')) }}
                    {{ Form::select('negocio', array('' => '', 'Envio_DespachoFija' => 'Envio Despacho Fija',  'Envio_DespachoMovil' => 'Envio Despacho Movil', 'No-Ciclo' => 'No-Ciclo', 'Re-Envios' => 'Re-Envios', 'Re-Despacho' => 'Re-Despacho' ), Input::old('negocio'), array('class' => 'form-control'))  }}
                    <small class="help-block">{{ $errors->first('negocio') }}</small>
                </div>
                <div class="custom-date-range" data-date-format="dd/mm/yyyy">
                    <div class="form-group col-xs-3 col-md-3">
                        {{ Form::label('fecha', 'Fecha Desde (*)', array('class' => 'control-label')) }}
                        <input type="text" name="fecha_desde" value="{{ Input::old('fecha_desde') }}" size="12" data-date-format="yyyy-mm-dd" class="form-control form-control-inline input-medium dpd1" autocomplete='off'>
                        <small class="help-block">{{ $errors->first('fecha_desde') }}</small>
                    </div>
                    <div class="form-group col-xs-3 col-md-3">
                        {{ Form::label('fecha', 'Fecha Hasta (*)', array('class' => 'control-label')) }}
                        <input type="text" name="fecha_hasta" value="{{ Input::old('fecha_hasta') }}" size="12" data-date-format="yyyy-mm-dd" class="form-control form-control-inline input-medium dpd2" autocomplete='off'>
                        <small class="help-block">{{ $errors->first('fecha_hasta') }}</small>
                    </div>
                </div>
                <div class="col-xs-1 col-md-1" style="margin-top: 24px;">
                    {{ Form::label('consultar', 'Consultar', array('class' => 'control-label sr-only' )) }}
                    <button type="submit" class="btn btn-primary ladda-button" data-style="zoom-in">Consultar</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
        @if(isset($sql) && count($sql))
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover">
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
                        @foreach($sql as $key => $value)
                        <tr>
                            <td>{{ $value->name }}</td>
                            <td>{{ $value->tempFailure }}</td>
                            <td>{{ $value->contentFailure }}</td>
                            <td>{{ $value->permFailure }}</td>
                            <td>{{ $value->unkFailure }}</td>
                            <td>{{ $value->multreplied }}</td>
                            <td>{{ $value->opened }}</td>
                            <td>{{ $value->outOfOffice }}</td>
                            <td>{{ $value->total }}</td>
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
{{ HTML::style('js/bootstrap-datepicker/css/datepicker.css') }}
{{ HTML::style('js/bootstrap-datepicker/css/datepicker-custom.css') }}
@endsection

@section('text-style')
<style>
</style>
@endsection

@section('file-script')
<!--pickers plugins-->
{{ HTML::script('js/bootstrap-datepicker/js/bootstrap-datepicker.js') }}
{{ HTML::script('js/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js', array('charset' => 'UTF-8')) }}
{{ HTML::script('js/bootstrap-daterangepicker/moment.min.js') }}

<!--pickers initialization-->
{{ HTML::script('js/pickers-init.js') }}
@endsection

@section('text-script')
<script>
    Ladda.bind('button');
</script>
@endsection
