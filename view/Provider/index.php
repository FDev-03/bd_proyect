<!DOCTYPE html>
<html>
	<head>
		<?php require "view/header.php"; ?>
		<script src="<?php echo constant('URL'); ?>js/FunctionsBase.js"></script>
	</head>
	<body ng-app="AppBase" ng-controller="Provider">
		<div>
			<h1 class="center"> Proveedores Contratados </h1>
<!-- 			<table>
				<tr>
					<th>ID</th>
					<th>NAME</th>
					<th>LASTNAME</th>
					<th>NUMBER</th>
				</tr>
				<tr ng-repeat="field in data">
					<td>{{ field.id }}</td>
					<td>{{ field.name }}</td>
					<td>{{ field.lastname }}</td>
					<td>{{ field.number }}</td>
					<td><button ng-click="updateRow(field.id)">Update</button></td>
					<td><button ng-click="deleteRow(field.id)">Delete</button></td>
				</tr>
			</table>
			<div id="pager">
				<ul>
					<li ng-repeat="number in test">
						<a href="<?php echo constant('URL');?>gettest?page={{number}}">Page {{number}}</a>
					</li>
				</ul>
			</div> -->
		</div>
	</body>
	<footer>
		<?php require "view/footer.php"; ?>
	</footer>
</html>