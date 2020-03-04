<?php 
	require_once("../Model/equipo.php");
	require_once("../Model/historico.php");
	require_once("../Model/fallas.php");
	require_once("../Model/administrativo.php");
	require_once("../Model/departamento.php");

	function getIncidencias() {
		$falla = new fallas(1);
		$Fallas= $falla->consultarTodasFallas();

		$tablaIncidencias= '';
		$contador=0;

		foreach ($Fallas as $Falla) {

			$historico= new historico(1);
			$idFalla= $Falla["idFallas"];
			$historico->setFallasID($idFalla);
			$historico->setSolventado(0);
			$Historicos= $historico->historicosPorFalla();	

			foreach ($Historicos as $Historico) {
				$contador++;
				$equipo= new equipo(1);
				$equipo->setIdEquipo($Historico["equipo_idEquipo"]);
				$Equipo= $equipo->seleccionarEquipo();
				$administrativo= new administrativo(1);
				$administrativo->setIdAdministrativo($Equipo[0]["administrativo_idAdministrativo"]);
				$Administrativo= $administrativo->consultarAdministrativo();
				$departamento= new departamento(1);
				$departamento->setIdDepartamento($Administrativo[0]["departamento_idDepartamento"]);
				$Departamento= $departamento->consultarDepartamento();

				$contadorEquipo= 0;
				$TotalEquipos= $equipo->consultarEquipos();
				foreach ($TotalEquipos as $Individual) {
					if ($Individual["idEquipo"]==$Historico["equipo_idEquipo"]) {
						break;
					}
					$contadorEquipo++;
				}

				$tablaIncidencias.= '<tr><td>'.$contador.'</td><td><a class="btn btn-outline-secondary" href="consultaEquipo.php?idEquipo='.($contadorEquipo+1).'" rol="button">'.($contadorEquipo+1).'</td>';
				$tablaIncidencias.='<td>'.$Equipo[0]["Serial"].'</td><td>'.$Equipo[0]["Bien_Nacional"].'</td>';
				$tablaIncidencias.= '<td>'.$Departamento[0]["Departamento"].'</td><td>'.$Falla["Fallas"].'</td>';
				$tablaIncidencias.= '<td>'.$Historico["Requerimientos"].'</td></tr>';

				$equipo= NULL;
				$administrativo= NULL;
				$departamento= NULL;
			}
			$historico= NULL;
		}
		$falla= NULL;
		return $tablaIncidencias;
	}

	echo getIncidencias();
?>