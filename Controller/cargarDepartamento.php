<?php 
	require_once("../Model/equipo.php");
	require_once("../Model/departamento.php");
	require_once("../Model/administrativo.php");

	function getDepartamentos() {

		if (isset($_POST["idPiso"])) {
			$idPiso= $_POST["idPiso"];

			$departamento= new departamento(1);
			$departamento->setPisoID($idPiso);
			$Departamentos= $departamento->consultarTodosDepartamentosXPiso();

			$listaDepartamentos= '<option value="0" selected disabled>Seleccionar Departamento</option>';
			foreach ($Departamentos as $Departamento) {
				$listaDepartamentos .= '<option value="'.$Departamento["idDepartamento"].'">'.$Departamento["Departamento"].'</option>';
			}
			$listaDepartamentos .= '<option value="">Otro</option>';

			$departamento= NULL;
			return $listaDepartamentos;

		} else {

			$idEquipo= $_POST["idEquipo"];

			$equipo= new equipo(1);
			$equipo->setIdEquipo($idEquipo);
			$Equipo= $equipo->seleccionarEquipo();

			$administrativo= new administrativo(1);
			$administrativo->setIdAdministrativo($Equipo[0]["administrativo_idAdministrativo"]);
			$Administrativo= $administrativo->consultarAdministrativo();

			$departamento= new departamento(1);
			$departamento->setIdDepartamento($Administrativo[0]["departamento_idDepartamento"]);
			$DepartamentoActual= $departamento->consultarDepartamento();
			$departamento->setPisoID($DepartamentoActual[0]["piso_idPiso"]);

			$Departamentos= $departamento->consultarTodosDepartamentosXPiso();

			$listaDepartamentos= '<option value="0" disabled>Seleccionar Departamento</option>';
			foreach ($Departamentos as $Departamento) {
				if ($Departamento["idDepartamento"]==$DepartamentoActual[0]["idDepartamento"]) {
					$listaDepartamentos .= '<option value="'.$Departamento["idDepartamento"].'"selected disabled>'.$Departamento["Departamento"].'</option>';
				} else {
					$listaDepartamentos .= '<option value="'.$Departamento["idDepartamento"].'">'.$Departamento["Departamento"].'</option>';
				}
				
				$listaDepartamentos .= '<option value="">Otro</option>';
			}
			$equipo= NULL;
			$administrativo= NULL;
			$departamento= NULL;
			return $listaDepartamentos;
		}
	}
	echo getDepartamentos();
?>