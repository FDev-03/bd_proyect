<!DOCTYPE html>
<html>
	<?php require "view/header.php"; ?>
	<script src="<?php echo constant('URL'); ?>js/settest.js"></script>
	<body ng-app="GetApp" ng-controller="GetCtrl">
		<div>
			<h1 class="center"> Get (Prueba) </h1>
			<table>
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
			</div>
		</div>
	</body>
	<?php require "view/footer.php"; ?>
</html>