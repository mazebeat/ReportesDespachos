@extends('layouts.master')

@section('title')
@endsection

@section('content')
	<div ng-controller="graphsController">

		<section class="panel">
			<header class="panel-heading custom-tab dark-tab">
				<ul class="nav nav-tabs">
					<li class="active">
						<a data-toggle="tab" href="#acumulados">Acumulados</a>
					</li>
					<li class="">
						<a data-toggle="tab" href="#resumen">Resumenes</a>
					</li>
				</ul>
			</header>
			<div class="panel-body">
				<div class="tab-content">
					<div id="acumulados" class="tab-pane active">
						<div class="col-md-6">
							<table class="table table-hover">
								<thead style="color: white; background-color: #E70D2F;">
								<tr>
									<th>Cuenta</th>
									<th>Anual</th>
									<th>Mensual</th>
								</tr>
								</thead>
								<tbody>
								<tr>
									<td>Fija</td>
									<td>@{{ anualfija }}</td>
									<td>@{{ mensualfija }}</td>
								</tr>
								<tr>
									<td>Movil</td>
									<td>@{{ anualmovil }}</td>
									<td>@{{ mensualmovil }}</td>
								</tr>
								</tbody>
							</table>
						</div>
						<div class="col-md-6">
							{{-- Loading directive --}}
							<loading ng-hide="gAnual.length > 0"></loading>
							<div id="gAnual" style="height: 400px;"></div>
						</div>
					</div>
					<div id="resumen" class="tab-pane">
						<div class="col-md-6">
							<h4 class="text-center">Gráfico Resúmen Fija - {{ App\Util\Functions::convNumberToMonth(Carbon::now()->month)  }}</h4>
							{{-- Loading directive --}}
							<loading ng-hide="gMensualFija.length > 0"></loading>
							<div id="gMensualFija" style="height: 400px;"></div>
						</div>
						<div class="col-md-6">
							<h4 class="text-center">Gráfico Resúmen Movil - {{ App\Util\Functions::convNumberToMonth(Carbon::now()->month)  }}</h4>
							<loading ng-hide="gMensualMovil.length > 0"></loading>
							<div id="gMensualMovil" style="height: 400px;"></div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
@endsection

@section('file-style')
	{{--{{ HTML::script('js/dashboard-chart-init.js') }}--}}
	<!-- CHARTS -->
	{{ HTML::script('js/amcharts/amcharts.js') }}
	{{ HTML::script('js/amcharts/pie.js') }}
	{{ HTML::script('js/amcharts/serial.js') }}
	{{ HTML::script('js/amcharts/exporting/amexport_combined.js') }}
	{{ HTML::script('js/amcharts/lang/es.js') }}
@endsection

@section('text-script')
	<script>
		var chartMensualFija = new AmCharts.AmPieChart();
		var chartMensualMovil = new AmCharts.AmPieChart();

		$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
			var news = $(e.target);
			var olds = $(e.relatedTarget);

			if (news.attr('href') == '#resumen') {
				chartMensualFija.validateNow();
				chartMensualMovil.validateNow();
			}
		});
	</script>
@endsection
