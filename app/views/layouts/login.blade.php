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

	{{ HTML::style('css/style.css') }}
	{{ HTML::style('css/style-responsive.css') }}

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	{{ HTML::script('js/html5shiv.js') }}
	{{ HTML::script('js/respond.min.js') }}
	<![endif]-->
</head>

<body class="login-body">

	<div class="container">
		@yield('content')
	</div>

	{{ HTML::script('js/jquery-1.10.2.min.js') }}
	{{ HTML::script('js/bootstrap.min.js') }}'
	{{ HTML::script('js/modernizr.min.js') }}

</body>
</html>
