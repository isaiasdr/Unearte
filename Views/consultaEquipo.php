<?php
	require_once("../Model/equipo.php");
	require_once("../Model/tipo.php");
	require_once("../Model/modelo.php");
	require_once("../Model/marca.php");
	require_once("../Model/status.php");
	require_once("../Model/sede.php");
	require_once("../Model/administrativo.php");
	require_once("../Model/departamento.php");
	require_once("../Model/computador.php");
	require_once("../Model/grupo.php");
	require_once("../Model/piso.php");
	require_once("../Model/sistema_operativo.php");
	require_once("../Model/historico.php");
	require_once("../Model/fallas.php");

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

	if (isset($_GET["idEquipo"])) {
		$idEquipo= $_GET["idEquipo"];
	} else {
		$idEquipo= 1;
	}
?>

<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Consulta Equipo</title>
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

	<article id="" style="padding-top: 3%">
		<div class="container-fluid">
			<div class="container">
				<header id="header" class="">
					<h3>Consulta del Equipo</h3>
				</header>

				<div class="form-row justify-content-center">
					<div class="col-md-1">
						<button class="btn btn-outline-secondary" id="Anterior" type="button">Anterior</button>
					</div>

					<div class="col-md-1">
						<?php 
							$equipo= new equipo(1);
							
							$Equipos= $equipo->consultarEquipos();
							$cantidadEquipos= count($Equipos);

							if ($idEquipo>$cantidadEquipos) {
								redireccionar("consultaEquipo.php");
							}

							if ($cantidadEquipos == 0) {
								echo '<input class="form-control" type="number" id="idEquipo" name="idEquipo" value="0"></div><div class="col-md-1"><input class="form-control" type="text" value="/'.$cantidadEquipos.'" readonly></div>';
							} else {
								echo '<input class="form-control" type="number" id="idEquipo" title="Numero del Equipo" name="idEquipo" value='.$idEquipo.'></div><div class="col-md-1"><input class="form-control" type="text" value="/'.$cantidadEquipos.'" readonly></div>';
							}
							echo '<input id="numEquipos" type="hidden" value="'.$cantidadEquipos.'">';

							$equipo= NULL;
						
						?>

					<div class="col-md-1">
						<button class="btn btn-outline-secondary" id="Siguiente" title="" type="button">Siguiente</button>
					</div>
				</div>
			</div>
		</div>
	</article>

	<div class="container-fluid">
		<div class="container">
			<form action="../Controller/administrarEquipo.php" method="post" accept-charset="utf-8">
				<div class="datosConsulta" style="padding-top: 1%; padding-bottom: 3%"> </div>					

				<div class="form-row justify-content-center">

					<?php 
						if ($RolUsuario != 3) {
							echo '<div class="col-md-2">';
							echo '<button class="btn btn-outline-secondary" type="submit" name="Actualizar" value="Actualizar">Actualizar Equipo</button>';
							echo '</div>';

							echo '<div class="col-md-2">';
							echo '<button class="btn btn-outline-secondary" type="submit" name="registrar_Falla" value="registrar_Falla">Registrar Falla</button>';
							echo '</div>';

							if ($RolUsuario==1) {
								echo '<div class="col-md-2">';
								echo '<button class="btn btn-outline-secondary" type="submit" name="Desincorporar" value="Desincorporar">Desincorporar</button>';
								echo '</div>';
							} 
						}
						
					?>

					<div class="col-md-2">
						<button class="btn btn-outline-secondary" type="submit" id="EquipoID" name="EquipoID" value="0">Generar PDF</button>
					</div>
				</div>
			</form>

			
		</div>
	</div>
	
	<form action="../Controller/administrarMantenimiento.php" method="post" accept-charset="utf-8">
		<article style="padding-top: 3%">
			<div class="container-fluid">
				<div class="container">
					<table class="table-hover table-striped table table-bordered table-sm">
						<caption>Historico de Incidencias del Equipo</caption>
						<thead class="thead-light">
							<tr align="center">
								<th scope="col">Fecha de Registro de Falla</th>
								<th scope="col">Fecha de Registro de Mantenimiento</th>
								<th scope="col">Falla</th>
								<th scope="col">Descripcion</th>
								<th scope="col">Requerimientos</th>
								<th scope="col">Solventado</th>
								<th scope="col">Registrar Mantenimiento</th>
							</tr>
						</thead>
						<tbody class="historicoTabla" align="center"> </tbody>
					</table>
				</div>
			</div>
		</article>
	</form>

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