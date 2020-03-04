<?php
	require_once("../Model/clases_usuario.php");
	session_start();

	if (isset($_SESSION['Ultima_Actividad']) && (time() - $_SESSION['Ultima_Actividad'])>60*10) {
		redireccionar("../Controller/cerrarSesion.php");
	}

	if(isset($_SESSION['Username'])) {
		$UsuarioActivo= $_SESSION['Username'];
		$RolUsuario= $_SESSION['clases_usuario_idClase'];
		$_SESSION['Ultima_Actividad']= time();
	} else {
		redireccionar("login.php");
		//
	}

	if ($RolUsuario != 1) {
		redireccionar("inicio.php");
	}
?>
<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Registrar Usuario</title>
	<link rel="stylesheet" href="../CSS/jquery-ui.min.css">
	<link rel="stylesheet" href="../CSS/bootstrap.min.css">
	<link rel="shortcut icon" type="image/vnd.microsoft.icon" href="../Imagenes/favicon.ico">
</head>
<body class="d-flex flex-column h-100" style="background-color: #f7f7f7">
	<header id="navbar">
		<nav class="navbar nav navbar-expand-lg navbar-dark" style="background-color: #3E65A0">
			<div class="dropdown">
				<button class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #3E65A0">
				  <span class="navbar-toggler-icon"></span>
				</button>

				<div class="dropdown-menu" style="background-color: #E0E3E2" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="inicio.php">Inicio</a>
					<a class="dropdown-item" href="consultaInventario.php">Consultar Inventario</a>
				    <a class="dropdown-item" href="consultaEquipo.php">Consultar Equipo</a>
					<?php
						echo "<a class='dropdown-item' href='historicoFallas.php'>Consultar Historico Fallas Activas</a>";
						if ($RolUsuario==1 || $RolUsuario==2) {
							echo "<a class='dropdown-item' href='registrarEquipo.php'>Registrar Equipos</a>";
						} 

						if ($RolUsuario==1) {
							echo "<a class='dropdown-item' href='consultarRegistros.php'>Consultar Registros del Sistema</a>";
						}
					?>
				</div>
			</div>

			<div class="collapse navbar-collapse justify-content-end" id="navbarNav">
			    <ul class="navbar-nav">
			    	<?php 
			    		if ($RolUsuario==1) {
			    			echo '<li class="nav-item"><a class="nav-link" href="administrarUsuarios.php">Administrar Usuarios</a></li>';
			    		}
			    	?>
			    	<li class="nav-item">
			        	<a class="nav-link" href="../Manual Usuario.pdf" target="_blank">Manual de Usuario</a>
			    	</li>
			        <li class="nav-item">
			        	<a class="nav-link" href="cambiarContraseña.php">Cambiar Contraseña</a>
			      	</li>
			      	<li class="nav-item">
			        	<a class="nav-link" href="../Controller/cerrarSesion.php">Cerrar Sesion</a>
			      	</li>
			    </ul>
			  </div>
		</nav>
	</header>

	<div class="container-fluid">
		<div class="container">
			<form action="../Controller/crearUsuario.php" method="post" accept-charset="utf-8">
				<section>
					<h3 style="padding-top: 3%; padding-bottom: 1%">Registro Individual Usuarios</h3>
					
					<div class="form-row justify-content-center">
						<div class="col-md-6" align="center">
							<label for="username">Username</label>
							<input class="form-control" type="text" id="username" name="username" placeholder="Username" required autofocus>
						</div>
					</div>
					
					<div class="form-row justify-content-center" style="padding-top: 3%">
						<div class="col-md-6" align="center">
							<label for="password">Password</label>
							<input class="form-control" type="password" id="password" name="password" placeholder="Contraseña" required>
						</div>
					</div>

					<div class="form-row justify-content-center" style="padding-top: 3%">
						<div class="col-md-6" align="center">
							<label for="confirm_password">Confirma Contraseña</label>
							<input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Repita Contraseña" required>
						</div>
					</div>

					<div class="form-row justify-content-center" style="padding-top: 3%">
						<div class="col-md-6" align="center">
							<label for="rolID">Rol Usuario</label>
							<select class="Select-Rol custom-select" id="rolID" name="rolID" required>
								<?php
									$tiposUsuario= new clases_usuario(1);
									$consulta= $tiposUsuario->consultarTodosTiposUsuario();
									echo '<option value= "" selected disabled>Seleccionar Rol</option>';
									foreach ($consulta as $datos) {
										echo "<option value=".$datos["idClase"].">".$datos["Tipo_Usuario"]."</option>";
									}
								?>
							</select>
						</div>
					</div>

					<div class="form-row justify-content-center" style="padding-top: 3%">
						<div class="permisologia"></div>
					</div>

					<div style="padding-top: 1%">
						<button class="btn btn-outline-secondary" type="submit" name="individual" value="individual">Enviar</button>
					</div>
				</section>
			</form>

			<form action="../Controller/crearUsuario.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
				<section>
					<h3 style="padding-top: 3%">Registro Multiples Usuarios</h3>
					<div class="custom-file" style="padding-bottom: 5%">
						<input type="file" class="custom-file-input" id="Archivo_Usuarios" lang="es" name="Archivo_Usuarios" accept=".csv">
						<label class="custom-file-label" for="customFileLang">Seleccionar Archivo .CSV</label>
					</div>
					<button class="btn btn-outline-secondary" type="submit" name="multiple" value="multiple">Enviar</button>
				</section>
			</form>
		</div>
	</div>

	<footer class="footer mt-auto py-3">
		<div class="container" align="center">
			<span class="text-muted">Universidad Nacional de las Artes</span>
		</div>
	</footer>

	<script src="../Javascript/jquery.min.js" type="text/javascript"></script>
	<script src="../Javascript/jquery-ui.min.js" type="text/javascript"></script>
	<script src="../Javascript/popper.js" type="text/javascript"></script>
	<script src="../Javascript/bootstrap.bundle.min.js" type="text/javascript"></script>
	<script src="../Javascript/funcionesJavascript.js" type="text/javascript"></script>
</body>
</html>