@extends('layouts.master')

@section('title')
@endsection

@section('content')
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h4>Acumulados</h4>
			</div>
			<div class="panel-body">
				<table class="table table-hover">
					<thead style="color: white; background-color: #D9534F;">
						<tr>
							<th>Cuenta</th>
							<th>Anual</th>
							<th>Mensual</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Fija</td>
							<td>1000</td>
							<td>1547</td>
						</tr>
						<tr>
							<td>Movil</td>
							<td>1000</td>
							<td>1547</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h4>Acumulados anual</h4>
			</div>
			<div class="panel-body">
				<div id="chartdiv3" style="width: 100%; height: 300px; background-color: #FFFFFF;" ></div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h4>Gráfico Resúmen Fija</h4>
			</div>
			<div class="panel-body">
				<div id="chartdiv" style="height: 200px;" ></div>
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<h4>Gráfico Resúmen Movil</h4>
			</div>
			<div class="panel-body">
				<div id="chartdiv2" style="height: 200px;" ></div>
			</div>
		</div>
	</div>
	<div id="chartdiv3" style="height: 200px;" ></div>
</div>
@endsection

@section('file-style')
<script src="js/dashboard-chart-init.js"></script>
@endsection
