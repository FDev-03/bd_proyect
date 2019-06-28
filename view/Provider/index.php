<!DOCTYPE html>
<html>
	<head>
		<?php require "view/header.php"; ?>
		<script src="<?php echo constant('URL'); ?>js/FunctionsBase.js"></script>
	</head>
	<body ng-app="AppBase" ng-controller="Provider">
		<div>
			<h1 class="center"> {{!service ? 'Proveedores Retirados' : 'Proveedores Contratados'}}  </h1>

			<div id="actions" ng-show="service">
				<ul class="action-links">
					<li><button ng-click="addProvider()" class="Button">Agregar Proveedor</button></li>
				</ul>
			</div>

			<table id="{{ !service ? 'providers_retired' : 'providers_hired'}}">
				<tr>
					<th>ID</th>
					<th>NOMBRE DE CONTACTO</th>
					<th>RAZÓN SOCIAL</th>
					<th ng-show="!service">MOTIVO DE RETIRO</th>
					<th ng-show="!service">FECHA DE RETIRO</th>
				</tr>
				<tr ng-repeat="field in dataProvider">
					<td>{{ field.id }}</td>
					<td>{{ field.nombre_contacto }}</td>
					<td>{{ field.razon_social }}</td>
					<td ng-show="!service">{{ field.motivo }}</td>
					<td ng-show="!service">{{ field.fecha_retiro }}</td>
					<td><button class="Button" ng-show="service" ng-click="removeProvider(field.id)">Retirar Proveedor</button></td>
				</tr>
			</table>
			<div id="pager" class="Pagination">
				<ul class="Pagination-links">
					<li ng-repeat="nPage in pagerProvider" ng-class="{'is-selected': ($index+1 === {{npage}})}">
						<a href="<?php echo constant('URL');?>provider?page={{nPage}}&service={{service}}">Page {{nPage}}</a>
					</li>
				</ul>
			</div>
		</div>
	</body>
	<footer>
		<?php require "view/footer.php"; ?>
	</footer>
</html>
