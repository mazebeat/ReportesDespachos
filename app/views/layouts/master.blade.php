<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="description" content="Aplicación Reportes Despachos">
	<meta name="author" content="Intelidata"
	<link rel="shortcut icon" href="#" type="image/png">

	<title>@yield('title')</title>

	@yield('file-style')

    {{ HTML::style('css/style.css') }}
	{{ HTML::style('css/style-responive.css') }}

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	{{  HTML::script('js/html5shiv.js') }}
	{{  HTML::script('js/respond.min.js') }}
	<![endif]-->
</head>

<body class="horizontal-menu-page">

	<section>

		<div class="wrapper-top">
			<div class="row">
				<div class="col-md-2">
					{{ HTML::image('images/login-logo.png', 'Intelidata', array('class' => 'img-responsive', 'style' => 'margin-top: 20px')) }}
				</div>
				<div class="col-md-8">
					<h2 class="text-center">Reportes Despacho</h2>
				</div>
				<div class="col-md-2 pull-right">
					{{ HTML::image('http://madrynsite.com.ar/wp-content/uploads/2013/04/Logo_Telefonica_Movistar1.jpg', 'Intelidata', array('class' => 'img-responsive pull-right', 'style' => 'height: 81px;')) }}
				</div>
			</div>
		</div>

		@include('layouts.master_modules.menu')

		<div class="wrapper">
			@yield('content')
		</div>

		<footer class="sticky-footer">
			@include('layouts.master_modules.footer')
		</footer>

	</section>

	{{ HTML::script('js/jquery-1.10.2.min.js') }}
	{{ HTML::script('js/jquery-ui-1.9.2.custom.min.js') }}
	{{ HTML::script('js/jquery-migrate-1.2.1.min.js') }}
	{{ HTML::script('js/bootstrap.min.js') }}
	{{ HTML::script('js/modernizr.min.js') }}
	{{ HTML::script('js/jquery.nicescroll.js') }}

    <!-- CHARTS -->
    {{ HTML::script('js/amcharts/amcharts.js') }}
    {{ HTML::script('http://www.amcharts.com/lib/3/pie.js') }}
    {{ HTML::script('http://www.amcharts.com/lib/3/serial.js') }}
    {{ HTML::script('http://www.amcharts.com/lib/3/exporting/amexport_combined.js') }}
    {{ HTML::script('js/amcharts/lang/es.js') }}

	@yield('file-script')

	{{ HTML::script('js/scripts.js') }}

</body>
</html>
