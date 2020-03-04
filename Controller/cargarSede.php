<?php 
	require_once("../Model/sede.php");
	require_once("../Model/equipo.php");

	function getSedes() {

		$idEquipo= $_POST["idEquipo"];

		$equipo= new equipo(1);
		$equipo->setIdEquipo($idEquipo);
		$Equipo= $equipo->seleccionarEquipo();

		$sede= new sede(1);
		$Sedes= $sede->consultarTodosSedes();

		$listaSedes= '<option value="0" disabled>Seleccionar Sede</option>';
		foreach ($Sedes as $Sede) {
			$listaSedes .= '<option value="'.$Sede["idSede"].'">'.$Sede["Sede"].'</option>';
		}
		$listaSedes .= '<option value="">Otro</option>';

		$sede= NULL;
		$equipo= NULL;
		return $listaSedes;
	}
	echo getSedes();
?>