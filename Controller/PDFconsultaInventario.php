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
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Consulta Equipos</title>
</head>
<body>
	</article>

	<article id="Tabla_Consultas">
		<div>
			<table>
				<caption>Consulta Inventario</caption>
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
						<th>Nombre Equipo</th>
						<th>Grupo</th>
						<th>MAC</th>
						<th>IP</th>
						<th>Red</th>
						<th>Voz</th>
						<th>Estado</th>
						<th>Observaciones</th>
						<th>Sistema Operativo</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						ob_start();
						require_once("cargarInventario.php");
						$html= ob_get_contents();
						ob_get_clean();
						echo $html;	
					?>
				</tbody>
			</table>
		</div>
	</article>

	<br>
	<br>
	<!--<article id="Tabla_Fallas">
		<div>
			<table>
				<caption>Fallas mas Comunes</caption>
				<thead>
					<tr>
						<th>Num</th>
						<th>Falla</th>
						<th>Porcentaje</th>
						<th>Ubicacion</th>
						<th>Equipos Afectados</th>
					</tr>
				</thead>
				<tbody>
					<?php
						/*$departamento= new departamento(1);
						$Departamentos= $departamento->consultarTodosDepartamentos();
						$array_datos=NULL;
						$FallaID=0;
						$contador=NULL;

						foreach ($Departamentos as $Departamento) {
							$fallas= new fallas(1);
							$historico= new historico(1);

							$Fallas= $fallas->consultarTodasFallas();

							foreach ($Fallas as $falla) {
								$contador=0;
								$idFalla= $falla["idFallas"];
								$FallaID=$idFalla;
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
									$administrador= NULL;
								}
								$array_datos[]= array('idDepartamento' => $Departamento["idDepartamento"], 'idfallas' => $FallaID, 'CantidadEquipos' => $contador);
							}
							$fallas= NULL;
							$historico= NULL;
						}

						$total= count($array_datos);

						for ($i=0; $i < $total; $i++) { 
							for ($j=$i+1; $j < $total; $j++) { 
								if ($array_datos[$i]["CantidadEquipos"] < $array_datos[$j]["CantidadEquipos"]) {

									$temp= $array_datos[$i];
									$array_datos[$i] = $array_datos[$j];
									$array_datos[$j] = $temp;
								}
							}
						}
						
						$equipo= new equipo(1);
						$TotalEquipos= count($equipo->consultarEquipos());
						$historico= NULL;
						$identificador=0;

						for ($i=0; $i < 5; $i++) {

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
						}*/
					?>
				</tbody>
			</table>
		</div>
	</article>-->
</body>
</html>