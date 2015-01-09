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
				<h4>Detalle Despachos</h4>
			</div>            
			<div class="panel-body">
				<strong>{{ isset($time) ? $time : ''  }}</strong>
				<div class="table-responsive">
					<table class="table table-hover">
						<thead>
							@foreach($sql as $key => $value)
							<th>{{ $key }}</th>
							@endforeach
						</thead>
						<tbody>
							<tr>
								@foreach($sql as $key => $value)
								<td>{{ $value }}</td>
								@endforeach
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('file-style')
@endsection

@section('text-style')
<style>
</style>
@endsection

@section('file-script')
@endsection

@section('text-script')
<script>
</script>
@endsection
