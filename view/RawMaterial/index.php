<!DOCTYPE html>
<html>
	<head>
		<?php require "view/header.php"; ?>
		<script src="<?php echo constant('URL'); ?>js/RawMaterial.js"></script>
	</head>
	<body ng-app="AppBase" ng-controller="RawMaterial">
		<div>
			<h1 class="center"> MATERIA PRIMA </h1>

			<div ng-show="!not_found_data" id="actions">
				<ul class="action-links">
					<li><button ng-click="addMaterial()" class="Button">Agregar Materia Prima</button></li>
				</ul>
			</div>

			<div style="font-family:Times New Roman" ng-show="not_found_data" class="center" id="NotFoundMessage">
				<h2>No se encontraron materiales.</h2>
			</div>

			<table ng-show="!not_found_data" id="{{ !service ? 'providers_retired' : 'providers_hired'}}">
				<tr>
					<th>ID</th>
					<th>CATEGORÍA</th>
					<th>PRECIO</th>
					<th>UNIDAD</th>
					<th>CANTIDAD</th>
					<th>FECHA DE COMPRA</th>
					<th>PROVEEDOR (Razón social)</th>
				</tr>
				<tr ng-repeat="field in dataMaterial">
					<td>{{ field.id }}</td>
					<td>{{ field.nombre }}</td>
					<td>{{ field.precio }}</td>
					<td>{{ field.unidad }}</td>
					<td>{{ field.cantidad }}</td>
					<td>{{ field.fecha }}</td>
					<td>{{ field.razon_social }}</td>
				</tr>
			</table>
			<div id="pager" class="Pagination">
				<ul class="Pagination-links">
					<li ng-repeat="nPage in pagerMaterial" ng-class="{'is-selected': ($index+1 === {{npage}})}">
						<a href="<?php echo constant('URL');?>rawmaterial?page={{nPage}}">Page {{nPage}}</a>
					</li>
				</ul>
			</div>
		</div>
	</body>
	<footer>
		<?php require "view/footer.php"; ?>
	</footer>
</html>
