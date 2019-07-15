<!DOCTYPE html>
<html lang="es">
	<head>
		<link rel="stylesheet" type="text/css" href="<?php echo constant('URL'); ?>public/css/main.css">
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?php echo constant('URL'); ?>public/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"/>
		<link href="<?php echo constant('URL'); ?>public/css/angular-growl.min.css" rel="stylesheet" media="screen"/>

		<title>Vestirnos S.A</title>
	</head>
	<body>
		<div growl></div>
		<div id="header">
			<ul>
				<li><a href="<?php echo constant('URL'); ?>main">INICIO</a></li>
        <li class="dropdown" id="multiple">
          <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Proveedores<span class="caret"></span></a>
          <ul class="dropdown-menu center">
            <li><a href="<?php echo constant('URL'); ?>provider?service=true">Contratados</a></li>
            <li><a href="<?php echo constant('URL'); ?>provider?service=false">Retirados</a></li>
          </ul>
        </li>
        <li><a href="<?php echo constant('URL'); ?>rawmaterial">Materia Prima</a></li>
        <li><a href="<?php echo constant('URL'); ?>garment">Prendas</a></li>
        <li><a href="<?php echo constant('URL'); ?>client">Clientes</a></li>
        <li><a href="<?php echo constant('URL'); ?>reports">Reportes</a></li>
				<li class="close-session" ><a href="<?php echo constant('URL'); ?>logout">Cerrar Sesión</a></li>
			</ul>
		</div>

		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.js"></script>
		<script src="<?php echo constant('URL'); ?>js/angular-growl.min.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-animate.js"></script>
		<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-sanitize.js"></script>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-2.5.0.js"></script>

	</body>
</html>
