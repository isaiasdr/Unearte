<?php
	require_once("../Model/tipo.php");
	require_once("../Model/modelo.php");
	require_once("../Model/marca.php");
	require_once("../Model/status.php");
	require_once("../Model/sede.php");
	require_once("../Model/administrativo.php");
	require_once("../Model/grupo.php");
	require_once("../Model/sistema_operativo.php");

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

	//solo puede acceder a estas funciones el administrador del sistema y soporte tecnico
	if ($RolUsuario== 3) {
		redireccionar("inicio.php");
	}
 ?>

<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Registrar Equipos</title>
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
			<form action="../Controller/añadirEquipos.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
				<section>
					<h3>Añadir multiples registros de Equipos</h3>
					<div class="custom-file" style="padding-bottom: 5%">
					  <input type="file" class="custom-file-input" id="archivo_Equipos" name="archivo_Equipos" lang="es">
					  <label class="custom-file-label" for="customFileLang">Seleccionar Archivo .CSV</label>
					</div>
					<button class="btn btn-outline-secondary" type="submit" name="multiple" value="multiple">Enviar</button>
				</section>
			</form>
		</div>
	</div>

	<div class="container-fluid" style="padding-top: 3%; padding-bottom: 5%">
		<div class="container">
			<form action="../Controller/añadirEquipos.php" method="post" accept-charset="utf-8">
				<section>
					<h3>Añadir Equipo</h3>
					<div class="form-row">
						<div class="Select-Tipo col-md-4" align="center">
							<label for="Tipo">Tipo</label>
							<label class="mr-sm-2 sr-only" for="Tipo">Preference</label>
							<select class="custom-select" id="Tipo" name="Tipo" required> </select>
							<section id="Input-Tipo" name="input-Tipo" style="padding-top: 3%"> </section>
						</div>
					
						<div class="Select-Marca col-md-4" align="center">
							<label for="Marca">Marca</label>
							<label class="mr-sm-2 sr-only" for="Marca">Preference</label>
							<select class="custom-select" id="Marca" name="Marca" required> </select>
							<section id="Input-Marca" name="Input-Marca" style="padding-top: 3%"> </section>
						</div>

						<div class="Select-Modelo col-md-4" align="center">
							<label for="Modelo">Modelo</label>
							<label class="mr-sm-2 sr-only" for="Modelo">Preference</label>
							<select class="custom-select" id="Modelo" name="Modelo" required> </select>
							<section id="Input-Modelo" name="Input-Modelo" style="padding-top: 3%"> </section>
						</div>
					</div>
					
					<div class="form-row" style="padding-top: 3%">
						<div class="col-md-4" align="center">
							<label for="Bien_Nacional">Numero Bien Nacional</label>
							<input class="form-control" type="number" id="Bien_Nacional" name="Bien_Nacional" placeholder="Bien Nacional">
						</div>

						<div class="col-md-4" align="center">
							<label for="Chapa_Vieja">Numero Bien Nacional Chapa Vieja</label>
							<input type="text" class="form-control" id="Chapa_Vieja" name="Chapa_Vieja" placeholder="Bien Nacional Chapa Vieja">
						</div>

						<div class="col-md-4" align="center">
							<label for="Serial">Numero Serial</label>
							<input class="form-control" type="text" id="Serial" name="Serial" placeholder="Serial" required>
						</div>
					</div>

					<div class="form-row" style="padding-top: 3%">
						<div class="col-md-8" align="center">
							<label for="Observaciones">Observaciones</label>
							<textarea class="form-control" id="Observaciones" type="text" name="Observaciones" placeholder="Observaciones" rows="3" title="Observaciones"> </textarea>
						</div>

						<div class="col-md-4" align="center">
							<label for="Status">Status</label>
							<select class="custom-select" id="Status" name="Status" required>
								<?php
									$StatusEquipo= new status(1);
									$consulta= $StatusEquipo->consultarTodosStatus();

									echo '<option value="0" selected disabled>Seleccionar Estado</option>';
									foreach ($consulta as $datos) {
										if ($datos["Status"]!="DESINCORPORADO") {
											echo "<option value=".$datos["idStatus"].">".$datos["Status"]."</option>";
										}
									}
									echo '<option value="">Otro</option>';
								?>
							</select>
							<section id="Input-Status" name="Input-Status" style="padding-top: 3%"> </section>
						</div>
					</div>

					<div class="form-row" style="padding-top: 3%">
						<div class="col-md-3" align="center">
							<label for="Sede">Sede</label>
							<select class="custom-select" id="Sede" name="Sede" required>
								<?php
									$SedeEquipo= new sede(1);
									$consulta= $SedeEquipo->consultarTodosSedes();

									echo '<option value="0" selected disabled>Seleccionar Sede</option>';
									foreach ($consulta as $datos) {
										echo "<option value=".$datos["idSede"].">".$datos["Sede"]."</option>";
									}
									echo '<option value="">Otro</option>';
								?>
							</select>
							<section id="Input-Sede" name="Input-Sede" style="padding-top: 3%"> </section>
						</div>

						<div class="Select-Piso col-md-3" align="center">
							<label for="Piso">Piso</label>
							<select class="custom-select" id="Piso" name="Piso" required> </select>
							<section id="Input-Piso" name="Input-Piso" style="padding-top: 3%"> </section>
						</div>

						<div class="Select-Departamento col-md-3" align="center">
							<label for="Departamento">Departamento</label>
							<select class="custom-select" id="Departamento" name="Departamento" required> </select>
							<section id="Input-Departamento" name="Input-Departamento" style="padding-top: 3%"> </section>
						</div>

						<div class="Select-Administrativo col-md-3" align="center">
							<label for="Administrativo">Usuario</label>
							<select class="custom-select" id="Administrativo" name="Administrativo" required> </select>
							<section id="Input-Administrativo" name="Input-Administrativo" style="padding-top: 3%"> </section>
						</div>
					</div>

					<section id="FormularioCPU" name="FormularioCPU" style="padding-bottom: 3%; padding-top: 2%;">
						<div class="form-row">
							<div class="col-md-6" align="center">
								<label for="Grupo">Grupo</label>
								<select class="custom-select" id="Grupo" name="Grupo" required disabled>
									<?php 
										$Grupos= new grupo(1);
										$consulta= $Grupos->consultarTodosGrupos();
										echo '<option value="0" selected disabled>Seleccionar Grupo</option>';
										foreach ($consulta as $datos) {
											echo '<option value="'.$datos["idGrupo"].'">'.$datos["Grupo"].'</option>';
										}
										echo '<option value="">Otro</option>';
										$Grupos= NULL;
									?>
								</select>
								<section id="Input-Grupo" name="Input-Grupo" style="padding-top: 3%"> </section>
							</div>

							<div class="col-md-6" align="center">
								<label for="SO">Sistema Operativo</label>
								<select class="custom-select" id="SO" name="SO" required disabled>
									<?php 
										$SO= new sistema_operativo(1);
										$consulta= $SO->consultarTodosSO();
										echo '<option value="0" selected disabled>Seleccionar Sistema Operativo</option>';
										foreach ($consulta as $datos) {
											echo '<option value="'.$datos["idSistema_operativo"].'">'.$datos["SO"].'</option>';
										}
										echo '<option value="">Otro</option>';
										$SO= NULL;
									?>
								</select>
								<section id="Input-SO" name="Input-SO" style="padding-top: 3%"> </section>
							</div>
						</div>

						<div class="form-row" style="padding-top: 3%">
							<div class="col-md-4" align="center">
								<label for="Nombre_Equipo">Nombre Equipo</label>
								<input class="form-control" type="text" id="Nombre_Equipo" name="Nombre_Equipo" placeholder="Nombre Equipo" required disabled>
							</div>

							<div class="col-md-4" align="center">
								<label for="MAC">Direccion MAC</label>
								<input class="form-control" type="text" id="MAC" name="MAC" placeholder="MAC" required disabled>
							</div>

							<div class="col-md-4" align="center">
								<label for="IP">Direccion IP</label>
								<input class="form-control" type="text" id="IP" name="IP" placeholder="IP" required disabled>
							</div>
						</div>

						<div class="form-row" style="padding-top: 3%">
							<div class="col-md-3" align="center">
								<label for="Red">Punto de Red</label>
								<input class="form-control" type="text" id="Red" name="Red" placeholder="Red" required disabled>
							</div>

							<div class="col-md-3" align="center">
								<label for="Voz">Punto de Voz</label>
								<input class="form-control" type="text" id="Voz" name="Voz" placeholder="Voz" required disabled>
							</div>
						</div>
					</section>

					<button class="btn btn-outline-secondary" type="submit" name="individual" value="individual" >Enviar</button>
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