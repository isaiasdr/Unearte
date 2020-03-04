<?php 
	require_once("../Model/historico.php");
	require_once("../Model/status.php");
	require_once("../Model/equipo.php");
	require_once("../Model/fallas.php");
	require_once("../Model/tipo.php");
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

	if (!isset($_SESSION["idHistorico"])) {
		redireccionar("consultaEquipo.php");
	}

	//solo puede acceder a estas funciones el administrador del sistema
	if ($RolUsuario == 3) {
		redireccionar("consultaEquipo.php");
	}
?>

<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Registrar Mantenimiento</title>
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
			<article style="padding-top: 3%">
				<header id="header" class="">
					<h3>Registrar Mantenimiento en Equipo</h3>
				</header>

				<div>
					<?php 

						$idHistorico= $_SESSION["idHistorico"];
						unset($_SESSION['idHistorico']);
						$historico= new historico(1);
						$historico->setIdhistorico($idHistorico);
						$Historico= $historico->consultarHistorico();

						$equipo= new equipo(1);
						$status= new status(1);
						$fallas= new fallas(1);

						$equipo->setIdEquipo($Historico[0]["equipo_idEquipo"]);
						$Equipo= $equipo->seleccionarEquipo();

						$status->setIdStatus($Equipo[0]["status_idStatus"]);
						$Status= $status->consultarStatus();

						$contador= 0;
						$TotalEquipos= $equipo->consultarEquipos();
						foreach ($TotalEquipos as $Individual) {
							if ($Individual["idEquipo"]==$Historico[0]["equipo_idEquipo"]) {
								break;
							}
							$contador++;
						}

						if ($Status[0]["Status"]=="DESINCORPORADO") {
							redireccionar("../Views/consultaEquipo.php?idEquipo=".($contador+1));
						}
						
						$Status= $status->consultarTodosStatus();
						$Fallas= $fallas->consultarTodasFallas();
					?>
				</div>
			</article>
		</div>
	</div>

	<div class="container-fluid" style="padding-top: 1%">
		<div class="container">
			<table class="table-hover table table-bordered table-sm">
				<caption>Informacion del Equipo</caption>
				<thead class="thead-light">
					<tr align="center">
						<th scope="col">Num Equipo</th>
						<th scope="col">Tipo</th>
						<th scope="col">Numero Serial</th>
						<th scope="col">Numero Bien Nacional</th>
						<th scope="col">Estado</th>
					</tr>
				</thead>
				<tbody align="center">
					<?php 
						$tipo= new tipo(1);
						$tipo->setIdTipo($Equipo[0]["tipo_idTipo"]);
						$Tipo= $tipo->consultarTipo();

						$status->setIdStatus($Equipo[0]["status_idStatus"]);
						$StatusEquipo= $status->consultarStatus();

						echo '<tr><td>'.$Equipo[0]["idEquipo"].'</td><td>'.$Tipo[0]["Tipo"].'</td>';
						echo '<td>'.$Equipo[0]["Serial"].'</td><td>'.$Equipo[0]["Bien_Nacional"].'</td>';
						echo '<td>'.$StatusEquipo[0]["Status"].'</td></tr>';
					?>
				</tbody>
			</table>		
		</div>
	</div>
	
	<div class="container-fluid">
		<div class="container">
			<form action="../Controller/administrarMantenimiento.php" method="post" accept-charset="utf-8">
				<div class="form-row">
					<?php
						echo '<input type="hidden" name="idEquipo" value="'.$Equipo[0]["idEquipo"].'">';
						echo '<input type="hidden" name="idHistorico" value="'.$idHistorico.'">';
						//echo 'Estado: <input type="text" name="Status" value="'.$Status[0]["Status"].'"disabled><br>';
					?>
					<div class="col-md-4" align="center">
						<label for="Status">Status</label>
						<select class="custom-select" id="Status" name="Status" required>
							<?php
								echo '<option value="0" selected disabled>Seleccionar Estado</option>';
								foreach ($Status as $datos) {
									if ($datos["Status"]!="DESINCORPORADO") {
										echo '<option value="'.$datos["idStatus"].'">'.$datos["Status"].'</option>';
									}
								}
								echo '<option value="" >Otro</option>';
								$status= NULL;
							?>
						</select>
						<section id="Input-Status" name="Input-Status" style="padding-top: 5%"> </section>
					</div>

					<?php 
						echo '<div class="col-md-8" align="center"><label for="Observaciones">Observaciones</label><textarea class="form-control" id="Observaciones" type="text" name="Observaciones" placeholder="Observaciones" rows="3" title="Observaciones">'.$Equipo[0]["Observaciones"].'</textarea></div>';
					?>
				</div>

				<div class="form-row" style="padding-top: 3%">
					<div class="col-md-4" align="center">
						<?php 
							echo '<label for="Fallas">Falla</label><select class="custom-select" id="Fallas" name="Fallas" required disabled>';
							echo '<option value="0" selected disabled>Seleccionar Falla</option>';
							foreach ($Fallas as $datos) {
								if ($datos["idFallas"]==$Historico[0]["fallas_idFallas"]) {
									echo '<option value="'.$datos["idFallas"].'" selected>'.$datos["Fallas"].'</option>';
								} else {
									echo '<option value="'.$datos["idFallas"].'">'.$datos["Fallas"].'</option>';
								}
							}
							echo '<option value="" >Otro</option></select>';
						?>
					</div>
					
					<div class="col-md-8" align="center">
						<label for="Descripcion">Descripcion de Falla</label>
						<textarea class="form-control" id="Descripcion" type="text" name="Descripcion" placeholder="Descripcion" rows="3" title="Descripcion de la Falla" disabled><?php echo $Historico[0]["Descripcion"]; ?></textarea>
					</div>
				</div>

				<div class="form-row" style="padding-top: 3%; padding-bottom: 3%">
					<div class="col-md-6" align="center">
						<label for="Requerimientos">Requerimientos</label>
						<input class="form-control" type="text" id="Requerimientos" name="Requerimientos" <?php echo 'value="'.$Historico[0]["Requerimientos"].'"'; ?> placeholder="Fuente de Poder, Disco Duro, Etc." disabled>
					</div>
				</div>

				<div>
					<button class="btn btn-outline-secondary" type="submit" name="Mantenimiento" value="Mantenimiento_Registrado">Registrar Mantenimiento del Equipo</button>
				</div>
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