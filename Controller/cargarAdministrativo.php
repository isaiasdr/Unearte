<?php 
	require_once("../Model/equipo.php");
	require_once("../Model/administrativo.php");

	function getAdministrativos() {

		if (isset($_POST["idDepartamento"])) {
			$idDepartamento= $_POST["idDepartamento"];

			$administrativo= new administrativo(1);
			$administrativo->setDepartamentoID($idDepartamento);
			$Administrativos= $administrativo->consultarTodosAdministrativoXDepartamento();

			$listaAdministrativos= '<option value="0" selected disabled>Seleccionar Usuario</option>';
			foreach ($Administrativos as $Administrativo) {
				$listaAdministrativos .= '<option value="'.$Administrativo["idAdministrativo"].'">'.$Administrativo["Personal"].'</option>';
			}
			$listaAdministrativos .= '<option value="">Otro</option>';

			$administrativo= NULL;
			return $listaAdministrativos;

		} else {

			$idEquipo= $_POST["idEquipo"];

			$equipo= new equipo(1);
			$equipo->setIdEquipo($idEquipo);
			$Equipo= $equipo->seleccionarEquipo();

			$administrativo= new administrativo(1);
			$administrativo->setIdAdministrativo($Equipo[0]["administrativo_idAdministrativo"]);
			$AdministrativoActual= $administrativo->consultarAdministrativo();
			$administrativo->setDepartamentoID($AdministrativoActual[0]["departamento_idDepartamento"]);

			$Administrativos= $administrativo->consultarTodosAdministrativoXDepartamento();

			$listaAdministrativos= '<option value="0" disabled>Seleccionar Usuario</option>';
			foreach ($Administrativos as $Administrativo) {
				$listaAdministrativos .= '<option value="'.$Administrativo["idAdministrativo"].'">'.$Administrativo["Personal"].'</option>';
			}
			$listaAdministrativos .= '<option value="">Otro</option>';
			$equipo= NULL;
			$administrativo= NULL;
			$departamento= NULL;
			return $listaAdministrativos;
		}
	}
	echo getAdministrativos();
?>