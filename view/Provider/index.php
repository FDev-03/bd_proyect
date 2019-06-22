<!DOCTYPE html>
<html>
	<head>
		<?php require "view/header.php"; ?>
		<script src="<?php echo constant('URL'); ?>js/FunctionsBase.js"></script>
	</head>
	<body ng-app="AppBase" ng-controller="Provider">
		<div>
			<h1 class="center"> Proveedores Contratados </h1>
			<table>
				<tr>
					<th>ID</th>
					<th>NOMBRE DE CONTACTO</th>
					<th>RAZÓN SOCIAL</th>
				</tr>
				<tr ng-repeat="field in dataProvider">
					<td>{{ field.id }}</td>
					<td>{{ field.nombre_contacto }}</td>
					<td>{{ field.razon_social }}</td>
					<td><button ng-click="updateRow(field.id)">Update</button></td>
					<td><button ng-click="deleteRow(field.id)">Delete</button></td>
				</tr>
			</table>
			<div id="pager">
				<ul>
					<li ng-repeat="nPage in pagerProvider">
						<a href="<?php echo constant('URL');?>gettest?page={{nPage}}">Page {{nPage}}</a>
					</li>
				</ul>
			</div>
		</div>
	</body>
	<footer>
		<?php require "view/footer.php"; ?>
	</footer>
</html>