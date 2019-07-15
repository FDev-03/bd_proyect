<!DOCTYPE html>
<html>
	<head>
		<?php require "view/header.php"; ?>
		<script src="<?php echo constant('URL'); ?>js/Client.js"></script>
	</head>
	<body ng-app="AppBase" ng-controller="Client">
		<div>
			<h1 class="center"> CLIENTE </h1>		

			<div style="font-family:Times New Roman" ng-show="not_found_data" class="center" id="NotFoundMessage">
				<h2>No se encontraron cliente.</h2>
			</div>

			<table ng-show="!not_found_data" id="{{ !service ? 'providers_retired' : 'providers_hired'}}">
				<tr>
					<th>ID</th>
					<th>NOMBRES</th>
					<th>TELEFONO</th>
				</tr>
				<tr>
					<td>2019-07-09</td>
					<td>ADRIANA PAOLA CUJAR ALARCON</td>
					<td>BERTHA XIMENA</td>
				</tr>
				<tr>
					<td>2019-07-15</td>
					<td>ADRIANA GIRALDO GOMEZ</td>
					<td>BETSABE BAUTISTA VARGAS</td>
				</tr>
				<tr>
					<td>2019-07-21</td>
					<td>ADRIANA MARCELA SALCEDO SEGURA</td>
					<td>CAMILO ALEXANDER BOLIVAR</td>
				</tr>
			</table>
			<div id="pager" class="Pagination">
				<ul class="Pagination-links">
					<li >
						<a href="<?php echo constant('URL');?>Garment?page={{nPage}}">Page 1</a>
					</li>
				</ul>
			</div>
		</div>
	</body>
	<footer>
		<?php require "view/footer.php"; ?>
	</footer>
</html>
