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

	function getConsulta() {
		
		
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

		$Consulta= '<input type="hidden" name="idEquipo" value="'.$Equipo[0]["idEquipo"].'">';
		$Consulta.= '<div class="form-row"><div class="col-md-4" align="center"><label for="Tipo">Tipo</label><input class="form-control" id="Tipo" type="text" value="'.$Tipo[0]["Tipo"].'" readonly></div>';
		$Consulta.= '<div class="col-md-4" align="center"><label for="Marca">Marca</label><input class="form-control" id="Marca" type="text" value="'.$Marca[0]["Marca"].'" readonly></div>';
		$Consulta.= '<div class="col-md-4" align="center"><label for="Modelo">Modelo</label><input class="form-control" id="Modelo" type="text" value="'.$Modelo[0]["Modelo"].'" readonly></div></div>';

		$Consulta.= '<div class="form-row" style="padding-top: 3%"><div class="col-md-4" align="center"><label for="Serial">Numero Serial</label><input class="form-control" id="Serial" type="text" value="'.$Equipo[0]["Serial"].'" readonly></div>';
		$Consulta.= '<div class="col-md-4" align="center"><label for="Chapa_Vieja">Numero Bien Nacional Chapa Vieja</label><input class="form-control" id="Chapa_Vieja" type="text" value="'.$Equipo[0]["Chapa_Vieja"].'" readonly></div>';
		$Consulta.= '<div class="col-md-4" align="center"><label for="Bien_Nacional">Numero Activo Fijo</label><input class="form-control" id="Bien_Nacional" type="text" value="'.$Equipo[0]["Bien_Nacional"].'" readonly></div></div>';

		$Consulta.= '<div class="form-row" style="padding-top: 3%"><div class="col-md-3" align="center"><label for="Sede">Sede</label><input class="form-control" id="Sede" type="text" value="'.$Sede[0]["Sede"].'" readonly></div>'; 
		$Consulta.= '<div class="col-md-3" align="center"><label for="Departamento">Departamento</label><input class="form-control" id="Departamento" type="text" value="'.$Departamento[0]["Departamento"].'" readonly></div>';
		$Consulta.= '<div class="col-md-3" align="center"><label for="Piso">Piso</label><input class="form-control" id="Piso" type="text" value="'.$Piso[0]["Piso"].'" readonly></div>';
		$Consulta.= '<div class="col-md-3" align="center"><label for="Usuario">Usuario</label><input class="form-control" id="Usuario" type="text" value="'.$Administrativo[0]["Personal"].'" readonly></div></div>';

		if ($Tipo[0]["Tipo"] == "CASE O CPU") {
			$computador= new computador(1);
			$grupo= new grupo(1);
			$sistema_operativo= new sistema_operativo(1);

			$computador->setAdministrativoID($Equipo[0]["administrativo_idAdministrativo"]);
			$Computador= $computador->consultarComputador();

			$grupo->setIdGrupo($Computador[0]["grupo_idGrupo"]);
			$Grupo= $grupo->consultarGrupo();

			$sistema_operativo->setID($Computador[0]["sistema_operativo_idSistema_operativo"]);
			$SO= $sistema_operativo->ConsultarSO();

			$Consulta.= '<div class="form-row" style="padding-top: 3%"><div class="col-md-4" align="center"><label for="Nombre_Equipo">Nombre Equipo</label><input class="form-control" id="Nombre_Equipo" type="text" value="'.$Computador[0]["Nombre_Equipo"].'" readonly></div>'; 
			$Consulta.= '<div class="col-md-4" align="center"><label for="Grupo">Grupo</label><input class="form-control" id="Grupo" type="text" value="'.$Grupo[0]["Grupo"].'" readonly></div>';
			$Consulta.= '<div class="col-md-4" align="center"><label for="SO">Sistema Operativo</label><input class="form-control" id="SO" type="text" value="'.$SO[0]["SO"].'" readonly></div></div>';

			$Consulta.= '<div class="form-row" style="padding-top: 3%"><div class="col-md-3" align="center"><label for="MAC">Direccion MAC</label><input class="form-control" id="MAC" type="text" value="'.$Computador[0]["MAC"].'" readonly></div>'; 
			$Consulta.= '<div class="col-md-3" align="center"><label for="IP">Direccion IP</label><input class="form-control" id="IP" type="text" value="'.$Computador[0]["IP"].'" readonly></div>';
			$Consulta.= '<div class="col-md-3" align="center"><label for="Red">Punto de Red</label><input class="form-control" id="Red" type="text" value="'.$Computador[0]["Red"].'" readonly></div>';
			$Consulta.= '<div class="col-md-3" align="center"><label for="Voz">Punto de Voz</label><input class="form-control" id="Voz" type="text" value="'.$Computador[0]["Voz"].'" readonly></div></div>';

			$Consulta.= '<div class="form-row" style="padding-top: 3%"><div class="col-md-8" align="center"><label for="Observaciones">Observaciones</label><textarea class="form-control" id="Observaciones" type="text"  placeholder="Observaciones" rows="3" title="Observaciones" readonly>'.$Equipo[0]["Observaciones"].'</textarea></div>';
			$Consulta.= '<div class="col-md-4" align="center"><label for="Status">Estado</label><input class="form-control" type="text" value="'.$Status[0]["Status"].'" readonly></div></div>';

			$computador= NULL;
			$grupo= NULL;
			$sistema_operativo=NULL;
		} else {
			$Consulta.= '<div class="form-row" style="padding-top: 3%"><div class="col-md-8" align="center"><label for="Observaciones">Observaciones</label><textarea class="form-control" id="Observaciones" type="text"  placeholder="Observaciones" rows="3" title="Observaciones" readonly>'.$Equipo[0]["Observaciones"].'</textarea></div>';
			$Consulta.= '<div class="col-md-4" align="center"><label for="Status">Estado</label><input class="form-control" type="text" value="'.$Status[0]["Status"].'" readonly></div></div>';
		}

		$equipo= NULL;
		$tipo= NULL;
		$marca= NULL;
		$modelo= NULL;
		$sede= NULL;
		$departamento= NULL;
		$piso= NULL;
		$administrativo= NULL;
		$status= NULL;
		
		return $Consulta;
	}

	echo getConsulta();
?>
