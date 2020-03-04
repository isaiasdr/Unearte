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

	if (isset($_SESSION['idEquipo'])) {
		$numEquipo= $_SESSION['idEquipo']-1;
		//session_unset($_SESSION['idEquipo']); ver porque no quiere hacer el unset de esa session
	}

	$equipo= new equipo(1);
	$Equipos= $equipo->consultarEquipos();

	if ($numEquipo < 0 || $numEquipo > count($Equipos)) {
		$equipo= NULL;
		return '';
	}

	$tipo= new tipo(1);
	$marca= new marca(1);
	$modelo= new modelo(1);
	$sede= new sede(1);
	$departamento= new departamento(1);
	$piso= new piso(1);
	$administrativo= new administrativo(1);
	$status= new status(1);

	$equipo->setIdEquipo($Equipos[$numEquipo]["idEquipo"]);
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
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<body>
	
	<div>
		<table>
			<caption>Consulta de Equipo</caption>
				<thead>
					<tr>
						<th>Num</th>
						<th>Equipo</th>
						<th>Marca</th>
						<th>Modelo</th>
						<th>Numero Serial</th>
						<th>Numero Chapa Vieja</th>
						<th>Numero Activo Fijo</th>
						<th>Sede</th>
						<th>Departamento</th>
						<th>Piso</th>
						<th>Usuario</th>
						<?php 
							if ($Tipo[0]["Tipo"]=="CASE O CPU") {
								echo '<th>Nombre Equipo</th>';
								echo '<th>Grupo</th><th>MAC</th>';
								echo '<th>IP</th><th>Red</th>';
								echo '<th>Voz</th><th>Estado</th>'; 
								echo '<th>Observaciones</th><th>Sistema Operativo</th>';
							} else {
								echo '<th>Estado</th><th>Observaciones</th>';
							}
						?>
					</tr>
				</thead>
				<tbody>
					<?php 
						echo '<tr><td>'.($numEquipo+1).'</td><td>'.$Tipo[0]["Tipo"].'</td><td>'.$Marca[0]["Marca"].'</td>';
						echo '<td>'.$Modelo[0]["Modelo"].'</td><td>'.$Equipo[0]["Serial"].'</td>';
						echo '<td>'.$Equipo[0]["Chapa_Vieja"].'</td><td>'.$Equipo[0]["Bien_Nacional"].'</td>';
						echo '<td>'.$Sede[0]["Sede"].'</td><td>'.$Departamento[0]["Departamento"].'</td>';
						echo '<td>'.$Piso[0]["Piso"].'</td><td>'.$Administrativo[0]["Personal"].'</td>';

						if ($Tipo[0]["Tipo"]=="CASE O CPU") {
							$computador= new computador(1);
							$grupo= new grupo(1);
							$sistema_operativo= new sistema_operativo(1);

							$computador->setAdministrativoID($Equipo[0]["administrativo_idAdministrativo"]);
							$Computador= $computador->consultarComputador();

							$grupo->setIdGrupo($Computador[0]["grupo_idGrupo"]);
							$Grupo= $grupo->consultarGrupo();

							$sistema_operativo->setID($Computador[0]["sistema_operativo_idSistema_operativo"]);
							$SO= $sistema_operativo->ConsultarSO();

							echo '<td>'.$Computador[0]["Nombre_Equipo"].'</td><td>'.$Grupo[0]["Grupo"].'</td>';
							echo '<td>'.$Computador[0]["MAC"].'</td><td>'.$Computador[0]["IP"].'</td>';
							echo '<td>'.$Computador[0]["Red"].'</td><td>'.$Computador[0]["Voz"].'</td>';
							echo '<td>'.$Status[0]["Status"].'</td><td>'.$Equipo[0]["Observaciones"].'</td>';
							echo '<td>'.$SO[0]["SO"].'</td>';
						} else {
							echo '<td>'.$Status[0]["Status"].'</td><td>'.$Equipo[0]["Observaciones"].'</td>';
						}
					?> 
				</tbody>
				
			</table>
	</div>
	<br>
	<br>
	<section>
		<div>
			<table>
				<caption>Historico de Incidencias del Equipo</caption>
				<thead>
					<tr>
						<th>Fecha de Registro de Falla</th>
						<th>Fecha de Registro de Mantenimiento</th>
						<th>Falla</th>
						<th>Descripcion</th>
						<th>Requerimientos</th>
						<th>Solventado</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$historico= new historico(1);
						$historico->setEquipoID($Equipo[0]["idEquipo"]);
						$Historicos= $historico->consultarHistoricoEquipo();

						$total = count($Historicos);

						if ($total > 10) {
							for ($i=0; $i < 9; $i++) { 
								$fallas= new fallas(1);
								$fallas->setIdFallas($Historicos[$i]["fallas_idFallas"]);
								$Falla= $fallas->consultarFallas();

								echo '<tr><td>'.$Historicos[$i]["FechaFalla"].'</td><td>'.$Historicos[$i]["FechaMantenimiento"].'</td>';
								echo '<td>'.$Falla[0]["Fallas"].'</td>';
								echo '<td>'.$Historicos[$i]["Descripcion"].'</td><td>'.$Historicos[$i]["Requerimientos"].'</td>';
								if ($Historicos[$i]["Solventado"]==0) {
									echo '<td>NO</th></tr>';
								} else {
									echo '<td>SI</th></tr>';
								}

								$fallas= NULL;
							}
						} else {
							for ($i=0; $i < $total; $i++) { 
								$fallas= new fallas(1);
								$fallas->setIdFallas($Historicos[$i]["fallas_idFallas"]);
								$Falla= $fallas->consultarFallas();

								echo '<tr><td>'.$Historicos[$i]["FechaFalla"].'</td><td>'.$Historicos[$i]["FechaMantenimiento"].'</td>';
								echo '<td>'.$Falla[0]["Fallas"].'</td>';
								echo '<td>'.$Historicos[$i]["Descripcion"].'</td><td>'.$Historicos[$i]["Requerimientos"].'</td>';
								if ($Historicos[$i]["Solventado"]==0) {
									echo '<td>NO</th></tr>';
								} else {
									echo '<td>SI</th></tr>';
								}

								$fallas= NULL;
							}
						}
					?>
				</tbody>
			</table>
		</div>
	</section>
</body>
</html>