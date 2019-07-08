<!DOCTYPE html>
<html>
	<head>
		<?php require "view/header.php"; ?>
		<script src="<?php echo constant('URL'); ?>js/Garments.js"></script>
	</head>
	<body ng-app="AppBase" ng-controller="Garments">
		<div>
			<h1 class="center"> PRENDAS </h1>

			<div ng-show="!not_found_data" id="actions">
				<ul class="action-links">
					<li><button ng-click="addGarment()" class="Button">Agregar Prenda</button></li>
				</ul>
			</div>

			<div style="font-family:Times New Roman" ng-show="not_found_data" class="center" id="NotFoundMessage">
				<h2>No se encontraron prendas.</h2>
			</div>

			<table ng-show="!not_found_data" id="{{ !service ? 'providers_retired' : 'providers_hired'}}">
				<tr>
					<th>ID</th>
					<th>PRECIO</th>
					<th>NOMBRES</th>
					<th>TALLAS</th>
					<th>TIPO</th>
				</tr>
				<tr ng-repeat="field in dataMaterial">
					<td>{{ field.id }}</td>
					<td>{{ field.precio }}</td>
					<td>{{ field.nombre }}</td>
					<td>{{ field.tallas }}</td>
					<td>{{ field.tipo }}</td>
				</tr>
			</table>
			<div id="pager" class="Pagination">
				<ul class="Pagination-links">
					<li ng-repeat="nPage in pagerMaterial" ng-class="{'is-selected': ($index+1 === {{npage}})}">
						<a href="<?php echo constant('URL');?>Garment?page={{nPage}}">Page {{nPage}}</a>
					</li>
				</ul>
			</div>
		</div>
	</body>
	<footer>
		<?php require "view/footer.php"; ?>
	</footer>
</html>
