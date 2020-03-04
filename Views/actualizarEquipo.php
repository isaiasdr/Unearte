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

	if (!isset($_SESSION["idEquipo"])) {
		redireccionar("consultaEquipo.php");
	}

	//solo puede acceder a estas funciones el administrador del sistema
	if ($RolUsuario == 3) {
		redireccionar("inicio.php");
	}
?>

<!DOCTYPE html>
<html class="h-100">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Actualizar Equipo</title>
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
				<header id="header" class="">
					<h3>Actualizar Equipo</h3>
				</header>
				<div class="form-row">
					
				</div>
			</div>
		</div>
		
		<?php 
			$idEquipo= $_SESSION["idEquipo"];
			unset($_SESSION['idEquipo']);
			$equipo= new equipo(1);
			$tipo= new tipo(1);
			$marca= new marca(1);
			$modelo= new modelo(1);
			$sede= new sede(1);
			$departamento= new departamento(1);
			$piso= new piso(1);
			$administrativo= new administrativo(1);
			$status= new status(1);
				
			$equipo->setIdEquipo($idEquipo);
			$Equipo= $equipo->seleccionarEquipo();

			$tipo->setIdTipo($Equipo[0]["tipo_idTipo"]);
			$Tipo= $tipo->consultarTipo();

			$modelo->setIdModelo($Equipo[0]["modelo_idModelo"]);
			$Modelo= $modelo->consultarModelo();
							
			$marca->setIdMarca($Modelo[0]["marca_idMarca"]);
			$Marca= $marca->consultarMarca();

			$sede->setIdSede($Equipo[0]["sede_idSede"]);
			$Sede= $sede->consultarSede();

			$administrativo->setIdAdministrativo($Equipo[0]["administrativo_idAdministrativo"]);
			$Administrativo= $administrativo->consultarAdministrativo();

			$departamento->setIdDepartamento($Administrativo[0]["departamento_idDepartamento"]);
			$Departamento= $departamento->consultarDepartamento();

			$piso->setIdPiso($Departamento[0]["piso_idPiso"]);
			$Piso= $piso->consultarPiso();

			$status->setIdStatus($Equipo[0]["status_idStatus"]);
			$Status= $status->consultarStatus();

			if ($Status[0]["Status"]=="DESINCORPORADO") {
				$contador= 0;
				$TotalEquipos= $equipo->consultarEquipos();
				foreach ($TotalEquipos as $Individual) {
					if ($Individual["idEquipo"]==$idEquipo) {
						break;
					}
					$contador++;
				}

				redireccionar("../Views/consultaEquipo.php?idEquipo=".($contador+1));
			} 
		?>
	</article>

	<div class="container-fluid">
		<div class="container">
			<form action="../Controller/administrarEquipo.php" method="post" accept-charset="utf-8">

				<div class="form-row" style="padding-top: 3%">
					<?php 
						echo '<input type="hidden" id="idEquipo" name="idEquipo" value="'.$Equipo[0]["idEquipo"].'">';
						echo '<div class="col-md-4" align="center"><label for="Tipo">Tipo Equipo</label><input class="form-control" id="Tipo" type="text" name="Tipo" value="'.$Tipo[0]["Tipo"].'" disabled></div>';
						echo '<div class="col-md-4" align="center"><label for="Marca">Marca</label><input class="form-control" id="Marca" type="text" name="Marca" value="'.$Marca[0]["Marca"].'" disabled></div>';
						echo '<div class="col-md-4" align="center"><label for="Modelo">Modelo</label><input class="form-control" id="Modelo" type="text" name="Modelo" value="'.$Modelo[0]["Modelo"].'" disabled></div>';
					?>
				</div>

				<div class="form-row" style="padding-top: 3%">
					<?php 
						echo '<div class="col-md-4" align="center"><label for="Serial">Serial</label><input class="form-control" id="Serial" type="text" name="Serial" value="'.$Equipo[0]["Serial"].'" disabled></div>';
						echo '<div class="col-md-4" align="center"><label for="Chapa_Vieja">Numero Bien Nacional Chapa Vieja</label><input class="form-control" id="Chapa_Vieja" type="text" name="Chapa_Vieja" value="'.$Equipo[0]["Chapa_Vieja"].'"></div>';
						echo '<div class="col-md-4" align="center"><label for="Bien_Nacional">Numero Bien Nacional</label><input class="form-control" id="Bien_Nacional" type="text" name="Bien_Nacional" value="'.$Equipo[0]["Bien_Nacional"].'"></div>';
					?>
				</div>

				<div class="form-row" style="padding-top: 3%">
					<div class="col-md-3" align="center">
						<label for="SedeActualizar">Sede</label>
						<select class="custom-select" id="SedeActualizar" name="Sede" required> </select>
						<section id="Input-Sede" name="Input-Sede" style="padding-top: 3%"> </section>
					</div>

					<div class="col-md-3" align="center">
						<label for="PisoActualizar">Piso</label>
						<select class="custom-select" id="PisoActualizar" name="Piso" required> </select>
						<section id="Input-Piso" name="Input-Piso" style="padding-top: 3%"> </section>
					</div>

					<div class="col-md-3" align="center">
						<label for="DepartamentoActualizar">Departamento</label>
						<select class="custom-select" id="DepartamentoActualizar" name="Departamento" required> </select>
						<section id="Input-Departamento" name="Input-Departamento" style="padding-top: 3%"> </section>
					</div>

					<div class="col-md-3" align="center">
						<label for="AdministrativoActualizar">Usuario</label>
						<select class="custom-select" id="AdministrativoActualizar" name="Administrativo" required> </select>
						<section id="Input-Administrativo" name="Input-Administrativo" style="padding-top: 3%"> </section>
					</div>
				</div>

				<div class="form-row" style="padding-top: 2%">
					<?php 
						echo '<div class="col-md-8" align="center"><label for="Observaciones">Observaciones</label><textarea class="form-control" id="Observaciones" type="text" name="Observaciones" placeholder="Observaciones" rows="3" title="Observaciones">'.$Equipo[0]["Observaciones"].'</textarea></div>';
						echo '<div class="col-md-4" align="center"><label for="Status">Status</label><input class="form-control" type="text" id="Status" name="Status" value="'.$Status[0]["Status"].'"disabled></div>';
					?>
				</div>

				<?php 
					if ($Tipo[0]["Tipo"]== "CASE O CPU") {
						$computador= new computador(1);
						$grupo= new grupo(1);
						$sistema_operativo= new sistema_operativo(1);

						$computador->setAdministrativoID($Equipo[0]["administrativo_idAdministrativo"]);
						$Computador= $computador->consultarComputador();

						$grupo->setIdGrupo($Computador[0]["grupo_idGrupo"]);
						$Grupo= $grupo->consultarGrupo();

						$sistema_operativo->setID($Computador[0]["sistema_operativo_idSistema_operativo"]);
						$SO= $sistema_operativo->ConsultarSO();


						echo '<div class="form-row" style="padding-top: 3%">';
						echo '<div class="col-md-6" align="center"><label for="GrupoActualizar">Grupo</label><select class="custom-select" id="GrupoActualizar" name="Grupo"></select><section id="Input-Grupo" name="Input-Grupo" style="padding-top: 3%"></section></div>';

						echo '<div class="col-md-6" align="center"><label for="SOActualizar">Sistema Operativo</label><select class="custom-select" id="SOActualizar" name="SO"></select><section id="Input-SO" name="Input-SO" style="padding-top: 3%"> </section></div>';
						echo '</div>';

						echo '<div class="form-row" style="padding-top: 3%">';
						echo '<div class="col-md-4" align="center"><label for="Nombre_Equipo">Nombre Equipo</label><input class="form-control" type="text" id="Nombre_Equipo" name="Nombre_Equipo" value="'.$Computador[0]["Nombre_Equipo"].'"></div>';
						echo '<div class="col-md-4" align="center"><label for="MAC">Direccion MAC</label><input class="form-control" type="text" id="MAC" name="MAC" value="'.$Computador[0]["MAC"].'"disabled></div>';
						echo '<div class="col-md-4" align="center"><label for="IP">Direccion IP</label><input class="form-control" type="text" id="IP" name="IP" value="'.$Computador[0]["IP"].'"></div>';
						echo '</div>';
						echo '<div class="form-row" style="padding-top: 3%">';
						echo '<div class="col-md-3" align="center"><label for="Red">Punto de Red</label><input class="form-control" type="text" id="Red" name="Red" value="'.$Computador[0]["Red"].'"></div>';
						echo '<div class="col-md-3" align="center"><label for="Voz">Punto de Voz</label><input class="form-control" type="text" id="Voz" name="Voz" value="'.$Computador[0]["Voz"].'"></div>';
						echo '</div>';
						echo '<input type="hidden" name="Tipo" value="'.$Tipo[0]["Tipo"].'">';

						$computador= NULL;
						$grupo= NULL;
						$sistema_operativo=NULL;
					}

					$equipo= NULL;
					$tipo= NULL;
					$marca= NULL;
					$modelo= NULL;
					$sede= NULL;
					$departamento= NULL;
					$piso= NULL;
					$administrativo= NULL;
					$status= NULL;
				?>
				
				<div style="padding-top: 3%; padding-bottom: 3%">
					<button class="btn btn-outline-secondary" type="submit" name="Actualizar" value="actualizar">Actualizar Datos del Equipo</button>
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
	<script src="../Javascript/bootstrap.bundle.min.js" type="text/javascript"></script>
	<script src="../Javascript/popper.js" type="text/javascript"></script>
	<script src="../Javascript/funcionesJavascript.js" type="text/javascript"></script>
</body>
</html>