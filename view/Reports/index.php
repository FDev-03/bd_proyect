<!DOCTYPE html>
<html>
	<head>
		<?php require "view/header.php"; ?>
		<script src="<?php echo constant('URL'); ?>js/Reports.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo constant('URL'); ?>public/css/reports.css">
	</head>
	<body ng-app="AppBase" ng-controller="Reports">
		<div>
			<h1 class="center"> Reportes </h1>
		</div>
		<div class="container">
			<div class="row">
			  <div class="col-sm-3">
			    <div class="sidebar-nav">
			      <div class="navbar navbar-default" role="navigation">
			        <div class="navbar-collapse collapse sidebar-navbar-collapse">
			          <ul class="nav navbar-nav">
			            <li><a data-ng-click="ShowChange($event)" id="matp_prend" href="#">Cantidad disponible (inventario materia prima y prendas de vestir)</a></li>
			            <li><a data-ng-click="ShowChange($event)" id="retired_providers" href="#">Nombres de los proveedores retirados</a></li>
			            <li><a data-ng-click="ShowChange($event)" id="" href="#">Datos de ventas</a></li>
			            <li><a data-ng-click="ShowChange($event)" id="" href="#">Datos de los clientes que han realizado compras</a></li>
			            <li><a data-ng-click="ShowChange($event)" id="" href="#">Valor total de las ventas</a></li>
			            <li><a data-ng-click="ShowChange($event)" id="" href="#">Valor de las ventas de uno o varios tipos de prenda.</a></li>
			            <li><a data-ng-click="ShowChange($event)" id="" href="#">Valor de las ventas de las prendas de cada una de las tallas.</a></li>
			          </ul>
			        </div>
			      </div>
			    </div>
			  </div>
			  <div id="dataResponse" class="col-sm-9">
			    <div id="matp_prend_value" class="values" hidden>
						<ul>
			        <li>Cantidad Disponible (Materia Prima): {{quantity_mp_available}}</li>
			        <li>Cantidad Disponible (Prendas de Vestir): {{quantity_pv_available}}</li>
						</ul>
			    </div>
			    <div id="retired_providers_value" class="values" hidden>
						<ul>
							<li ng-repeat="name in retired_privers">
								name
							</li>
						</ul>
			    </div>
			  </div>
			</div>
		</div>	
	</body>
	<footer>
		<?php require "view/footer.php"; ?>
	</footer>
</html>
