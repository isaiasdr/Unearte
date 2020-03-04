<?php 
	require_once("../Model/tipo.php");
	require_once("../Model/equipo.php");
	require_once("../Model/marca.php");
	require_once("../Model/modelo.php");
	require_once("../Model/sede.php");
	require_once("../Model/departamento.php");
	require_once("../Model/piso.php");
	require_once("../Model/administrativo.php");
	require_once("../Model/status.php");
	require_once("../Model/computador.php");
	require_once("../Model/grupo.php");
	require_once("../Model/sistema_operativo.php");


	function getConsulta() {
		if (isset($_SESSION['busqueda'])) {
			$busqueda= strtoupper($_SESSION['busqueda']);
			unset($_SESSION['busqueda']);
		} else {
			$busqueda= strtoupper($_POST["busqueda"]);
		}

		$Consulta='';
		if ($busqueda=='') {
			$tipo= new tipo(1);
			$equipo= new equipo(1);
			$marca= new marca(1);
			$modelo= new modelo(1);
			$sede= new sede(1);
			$departamento= new departamento(1);
			$piso= new piso(1);
			$administrativo= new administrativo(1);
			$status= new status(1);

			$TodosEquipos= $equipo->consultarEquipos();
			$i=0;
			foreach ($TodosEquipos as $equipos) {

				//contador que muestra el numero del registro del equipo
				$i++;

				$tipo->setIdTipo($equipos["tipo_idTipo"]);
				$Tipo= $tipo->consultarTipo();

				$modelo->setIdModelo($equipos["modelo_idModelo"]);
				$Modelo= $modelo->consultarModelo();
				
				$marca->setIdMarca($Modelo[0]["marca_idMarca"]);
				$Marca= $marca->consultarMarca();

				$sede->setIdSede($equipos["sede_idSede"]);
				$Sede= $sede->consultarSede();

				$administrativo->setIdAdministrativo($equipos["administrativo_idAdministrativo"]);
				$Administrativo= $administrativo->consultarAdministrativo();

				$departamento->setIdDepartamento($Administrativo[0]["departamento_idDepartamento"]);
				$Departamento= $departamento->consultarDepartamento();

				$piso->setIdPiso($Departamento[0]["piso_idPiso"]);
				$Piso= $piso->consultarPiso();

				$status->setIdStatus($equipos["status_idStatus"]);
				$Status= $status->consultarStatus();

				$Consulta.= '<tr><td><a class="btn btn-outline-secondary" href="consultaEquipo.php?idEquipo='.$i.'" role="button">'.$i."</a></td>";
				$Consulta.= "<td>".$Tipo[0]["Tipo"]."</td><td>".$Marca[0]["Marca"]."</td>";
				$Consulta.= "<td>".$Modelo[0]["Modelo"]."</td><td>".$equipos["Serial"]."</td>";
				$Consulta.= "<td>".$equipos["Chapa_Vieja"]."</td><td>".$equipos["Bien_Nacional"]."</td>";
				$Consulta.= "<td>".$Sede[0]["Sede"]."</td><td>".$Departamento[0]["Departamento"]."</td>";
				$Consulta.= "<td>".$Piso[0]["Piso"]."</td><td>".$Administrativo[0]["Personal"]."</td>";

				if ($Tipo[0]["Tipo"]== "CASE O CPU") {
					$computador= new computador(1);
					$grupo= new grupo(1);
					$sistema_operativo= new sistema_operativo(1);$grupo= new grupo(1);

					$computador->setAdministrativoID($equipos["administrativo_idAdministrativo"]);
					$Computador= $computador->consultarComputador();

					$grupo->setIdGrupo($Computador[0]["grupo_idGrupo"]);
					$Grupo= $grupo->consultarGrupo();

					$sistema_operativo->setID($Computador[0]["sistema_operativo_idSistema_operativo"]);
					$SO= $sistema_operativo->consultarSO();

					$Consulta.= "<td>".$Computador[0]["Nombre_Equipo"]."</td><td>".$Grupo[0]["Grupo"]."</td>";
					$Consulta.= "<td>".$Computador[0]["MAC"]."</td><td>".$Computador[0]["IP"]."</td>";
					$Consulta.= "<td>".$Computador[0]["Red"]."</td><td>".$Computador[0]["Voz"]."</td>";
					$Consulta.= "<td>".$Status[0]["Status"]."</td><td>".$equipos["Observaciones"]."</td>";
					$Consulta.= "<td>".$SO[0]["SO"]."</td></tr>";

					$computador= NULL;
					$grupo= NULL;
					$sistema_operativo= NULL;
				} else {
					$Consulta.= "<td></td><td></td><td></td><td></td><td></td><td></td>";
					$Consulta.= "<td>".$Status[0]["Status"]."</td><td>".$equipos["Observaciones"]."</td>";
					$Consulta.= "<td></td></tr>";
				}
			}
			$tipo= NULL;
			$equipo= NULL;
			$marca= NULL;
			$modelo= NULL;
			$sede= NULL;
			$departamento= NULL;
			$piso= NULL;
			$administrativo= NULL;
			$status= NULL;

			return $Consulta;
		} else {
		
			$tipo= new tipo(1);
			$equipo= new equipo(1);
			$marca= new marca(1);
			$modelo= new modelo(1);
			$sede= new sede(1);
			$departamento= new departamento(1);
			$piso= new piso(1);
			$administrativo= new administrativo(1);
			$status= new status(1);

			$TodosEquipos= $equipo->consultarEquipos();
			$i=0;
			foreach ($TodosEquipos as $equipos) {

				//contador que muestra el numero del registro del equipo
				$i++;

				$tipo->setIdTipo($equipos["tipo_idTipo"]);
				$Tipo= $tipo->consultarTipo();

				$modelo->setIdModelo($equipos["modelo_idModelo"]);
				$Modelo= $modelo->consultarModelo();
				
				$marca->setIdMarca($Modelo[0]["marca_idMarca"]);
				$Marca= $marca->consultarMarca();

				$sede->setIdSede($equipos["sede_idSede"]);
				$Sede= $sede->consultarSede();

				$administrativo->setIdAdministrativo($equipos["administrativo_idAdministrativo"]);
				$Administrativo= $administrativo->consultarAdministrativo();

				$departamento->setIdDepartamento($Administrativo[0]["departamento_idDepartamento"]);
				$Departamento= $departamento->consultarDepartamento();

				$piso->setIdPiso($Departamento[0]["piso_idPiso"]);
				$Piso= $piso->consultarPiso();

				$status->setIdStatus($equipos["status_idStatus"]);
				$Status= $status->consultarStatus();

				if ($Departamento[0]["Departamento"]==$busqueda || $Piso[0]["Piso"]== $busqueda || $Tipo[0]["Tipo"]==$busqueda || $equipos["Serial"]==$busqueda || $equipos["Bien_Nacional"]==$busqueda) {
					$Consulta.= '<tr><td><a class="btn btn-outline-secondary" href="consultaEquipo.php?idEquipo='.$i.'" role="button">'.$i."</a></td>";
					$Consulta.= "<td>".$Tipo[0]["Tipo"]."</td><td>".$Marca[0]["Marca"]."</td>";
					$Consulta.= "<td>".$Modelo[0]["Modelo"]."</td><td>".$equipos["Serial"]."</td>";
					$Consulta.= "<td>".$equipos["Chapa_Vieja"]."</td><td>".$equipos["Bien_Nacional"]."</td>";
					$Consulta.= "<td>".$Sede[0]["Sede"]."</td><td>".$Departamento[0]["Departamento"]."</td>";
					$Consulta.= "<td>".$Piso[0]["Piso"]."</td><td>".$Administrativo[0]["Personal"]."</td>";

					if ($Tipo[0]["Tipo"]== "CASE O CPU") {
						$computador= new computador(1);
						$grupo= new grupo(1);
						$sistema_operativo= new sistema_operativo(1);$grupo= new grupo(1);

						$computador->setAdministrativoID($equipos["administrativo_idAdministrativo"]);
						$Computador= $computador->consultarComputador();

						$grupo->setIdGrupo($Computador[0]["grupo_idGrupo"]);
						$Grupo= $grupo->consultarGrupo();

						$sistema_operativo->setID($Computador[0]["sistema_operativo_idSistema_operativo"]);
						$SO= $sistema_operativo->consultarSO();

						$Consulta.= "<td>".$Computador[0]["Nombre_Equipo"]."</td><td>".$Grupo[0]["Grupo"]."</td>";
						$Consulta.= "<td>".$Computador[0]["MAC"]."</td><td>".$Computador[0]["IP"]."</td>";
						$Consulta.= "<td>".$Computador[0]["Red"]."</td><td>".$Computador[0]["Voz"]."</td>";
						$Consulta.= "<td>".$Status[0]["Status"]."</td><td>".$equipos["Observaciones"]."</td>";
						$Consulta.= "<td>".$SO[0]["SO"]."</td></tr>";

						$computador= NULL;
						$grupo= NULL;
						$sistema_operativo= NULL;
					} else {
						$Consulta.= "<td></td><td></td><td></td><td></td><td></td><td></td>";
						$Consulta.= "<td>".$Status[0]["Status"]."</td><td>".$equipos["Observaciones"]."</td>";
						$Consulta.= "<td></td></tr>";
					}
				}
			}
			$tipo= NULL;
			$equipo= NULL;
			$marca= NULL;
			$modelo= NULL;
			$sede= NULL;
			$departamento= NULL;
			$piso= NULL;
			$administrativo= NULL;
			$status= NULL;

			return $Consulta;	
		}
	}
	echo getConsulta();
?>
