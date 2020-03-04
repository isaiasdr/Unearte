<?php 
	require_once("../Model/piso.php");
	require_once("../Model/equipo.php");
	require_once("../Model/departamento.php");
	require_once("../Model/administrativo.php");

	function getPisos() {

		if (isset($_POST["idEquipo"])) {

			$idEquipo= $_POST["idEquipo"];

			$equipo= new equipo(1);
			$equipo->setIdEquipo($idEquipo);
			$Equipo= $equipo->seleccionarEquipo();

			$administrativo= new administrativo(1);
			$administrativo->setIdAdministrativo($Equipo[0]["administrativo_idAdministrativo"]);
			$Administrativo= $administrativo->consultarAdministrativo();

			$departamento= new departamento(1);
			$departamento->setIdDepartamento($Administrativo[0]["departamento_idDepartamento"]);
			$Departamento= $departamento->consultarDepartamento();

			$piso= new piso(1);
			$piso->setIdPiso($Departamento[0]["piso_idPiso"]);
			$PisoActual= $piso->consultarPiso();
			$Pisos= $piso->consultarTodosPisos();

			$listaPisos= '<option value="0" disabled>Seleccionar Piso</option>';
			foreach ($Pisos as $Piso) {
				if ($PisoActual[0]["Piso"]==$Piso["Piso"]) {
					$listaPisos .= '<option value="'.$Piso["idPiso"].'" selected>'.$Piso["Piso"].'</option>';
				} else {
					$listaPisos .= '<option value="'.$Piso["idPiso"].'">'.$Piso["Piso"].'</option>';
				}
			}
			$listaPisos .= '<option value="">Otro</option>';

			$piso= NULL;
			$equipo= NULL;
			$administrativo= NULL;
			$departamento= NULL;
			return $listaPisos;

		} else {
			
			$piso= new piso(1);
			$Pisos= $piso->consultarTodosPisos();

			$listaPisos= '<option value="0" selected disabled>Seleccionar Piso </option>';
			foreach ($Pisos as $Piso) {
				$listaPisos .= '<option value="'.$Piso["idPiso"].'">'.$Piso["Piso"].'</option>';
			}
			$listaPisos .= '<option value="">Otro</option>';

			$piso= NULL;
			return $listaPisos;

		}
	}
	echo getPisos();
?>