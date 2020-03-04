<?php 
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Login</title>
	<link rel="stylesheet" href="../CSS/bootstrap.min.css">
	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="../Imagenes/favicon.ico">
</head>
<body style="background-color: #f7f7f7">
	<div class="container-fluid justify-content-center" style="padding-top: 10%">
		<div class="container">
			<div class="form-row justify-content-center">
				<div class="col-md-6" align="center">
					<img src="../Imagenes/logo5.png" alt="Logo" height="100%" width="50%">
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid" style="margin-top: 5%">
		<div class="container">
			<form action="../Controller/validarUsuario.php" method="post" accept-charset="utf-8">
				<div class="form-row justify-content-center">
					<div class="col-md-6" align="center">
						<label for="Username">Username</label>
						<input class="form-control" type="text" id="username" name="username" placeholder="Username" required autofocus>
					</div>
				</div>

				<div class="form-row justify-content-center" style="padding-top: 1%">
					<div class="col-md-6" align="center">
						<label for="password">Contraseña</label>
						<input class="form-control" type="password" id="password" name="password" placeholder="Contraseña" required>
					</div>
				</div>

				<div class="form-row justify-content-center" style="padding-top: 1%">
					<button class="btn btn-outline-secondary" type="submit">Iniciar Sesion</button>
				</div>
			</form>
		</div>
	</div>

	<?php

		if (isset($_SESSION['Login'])) {
			$valor= $_SESSION['Login'];
			unset($_SESSION['Login']);

			if ($valor) {
				echo '<div class="container-fluid" style="padding-top: 3%"><div class="container"><div class="row justify-content-center">';
				echo '<div class="col-md-4 justify-content-center"><div class="alert alert-danger alert-dismissible fade show" role="alert">';
				echo 'Error: Usuario o Contraseña Incorrecta!!';
				echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
				echo '<span aria-hidden="true">&times;</span></button></div></div></div></div></div>';
			} 
		}
	?>

	<script src="../Javascript/jquery.min.js" type="text/javascript"></script>
	<script src="../Javascript/bootstrap.bundle.min.js" type="text/javascript"></script>
</body>
</html>