@extends('layouts.master')

@section('title')
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		@if(isset($message) && count($message))
		<div class="alert alert-warning alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<strong>Atención! </strong><br>
			@foreach($message as $key => $message)
			{{ $message }}
			@endforeach
		</div>
		@endif
		<div class="panel panel-danger">
			<div class="panel-heading">
				{{ Form::open(array('role' => 'form')) }}
				<div class="row">
					<div class="form-group col-xs-4 col-md-2 col-lg-2">
						{{ Form::label('negocio', 'Tipo/Negocio (*)', array('class' => 'control-label ')) }}
						{{ Form::select('negocio', array('' => '', 'Despacho Fija' => 'Despacho Fija',  'Despacho Movil' => 'Despacho Movil', 'Re-Despacho' => 'Re-Despacho', 'Re-Envio Fija' => 'Re-Envio Fija', 'Re-Envio Movil' => 'Re-Envio Movil' ), Input::old('negocio'), array('class' => 'form-control negocio2'))  }}
						<small class="help-block">{{ $errors->first('negocio') }}</small>
					</div>
					<div class="form-group col-xs-3 col-md-3 col-lg-3">
						{{ Form::label('fecha', 'Fecha (*)', array('class' => 'control-label')) }}
						<input type="text" name="fecha" value="{{ Input::old('fecha') }}" size="16" data-date-minviewmode="months" data-date-viewmode="years" da-date-formaatt="yyyy-mm" class="form-control form-control-inline input-medium default-date-picker" autocomplete='off'>
						<small class="help-block">{{ $errors->first('fecha') }}</small>
					</div>
					<div class="form-group col-xs-2 col-md-2 col-lg-2">
						{{ Form::label('ciclo', 'ciclo (*)', array('class' => 'control-label')) }}
						{{ Form::select('ciclo', array(), Input::old('ciclo'), array('class' => 'form-control ciclo2', 'disabled', 'autocomplete'=>'off'))  }}
						{{--{{ Form::select('ciclo', array(), Input::old('ciclo'), array('class' => 'form-control ciclo2', 'autocomplete'=>'off'))  }}--}}
						<small class="help-block">{{ $errors->first('ciclo') }}</small>
					</div>
					<div class="form-group col-xs-1 col-md-1 col-lg-1" style="margin-top: 24px;">
						{{ Form::label('consultar', 'Consultar', array('class' => 'control-label sr-only' )) }}
						<button type="submit" class="btn btn-primary ladda-button" data-style="zoom-in">
							Consultar
						</button>
					</div>
				</div>
				{{ Form::close() }}
			</div>
			@if(isset($files) && count($files))
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							<th>Documento</th>
							<th></th>
						</thead>
						<tbody>
							@foreach($files as $key => $value)
							<tr>
								<td>{{ basename($value)  }}</td>
								<td><a href="{{ url('download?path=' . public_path() . '/reportes/' . Auth::user()->idUsuario . '/' . basename($value))  }}" class="btn btn-primary pull-right"><i class="fa fa-download fa-fw"></i> Descargar</a></td>
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

	var ciclo_fija = [{'0001': '0001', '0004': '0004', '0008': '0008'}];
	var ciclo_movil = [{'1': '1', '13': '13', '20': '20'}];

	var data = [];
	var complete = function () {
		if ($('.negocio2').val() != '' && $('.ciclo2').val() == null) {
			$('.ciclo2').empty();
			var value = $('.negocio2').val();
			if (value == '' || value == null) {
				$('.ciclo2').empty().prop('disabled', 'disabled');
				data = [];
			} else {

				if (value.toLowerCase().indexOf('despacho')!= -1 && value.toLowerCase().indexOf('fija') != -1) {
					data = ciclo_fija;
				}

				if (value.toLowerCase().indexOf('despacho') != -1 && value.toLowerCase().indexOf('movil') != -1) {
					data = ciclo_movil;
				}

				if (data.length > 0) {
					$('.ciclo2').append($("<option value=\"\"></option>"));
					$.each(data[0], function (key, value) {
						$('.ciclo2').append($("<option value=\"" + key + "\">" + value + "</option>"));
					});
					$('.ciclo2').removeAttr('disabled');
					data = [];
				} else {
					$('.ciclo2').empty().prop('disabled', 'disabled');
				}
			}
		}
	};

	complete();

	$('.negocio2').on('change', function (event) {
		$('.ciclo2').empty();
		var value = $(this).val();
		if (value == '' || value == null) {
			$('.ciclo2').empty().prop('disabled', 'disabled');
			data = [];
		} else {

			if (value.toLowerCase().indexOf('despacho')!= -1 && value.toLowerCase().indexOf('fija') != -1) {
				data = ciclo_fija;
			}

			if (value.toLowerCase().indexOf('despacho') != -1 && value.toLowerCase().indexOf('movil') != -1) {
				data = ciclo_movil;
			}
			if (data.length > 0) {
				$('.ciclo2').append($("<option value=\"\"></option>"));
				$.each(data[0], function (key, value) {
					$('.ciclo2').append($("<option value=\"" + key + "\">" + value + "</option>"));
				});
				$('.ciclo2').removeAttr('disabled');
				data = [];
			} else {
				$('.ciclo2').empty().prop('disabled', 'disabled');
			}
		}

		event.preventDefault();
	});

</script>
@endsection

