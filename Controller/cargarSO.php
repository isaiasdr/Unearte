<?php 
	require_once("../Model/equipo.php");
	//require_once("../Model/administrativo.php");
	require_once("../Model/computador.php");
	require_once("../Model/sistema_operativo.php");

	function getGrupos() {

		if (isset($_POST["idEquipo"])) {

			$idEquipo= $_POST["idEquipo"];

			$equipo= new equipo(1);
			$equipo->setIdEquipo($idEquipo);
			$Equipo= $equipo->seleccionarEquipo();

			$computador= new computador(1);
			$computador->setAdministrativoID($Equipo[0]["administrativo_idAdministrativo"]);
			$Computador= $computador->consultarComputador();

			$sistema_operativo= new sistema_operativo(1);
			$sistema_operativo->setID($Computador[0]["sistema_operativo_idSistema_operativo"]);
			$SOActual= $sistema_operativo->consultarSO();
			$SOS= $sistema_operativo->consultarTodosSO();

			$listaSOS= '<option value="0" disabled>Seleccionar Sistema Operativo</option>';
			foreach ($SOS as $SO) {
				if ($SOActual[0]["SO"]==$SO["SO"]) {
					$listaSOS .= '<option value="'.$SO["idSistema_operativo"].'" selected>'.$SO["SO"].'</option>';
				} else {
					$listaSOS .= '<option value="'.$SO["idSistema_operativo"].'">'.$SO["SO"].'</option>';
				}
			}
			$listaSOS .= '<option value="">Otro</option>';

			$piso= NULL;
			$equipo= NULL;
			$administrativo= NULL;
			$departamento= NULL;
			return $listaSOS;

		} else {
			
			$sistema_operativo= new sistema_operativo(1);
			$SOS= $sistema_operativo->consultarTodosSO();

			$listaSOS= '<option value="0" selected disabled>Seleccionar Sistema Operativo </option>';
			foreach ($SOS as $SO) {
				$listaSOS .= '<option value="'.$SO["idSistema_operativo"].'">'.$SO["SO"].'</option>';
			}
			$listaSOS .= '<option value="">Otro</option>';

			$sistema_operativo= NULL;
			return $listaSOS;

		}
	}
	echo getGrupos();
?>