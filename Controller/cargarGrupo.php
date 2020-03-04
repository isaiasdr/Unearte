<?php 
	require_once("../Model/equipo.php");
	//require_once("../Model/administrativo.php");
	require_once("../Model/computador.php");
	require_once("../Model/grupo.php");

	function getGrupos() {

		if (isset($_POST["idEquipo"])) {

			$idEquipo= $_POST["idEquipo"];

			$equipo= new equipo(1);
			$equipo->setIdEquipo($idEquipo);
			$Equipo= $equipo->seleccionarEquipo();

			$computador= new computador(1);
			$computador->setAdministrativoID($Equipo[0]["administrativo_idAdministrativo"]);
			$Computador= $computador->consultarComputador();

			$grupo= new grupo(1);
			$grupo->setIdGrupo($Computador[0]["grupo_idGrupo"]);
			$GrupoActual= $grupo->consultarGrupo();
			$Grupos= $grupo->consultarTodosGrupos();

			$listaGrupos= '<option value="0" disabled>Seleccionar Grupo</option>';
			foreach ($Grupos as $Grupo) {
				if ($GrupoActual[0]["Grupo"]==$Grupo["Grupo"]) {
					$listaGrupos .= '<option value="'.$Grupo["idGrupo"].'" selected>'.$Grupo["Grupo"].'</option>';
				} else {
					$listaGrupos .= '<option value="'.$Grupo["idGrupo"].'">'.$Grupo["Grupo"].'</option>';
				}
			}
			$listaGrupos .= '<option value="">Otro</option>';

			$equipo= NULL;
			$computador= NULL;
			$grupo= NULL;
			return $listaGrupos;

		} else {
			
			$grupo= new grupo(1);
			$Grupos= $grupo->consultarTodosGrupos();

			$listaGrupos= '<option value="0" selected disabled>Seleccionar Grupo </option>';
			foreach ($Grupos as $Grupo) {
				$listaGrupos .= '<option value="'.$Grupo["idGrupo"].'">'.$Grupo["Grupo"].'</option>';
			}
			$listaGrupos .= '<option value="">Otro</option>';

			$grupo= NULL;
			return $listaGrupos;

		}
	}
	echo getGrupos();
?>