<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<?php require "view/header.php"; ?>

		<div id="test">
			<h1 class="center"> SET (Prueba) </h1>
		</div>

		<div class="center">
			<form action="<?php echo constant('URL')?>settest/settest" method="POST">
				<div>Nombre : <input type="text" name="name" required></div>
				<div>Apellido : <input type="text" name="lastname"></div>
				<div>Número : <input type="number" name="number"></div>
				<div><button type="send">Envíar</button></div>
			</form>
		</div>

		<div class="center">
			<h3><?php echo $this->message;?></h3>
		</div>

		<?php require "view/footer.php"; ?>
	</body>
</html>