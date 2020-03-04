<?php
	require_once("../Model/historico.php");
	require_once("../Model/fallas.php");
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
?>

<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Consulta Inventario</title>
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

	<article id="Tabla_Fallas" style="padding-top: 3%">
		<div class="container-fluid">
			<div class="container">
				<table class="table table-hover table-bordered table-striped table-bordered table-sm">
					<caption>Fallas mas comunes</caption>
					<thead class="thead-light">
						<tr align="center">
							<th scope="col">Num</th>
							<th scope="col">Falla</th>
							<th scope="col">Porcentaje</th>
							<th scope="col">Ubicacion</th>
							<th scope="col">Equipos Afectados</th>
						</tr>
					</thead>
					<tbody align="center">
						<?php
							//aca deberia poner mi codigo php para rellenar la tabla bien chevere
							$departamento= new departamento(1);
							$Departamentos= $departamento->consultarTodosDepartamentos();
							$array_datos=NULL;
							$contador=NULL;
							$departamento= NULL;

							foreach ($Departamentos as $Departamento) {
								$fallas= new fallas(1);
								$historico= new historico(1);

								$Fallas= $fallas->consultarTodasFallas();

								foreach ($Fallas as $falla) {
									$contador=0;
									$idFalla= $falla["idFallas"];
									$historico->setFallasID($idFalla);
									$historico->setSolventado(0);
									$Historicos= $historico->historicosPorFalla();
									
									foreach ($Historicos as $Historico) {

										$idEquipo= $Historico["equipo_idEquipo"];
										$equipo= new equipo(1); 
										$equipo->setIdEquipo($idEquipo);
										$Equipo= $equipo->seleccionarEquipo();

										$idAdministrativo= $Equipo[0]["administrativo_idAdministrativo"];
										$administrativo= new administrativo(1);
										$administrativo->setIdAdministrativo($idAdministrativo);
										$Administrativo= $administrativo->consultarAdministrativo();

										$idDepartamento= $Administrativo[0]["departamento_idDepartamento"];

										if ($idDepartamento==$Departamento["idDepartamento"]) {
											$contador++;
										}

										$equipo=NULL;
										$administrativo= NULL;
									}
									if ($contador!=0) {
										$array_datos[]= array('idDepartamento' => $Departamento["idDepartamento"], 'idfallas' => $idFalla, 'CantidadEquipos' => $contador);
									}
								}
								$fallas= NULL;
								$historico= NULL;
							}

							if ($array_datos==NULL) {
								$total= 0;
							} else {
								$total= count($array_datos);
							}

							for ($i=0; $i < $total; $i++) { 
								for ($j=$i+1; $j < $total; $j++) {
									
									if ($array_datos[$i]["CantidadEquipos"] < $array_datos[$j]["CantidadEquipos"]) {

										$temp= $array_datos[$i];
										$array_datos[$i] = $array_datos[$j];
										$array_datos[$j] = $temp;
									}
								}
							}
							
							if ($total!=0) {
								$equipo= new equipo(1);
								$TotalEquipos= count($equipo->consultarEquipos());
								$identificador=0;

								for ($i=0; $i < $total; $i++) {

									$fallas= new fallas(1);
									$fallas->setIdFallas($array_datos[$i]["idfallas"]);
									$Falla= $fallas->consultarFallas();
									
									$departamento= new departamento(1);
									$departamento->setIdDepartamento($array_datos[$i]["idDepartamento"]);
									$Departamento= $departamento->consultarDepartamento();

									$Porcentaje= ($array_datos[$i]["CantidadEquipos"]/$TotalEquipos)*100;
									$Porcentaje= number_format($Porcentaje,2,".",",");

									echo "<tr><td>".($i+1)."</td><td>".$Falla[0]["Fallas"]."</td>";
									echo "<td>".$Porcentaje."%</td><td>".$Departamento[0]["Departamento"]."</td>";
									echo "<td>".$array_datos[$i]["CantidadEquipos"]."</td></tr>";

									$fallas= NULL;
									$departamento= NULL;
								}
								$equipo=NULL;
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</article>

	<article id="">
		<div class="container-fluid">
			<div class="container">

				<header id="header">
					<h3>Consulta Inventario</h3>
				</header>

				<nav class="navbar nav navbar-expand-lg navbar-dark">
					<div class="justify-content-start">
						<form action="../Controller/generarPDF.php" method="post" accept-charset="utf-8">
							<button type="submit" class="btn btn-outline-secondary" id="Busqueda-PDF" name="Busqueda-PDF" value="">Generar PDF</button>
						</form>
					</div>
					<div class="form-inline collapse navbar-collapse justify-content-end">
						<div class="collapse navbar-collapse justify-content-end">
							<input class="form-control mr-sm-2" type="search" id="busqueda" name="busqueda" placeholder="Busqueda" data-toggle="tooltip" data-html="true" title="Tipo de Equipo<br>Numero Serial<br>Numero Activo Fijo<br>Departamento<br>Piso" aria-label="Search">
							<button id="Boton-Busqueda" class="btn btn-outline-secondary" type="button">Buscar</button>
						</div>
					</div>

					<div class="collapse navbar-collapse justify-content-end">
						<form class="justify-content-end" action="../Controller/generarExcel.php" method="post" accept-charset="utf-8">
							<button type="submit" class="btn btn-outline-secondary" id="Busqueda-Excel" name="Busqueda-Excel" value="">Generar Excel</button>
						</form>
					</div>
				</nav>
			</div>
		</div>
	</article>

	<article id="Tabla_Consultas" style="padding-bottom: 1%">
		<div class="container-fluid table-responsive">
			<div class="container table-responsive" style="height: 700px">
				<table class="table-hover table-striped table table-bordered table-sm">
					<caption>Consulta del Inventario</caption>
					<thead class="thead-light">
						<tr align="center">
							<th scope="col">Num</th>
							<th scope="col">Equipo</th>
							<th scope="col">Marca</th>
							<th scope="col">Modelo</th>
							<th scope="col">Numero Serial</th>
							<th scope="col">Numero Chapa Vieja</th>
							<th scope="col">Numero Activo Fijo</th>
							<th scope="col">Sede</th>
							<th scope="col">Departamento</th>
							<th scope="col">Piso</th>
							<th scope="col">Usuario</th>
							<th scope="col">Nombre Equipo</th>
							<th scope="col">Grupo</th>
							<th scope="col">MAC</th>
							<th scope="col">IP</th>
							<th scope="col">Red</th>
							<th scope="col">Voz</th>
							<th scope="col">Estado</th>
							<th scope="col">Observaciones</th>
							<th scope="col">Sistema Operativo</th>
						</tr>
					</thead>
					<tbody class="Consulta-Multiple" align="center"> </tbody>
				</table>
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