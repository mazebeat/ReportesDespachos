<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
				<span class="icon-bar"></span> <span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.html"> </a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="{{ HTML::activeLink('admin') }}">
					<a href="{{ URL::to('admin') }}"><i class="fa fa-home fa-fw"></i> Inicio</a></li>
				<li class="dropdown {{ HTML::activeState(array('admin/resumen/despachos', 'admin/resumen/emessaging')) }}">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-list-ul fa-fw"></i> Resumen
						<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="{{ URL::to('admin/resumen/despachos') }}">Resumen Despacho</a></li>
						<!-- <li><a href="{{ URL::to('admin/resumen/emessaging') }}">Resumen Emessaging</a></li> -->
					</ul>
				</li>
				<li class="dropdown {{ HTML::activeState(array('admin/busquedas/individual')) }}">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-search fa-fw"></i> Busquedas
						<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="{{ URL::to('admin/busquedas/individual') }}">Busqueda invididual</a></li>
					</ul>
				</li>
				<li class="dropdown {{ HTML::activeState(array('admin/reportes/reporte', 'admin/reportes/estadodespachos')) }}">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-file-text-o fa-fw"></i> Reportes
						<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="{{ URL::to('admin/reportes/reporte') }}">Reporte</a></li>
						<li><a href="{{ URL::to('admin/reportes/estadodespachos') }}">Estado Despachos</a></li>
					</ul>
				</li>

				@if(Auth::check() && Auth::user()->perfil == 'ADM')
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog fa-fw"></i> Administración
							<b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="{{ URL::to('dashboard/administracion/cambiopass') }}">Cambio contraseñas</a>
							</li>
							<li>
								<a href="{{ URL::to('dashboard/administracion/usuarios ') }}">Administración usuarios</a>
							</li>
						</ul>
					</li>
				@endif
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<i class="fa fa-user fa-fw"></i> {{ Str::upper(Auth::user()->nombre)  }}
						<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="{{ URL::to('logout') }}">Salir</a></li>
					</ul>
				</li>
				<li>
					<a href="#" id="helpPopover" type="button" class="" data-toggle="popover">
						<i class="fa fa-question"></i> </a>
				</li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container-fluid -->
</nav>
