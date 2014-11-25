@extends('layouts.master')

@section('title')
@endsection

@section('page-title')
<i class="fa fa-folder"></i> ...<span>Gestor Documental...</span>
@endsection

@section('breakcrumb')
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
                <div class="col-md-3">
                    {{ Form::label('fecha', 'Fecha', array('class' => 'control-label')) }}
                    <input type="text" value="" size="16" data-date-minviewmode="months" data-date-viewmode="years" da-date-formaatt="mm/yyyy" class="form-control form-control-inline input-medium default-date-picker">
                </div>
                <div class="col-md-2">
                    {{ Form::label('ciclos', 'Ciclos', array('class' => 'control-label')) }}
                    {{ Form::select('ciclos', array('1' => '1',  '13' => '13', '20' => '20' ), null, array('class' => 'form-control'))  }}
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
                        <th>Negocio</th>
                        <th>Mes</th>
                        <th>Ciclo</th>
                        <th>Tipo Documento</th>
                        <th>Total Envios</th>
                        <th>Total Rebotes</th>
                        <th>Total Leído</th>                        
                    </thead>
                    <tbody>
                        <tr>
                            <td>Movil</td>
                            <td>11/2014</td>
                            <td>11114</td>
                            <td>23</td>
                            <td>3246</td>
                            <td>56345</td>
                            <td>7852</td>
                        </tr>
                        <tr>
                            <td>Movil</td>
                            <td>10/2014</td>
                            <td>11114</td>
                            <td>1</td>
                            <td>74</td>
                            <td>8</td>
                            <td>68</td>
                        </tr>
                        <tr>
                            <td>Movil</td>
                            <td>09/2014</td>
                            <td>11114</td>
                            <td>12</td>
                            <td>2546</td>
                            <td>157</td>
                            <td>2145</td>
                        </tr>
                        <tr>
                            <td>Movil</td>
                            <td>08/2014</td>
                            <td>11114</td>
                            <td>23</td>
                            <td>628</td>
                            <td>272</td>
                            <td>5</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                        	<td></td>
                        	<td></td>
                        	<td></td>
                        	<td></td>
                        	<td>78545</td>
                        	<td>56478</td>
                        	<td>789654</td>
                        </tr>
                    </tfoot>
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
