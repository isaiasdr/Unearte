<?php
	require_once("../Model/usuario.php");
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

	//solo puede acceder a estas funciones el administrador del sistema
	if ($RolUsuario != 1) {
		redireccionar("inicio.php");
	}

	$Usuario= new usuario(1);
	$Usuarios= $Usuario->consultarUsuarios();
	$claseUsuario= new clases_usuario(1);
?>

<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Administrar Usuarios</title>
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

	<div class="container-fluid" style="padding-top: 3%">
		<div class="container">
			<form action="../Controller/actualizarUsuarios.php" method="post" accept-charset="utf-8">
				<h3 style="padding-bottom: 1%">Administrar Usuarios</h3>
				<table class="table table-hover table-bordered table-striped table-bordered table-sm">
					<caption>Usuarios en el sistema</caption>
					<thead class="thead-light">
						<tr align="center">
							<th scope="col">Usuarios</th>
							<th scope="col">Rol</th>
							<th scope="col">Cambiar Contraseña</th>
							<th scope="col">Habilitar/Deshabilitar</th>
							<th scope="col">Actualizar</th>
						</tr>
					</thead>
					<tbody align="center">
						<?php
							foreach ($Usuarios as $usuario) {
								if ($usuario["Username"]!=$UsuarioActivo && $usuario["clases_usuario_idClase"]!=1) {

									$claseUsuario->setIdClase($usuario["clases_usuario_idClase"]);
									$rolUsuario= $claseUsuario->consultaTipoUsuario();

									echo "<tr><td>".$usuario["Username"]."</td>";
									foreach ($rolUsuario as $rol) {
										echo "<td>".$rol["Tipo_Usuario"]."</td>";
									}
									echo '<td><button class="btn btn-outline-secondary" type="submit" name="cambiarContraseña" value= "'.$usuario["Username"].'">Cambiar Contraseña</button></td>'; //esta deberia ser la imagen para cambiar contraseña
									if ($usuario["Estado"]==1) {
										echo '<td><button class="btn btn-outline-secondary" type="submit" name= "estado" value="'.$usuario["Username"].'">Deshabilitar</button></td>';
									} else {
										echo '<td><button class="btn btn-outline-secondary" type="submit" name= "estado" value="'.$usuario["Username"].'">Habilitar</button></td>';
									}
									echo '<td><button class="btn btn-outline-secondary" type="submit" name= "actualizar" value="'.$usuario["Username"].'">Actualizar</button></td></tr>'; //esta deberia ser la imagen para actualizar
								}
							}
							$Usuario= null;
							$claseUsuario= null;
						?>
					</tbody>
				</table>
			</form>
		</div>
	</div>
	
	<div class="container-fluid">
		<div class="container">
			<h3 style="padding-bottom: 1%">Registrar Usuarios</h3>
			<a class="btn btn-outline-secondary" href="registrarUsuario.php" title="Registrar Usuario" role="button">Registrar Usuario</a>
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