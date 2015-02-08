@extends('layouts.master')

@section('title')
@endsection

@section('content')
	<div class="row">
		<div class="col-md-12">
			@if(isset($message) && $message != '' && isset($sql) && !count($sql))
				<div class="alert alert-warning alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert">
						<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
					</button>
					<strong>Atención! </strong> {{ $message }}
				</div>
			@endif
			<div class="panel panel-danger">
				<div class="panel-heading">
					{{ Form::open(array('role' => 'form')) }}
					<div class="row">
						<div class="form-group col-xs-4 col-md-2">
							{{ Form::label('negocio', 'Tipo/Negocio (*)', array('class' => 'control-label ')) }}
							{{--                            {{ Form::select('negocio', array('' => '', 'Envio_DespachoFija' => 'Envio Despacho Fija',  'Envio_DespachoMovil' => 'Envio Despacho Movil', 'No-Ciclo' => 'No-Ciclo', 'Re-Envios' => 'Re-Envios', 'Re-Despacho' => 'Re-Despacho' ), Input::old('negocio'), array('class' => 'form-control'))  }}--}}
							{{ Form::select('negocio', array('' => '', 'Envio_DespachoFija' => 'Envio Despacho Fija',  'Envio_DespachoMovil' => 'Envio Despacho Movil', 'NoCiclo' => 'No-Ciclo', 'Re-Envios' => 'Reenvios', 'Redespacho' => 'Re-Despacho' ), Input::old('negocio'), array('class' => 'form-control'))  }}
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
							<button type="submit" class="btn btn-primary ladda-button" data-style="zoom-in">Consultar
							</button>
						</div>
					</div>
					{{ Form::close() }}
				</div>
				@if(isset($sql) && count($sql))
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-hover table-condensed" id="sum_table">
								<thead>
								<th style="width: 16%">Profile Name</th>
								<th style="width: 10.5%">Temporary Delivery Failure</th>
								<th style="width: 10.5%">Content Failure</th>
								<th style="width: 10.5%">Permanent Delivery Failure</th>
								<th style="width: 10.5%">Unknown Delivery Failure</th>
								<th style="width: 10.5%">Replied To</th>
								<th style="width: 10.5%">Opened/Clicked Through</th>
								<th style="width: 10.5%">Out of Office Replies</th>
								<th style="width: 10.5%">Total Messages Sent</th>
								</thead>
								<tbody>
								@foreach($sql as $key => $value)
									<tr>
										<td>{{ $value->name }}</td>
										<td class="text-right">{{ $value->tempFailure }}</td>
										<td class="text-right">{{ $value->contentFailure }}</td>
										<td class="text-right">{{ $value->permFailure }}</td>
										<td class="text-right">{{ $value->unkFailure }}</td>
										<td class="text-right">{{ $value->multreplied }}</td>
										<td class="text-right">{{ $value->opened }}</td>
										<td class="text-right">{{ $value->outOfOffice }}</td>
										<td class="text-right">{{ $value->total }}</td>
									</tr>
								@endforeach
								</tbody>
								<tfoot>
								<tr class="summary warning">
									<td>TOTAL</td>
									<td class="total"></td>
									<td class="total"></td>
									<td class="total"></td>
									<td class="total"></td>
									<td class="total"></td>
									<td class="total"></td>
									<td class="total"></td>
									<td class="total"></td>
								</tr>
								</tfoot>
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
		.table {
			table-layout: fixed;
		}

		.summary td {
			font-weight: bold;
		}

		.summary td:not(:first-child) {
			text-align: right;
		}
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

		$("#sum_table tfoot tr td:not(:first)").text(function (i) {
			var t = 0;
			$(this).parents('table').find('tbody tr').find("td:nth-child(" + (i + 2) + ")").each(function () {
				t += parseInt($(this).text(), 10) || 0;
			});
			return t;
		});
	</script>
@endsection
