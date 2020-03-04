<?php 
	require_once("../Model/historico.php");
	require_once("../Model/fallas.php");
	session_start();

	if (isset($_SESSION['Ultima_Actividad']) && (time() - $_SESSION['Ultima_Actividad'])>60*10) {
		redireccionar("../Controller/cerrarSesion.php");
	}

	if(isset($_SESSION['Username'])) {
		$UsuarioActivo= $_SESSION['Username'];
		$RolUsuario= $_SESSION['clases_usuario_idClase'];
	} else {
		redireccionar("login.php");
		//
	}
?>

<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Incidencias Activas</title>
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

	<article style="padding-top: 3%">
		<div class="container-fluid">
			<div class="container">
				<h3>Incidencias Activas</h3>
				<table class="table table-hover table-bordered table-striped table-bordered table-sm">
					<caption>Fallas Activas</caption>
					<thead class="thead-light">
						<tr align="center">
							<th scope="col">Num falla</th>
							<th scope="col">Num Equipo</th>
							<th scope="col">Numero Serial</th>
							<th scope="col">Numero Bien Nacional</th>
							<th scope="col">Ubicacion</th>
							<th scope="col">Falla</th>
							<th scope="col">Requerimientos</th>
						</tr>
					</thead>
					<tbody id="IncidenciasTabla" align="center"> </tbody>
				</table>

				<div class="row justify-content-center" style="padding-top: 1%; padding-bottom: 3%">
					<form class="justify-content-end" action="../Controller/generarExcelFallas.php" method="post" accept-charset="utf-8">
						<button type="submit" class="btn btn-outline-secondary">Generar Excel</button>
					</form>
				</div>
			</div>
		</div>
	</article>

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