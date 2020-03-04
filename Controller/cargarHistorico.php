<?php
	require_once("../Model/equipo.php");
	require_once("../Model/historico.php");
	require_once("../Model/fallas.php");

	function getHistorico() {

		if (isset($_SESSION['idEquipo'])) {
			$numEquipo= $_SESSION['idEquipo']-1;
			unset($_SESSION['idEquipo']);
		} else {
			$numEquipo= $_POST["idEquipo"]-1;
		}

		$equipo= new equipo(1);
		$Equipos= $equipo->consultarEquipos();

		if ($numEquipo < 0 || $numEquipo > count($Equipos)) {
			$equipo= NULL;
			return '';
		}

		$equipo->setIdEquipo($Equipos[$numEquipo]["idEquipo"]);
		$Equipo= $equipo->seleccionarEquipo();

		$historico= new historico(1);
		$historico->setEquipoID($Equipo[0]["idEquipo"]);
		$Historicos= $historico->consultarHistoricoEquipo();

		$tablaHistorico= '';

		if (!empty($Historicos)) {
			foreach ($Historicos as $datos) {

				$fallas= new fallas(1);
				$fallas->setIdFallas($datos["fallas_idFallas"]);
				$Falla= $fallas->consultarFallas();

				//$tablaHistorico.= '<input type="hidden" name="idHistorico" value="'.$datos["idHistorico"].'">';
				$tablaHistorico.= '<tr><td>'.$datos["FechaFalla"].'</td><td>'.$datos["FechaMantenimiento"].'</td>';
				$tablaHistorico.='<td>'.$Falla[0]["Fallas"].'</td>';
				$tablaHistorico.= '<td>'.$datos["Descripcion"].'</td><td>'.$datos["Requerimientos"].'</td>';
				if ($datos["Solventado"]==0) {
					$tablaHistorico.='<td>NO</td>';
					$tablaHistorico.='<td><button class="btn btn-outline-secondary" type="submit" name="Mantenimiento" value= "'.$datos["idHistorico"].'">Mantenimiento</button></td></tr>';
				} else {
					$tablaHistorico.= '<td>SI</td><td></td></tr>';
				}

				$fallas= NULL;
			}
		}
		
		$historico= NULL;
		$equipo= NULL;

		return $tablaHistorico;
	}

	echo getHistorico();
 ?>