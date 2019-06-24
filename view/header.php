<!DOCTYPE html>
<html lang="es">
<head>
	<link rel="stylesheet" type="text/css" href="<?php echo constant('URL'); ?>public/css/main.css">

    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-animate.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.6.1/angular-sanitize.js"></script>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="//angular-ui.github.io/bootstrap/ui-bootstrap-tpls-2.5.0.js"></script>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">


	<title></title>
</head>
	<body>
		<div id="header">
			<ul>
				<li><a href="<?php echo constant('URL'); ?>main">INICIO</a></li>
				<li><a href="<?php echo constant('URL'); ?>help">AYUDA</a></li>
				<li><a href="<?php echo constant('URL'); ?>settest">SET (Prueba)</a></li>
				<li><a href="<?php echo constant('URL'); ?>gettest">GET (Prueba)</a></li>
                <li class="dropdown" id="multiple">
                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Proveedores<span class="caret"></span></a>
                    <ul class="dropdown-menu center">
                        <li><a href="<?php echo constant('URL'); ?>provider?service=true">Contratados</a></li>
                        <li><a href="<?php echo constant('URL'); ?>provider?service=false">Retirados</a></li>
                    </ul>
                </li>
			</ul>
		</div>

	</body>
</html>