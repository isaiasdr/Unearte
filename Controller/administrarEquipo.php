<?php 
	require_once("../Model/registros.php");
	require_once("../Model/evento.php");
	require_once("../Model/equipo.php");
	require_once("../Model/historico.php");
	require_once("../Model/fallas.php");
	require_once("../Model/status.php");
	require_once("../Model/sede.php");
	require_once("../Model/tipo.php");
	require_once("../Model/administrativo.php");
	require_once("../Model/departamento.php");
	require_once("../Model/computador.php");
	require_once("../Model/grupo.php");
	require_once("../Model/piso.php");
	require_once("../Model/sistema_operativo.php");
	session_start();

	if (isset($_SESSION['Ultima_Actividad']) && (time() - $_SESSION['Ultima_Actividad'])>60*10) {
		redireccionar("../Views/cerrarSesion.php");
	}

	if(isset($_SESSION['Username'])) {
		$UsuarioActivo= $_SESSION['Username'];
		$RolUsuario= $_SESSION['clases_usuario_idClase'];
	} else {
		redireccionar("../Views/login.php");
		//
	}

	if (isset($_POST['Desincorporar'])) {
		$desincorporar= $_POST['Desincorporar'];
	} else {
		$desincorporar= false;
	}

	if (isset($_POST['registrar_Falla'])) {
		$registrarFalla= $_POST['registrar_Falla'];
	} else {
		$registrarFalla= false;
	}
	
	if (isset($_POST['Actualizar'])) {
		$actualizar= $_POST['Actualizar'];
	} else {
		$actualizar= false;
	}

	if (isset($_POST['EquipoID'])) {
		$_SESSION['idEquipo']= $_POST['EquipoID'];
		redireccionar("../Controller/generarPDFConsulta.php");
	}

	if ($actualizar == "Actualizar") {

		$_SESSION["idEquipo"]= $_POST["idEquipo"];
		redireccionar("../Views/actualizarEquipo.php");

	} elseif ($actualizar == "actualizar") {

		$idEquipo= $_POST['idEquipo'];
		$Chapa_Vieja= $_POST['Chapa_Vieja'];
		$Bien_Nacional= $_POST['Bien_Nacional'];
		$Observaciones= strtoupper(utf8_encode($_POST['Observaciones']));

		$equipo= new equipo(1);
		
		$Sede= $_POST['Sede'];
		if (is_numeric($Sede)) {
			$equipo->setSedeID($Sede);
		} else {
			$sede= new sede(1);
			$sede->setSede(strtoupper(utf8_encode($_POST["Sede"])));
			$idSede= $sede->consultarID();
			if (empty($idSede)) {
				$sede->añadirSede();
				$idSede= $sede->consultarID();
			}
			$Sede= $idSede[0]["idSede"];
			$sede= NULL;

			$equipo->setSedeID($Sede);
		}

		$Departamento= $_POST["Departamento"];
		if (!is_numeric($Departamento)) {
			$piso= new piso(1);
			$piso->setPiso($_POST["Piso"]);
			$idPiso= $piso->consultarID();
			if (empty($idPiso)) {
				$piso->añadirPiso();
				$idPiso= $piso->consultarID();
			}
			$Piso= $idPiso[0]["idPiso"];
			$piso= NULL;

			$departamento= new departamento(1);
			$departamento->setPisoID($Piso);
			$departamento->setDepartamento(strtoupper(utf8_encode($_POST["Departamento"])));
			$idDepartamento= $departamento->consultarID();
			if (empty($idDepartamento)) {
				$departamento->añadirDepartamento();
				$idDepartamento= $departamento->consultarID();
			}
			$Departamento= $idDepartamento[0]["idDepartamento"];
			$departamento= NULL;
		}
		
		$Personal= $_POST["Administrativo"];
		if (is_numeric($Personal)) {
			$equipo->setAdministrativoID($Personal);
		} else {
			$administrativo= new administrativo(1);
			$administrativo->setDepartamentoID($Departamento);
			$administrativo->setPersonal(strtoupper(utf8_encode($_POST["Administrativo"])));
			$idAdministrativo= $administrativo->consultarID();
			if (empty($idAdministrativo)) {
				$administrativo->añadirAdministrativo();
				$idAdministrativo= $administrativo->consultarID();
			}
			$Personal= $idAdministrativo[0]["idAdministrativo"];
			$administrativo= NULL;

			$equipo->setAdministrativoID($Personal);
		}

		$equipo->setIdEquipo($idEquipo);
		$equipo->setChapa_Vieja($Chapa_Vieja);
		$equipo->setBien_Nacional($Bien_Nacional);
		$equipo->setObservaciones($Observaciones);
		$exitoEquipo= $equipo->actualizarEquipo();

		if ($_POST['Tipo']=="CASE O CPU") {
			$computador= new computador(1);

			$Grupo= $_POST['Grupo'];
			if (is_numeric($Grupo)) {
				$computador->setGrupoID($Grupo);
			} else {
				$grupo= new grupo(1);
				$grupo->setGrupo(strtoupper(utf8_encode($_POST['Grupo'])));
				$idGrupo= $grupo->consultarID();
				if (empty($idGrupo)) {
					$grupo->añadirGrupo();
					$idGrupo= $grupo->consultarID();
				}
				$Grupo= $idGrupo[0]["idGrupo"];
				$grupo= NULL;

				$computador->setGrupoID($Grupo);
			}

			$SO= $_POST['SO'];
			if (is_numeric($SO)) {
				$computador->setSOID($SO);
			} else {
				$sistema_operativo= new sistema_operativo(1);
				$sistema_operativo->setSO(strtoupper(utf8_encode($_POST['SO'])));
				$idSO= $sistema_operativo->consultarID();
				if (empty($idSO)) {
					$sistema_operativo->añadirSO();
					$idSO= $sistema_operativo->consultarID();
				}
				$SO= $idSO[0]["idSistema_operativo"];
				$sistema_operativo= NULL;

				$computador->setSOID($SO);
			}
			
			$IP= strtoupper($_POST['IP']);
			$Red= strtoupper($_POST['Red']);
			$Voz= strtoupper($_POST['Voz']);

			$Nombre_Equipo= strtoupper(utf8_encode($_POST['Nombre_Equipo']));
			$computador->setNombre_Equipo($Nombre_Equipo);
			$computador->setIP($IP);
			$computador->setRed($Red);
			$computador->setVoz($Voz);
			
			$computador->setAdministrativoID($Personal);
			$exitoComputador= $computador->actualizarComputador();

			$computador= NULL;
			$grupo= NULL;
			$sistema_operativo= NULL;
		}

		//se crea el registro
		$registros= new registros(1);
		$registros->setUsuario($UsuarioActivo);
		$registros->setFecha(date("Y-m-d H:i:s"));
		$descripcion= "Actualizacion del Equipo (idEquipo): ".$idEquipo." Realizado por Usuario: ".utf8_encode($UsuarioActivo);
		$registros->setDescripcion($descripcion);

		$evento= new evento(1);
		$evento->setEvento("Actualizacion Equipo");
		$Evento= $evento->consultarIDEvento();

		if (empty($Evento)) {
			$exitoEvento= $evento->añadirEvento();
			if ($exitoEvento) {
				$Evento= $evento->consultarIDEvento();
			} else {
				//mostrar error?
			}
		}
		$registros->setEventoID($Evento[0]["idEvento"]);
		$exitoRegistro= $registros->crearRegistro();

		$registros= NULL;
		$evento= NULL;
		$sede= NULL;
		$administrativo= NULL;
		$departamento= NULL;
		$piso= NULL;
		$administrativo= NULL;

		$contador= 0;
		$equipo= new equipo(1);
		$TotalEquipos= $equipo->consultarEquipos();
		foreach ($TotalEquipos as $Individual) {
			if ($Individual["idEquipo"]==$idEquipo) {
				break;
			}
			$contador++;
		}
		$equipo=NULL;

		if ($exitoEquipo) {
			redireccionar("../Views/consultaEquipo.php?idEquipo=".($contador+1));
		} else {
			//mostrar un mensaje de error y redireccionar a../Views/ consultarEquipo.php
			redireccionar("../Views/inicio.php");
		}
	}

	if ($desincorporar) {

		$idEquipo= $_POST["idEquipo"];
		$equipo= new equipo(1);
		$equipo->setIdEquipo($idEquipo);
		$Equipo= $equipo->seleccionarEquipo();

		$idStatus= $Equipo[0]["status_idStatus"];
		$status= new status(1);
		$status->setIdStatus($idStatus);
		$Status= $status->consultarStatus();
		$status= NULL;

		if ($Status[0]["Status"]=="DESINCORPORADO") {
			redireccionar("../Views/inicio.php");
		} else {
			$status= new status(1);
			$status->setStatus("DESINCORPORADO");
			$idStatus= $status->consultarID();
			$Status= NULL;

			if (empty($idStatus)) {
				$status->añadirStatus();
				$idStatus= $status->consultarID();
				$Status= $idStatus[0]["idStatus"];
			} else {
				$Status= $idStatus[0]["idStatus"];
			}

			$equipo->setStatusID($Status);
			$equipo->setObservaciones($Equipo[0]["Observaciones"]);
			$exitoEquipo= $equipo->actualizarStatusEquipo();
			$equipo= NULL;

			if ($exitoEquipo) {
				//se crea el registro
				$registros= new registros(1);
				$registros->setUsuario($UsuarioActivo);
				$registros->setFecha(date("Y-m-d H:i:s"));
				$descripcion= "Desincorporacion del Equipo (idEquipo):".$idEquipo." y (Serial): ".$Equipo[0]["Serial"]." Realizado por Usuario: ".utf8_encode($UsuarioActivo);
				$registros->setDescripcion($descripcion);

				$evento= new evento(1);
				$evento->setEvento("Desincorporar Equipo");
				$Evento= $evento->consultarIDEvento();

				if (empty($Evento)) {
					$exitoEvento= $evento->añadirEvento();
					if ($exitoEvento) {
						$Evento= $evento->consultarIDEvento();
					} else {
						//mostrar error?
					}
				}
				$registros->setEventoID($Evento[0]["idEvento"]);
				$exitoRegistro= $registros->crearRegistro();
				$registros= NULL;
				$evento= NULL;

				$contador= 0;
				$equipo= new equipo(1);
				$Equipos= $equipo->consultarEquipos();
				foreach ($Equipos as $Equipo) {
					if ($Equipo["idEquipo"]==$idEquipo) {
						break;
					}
					$contador++;
				}
				$equipo=NULL;
				redireccionar("../Views/consultaEquipo.php?idEquipo=".($contador+1));
			} else {
				//mostrar un mensaje de error y redeccionar a consultarEquipo.php
				redireccionar("../Views/inicio.php");
			}
		}
	}

	if ($registrarFalla == "registrar_Falla") {

		$_SESSION["idEquipo"]= $_POST["idEquipo"];
		redireccionar("../Views/registrarFallaEquipo.php");

	} elseif ($registrarFalla == "falla_Registrada") {
		
		$idEquipo= $_POST['idEquipo'];
		$Observaciones= strtoupper(utf8_encode($_POST["Observaciones"]));
		$Descripcion= strtoupper(utf8_encode($_POST["Descripcion"]));
		$Requerimientos= strtoupper(utf8_encode($_POST["Requerimientos"]));
		
		$equipo= new equipo(1);
		$historico= new historico(1);

		$equipo->setIdEquipo($idEquipo);

		$idStatus= $_POST["Status"];
		if (is_numeric($idStatus)) {
			$equipo->setStatusID($idStatus);
		} else {
			$status= new status(1);
			$status->setStatus(strtoupper(utf8_encode($_POST["Status"])));
			if (strtoupper(utf8_encode($_POST["Status"]))=="DESINCORPORADO") {
				$equipo= NULL;
				$status= NULL;
				$historico=NULL;
				redireccionar("../Views/inicio.php");
			}
			$idStatus= $status->consultarID();
			if (empty($idStatus)) {
				$status->añadirStatus();
				$idStatus= $status->consultarID();
			}
			$Status= $idStatus[0]["idStatus"];
			$status= NULL;

			$equipo->setStatusID($Status);
		}
		
		$equipo->setObservaciones($Observaciones);

		$historico->setDescripcion(utf8_encode($Descripcion));
		$historico->setEquipoID($idEquipo);
		$actual= date("Y-m-d H:i:s");
		$historico->setFechaFalla($actual);
		$historico->setFechaMantenimiento(NULL);
		$historico->setRequerimientos(utf8_encode($Requerimientos));
		$historico->setSolventado(0);

		if (is_numeric($_POST["Fallas"])) {
			$idFallas= $_POST["Fallas"];
			$historico->setFallasID($idFallas);
		} else {
			$Fallas= $_POST["Fallas"];
			$fallas= new fallas(1);
			$fallas->setFallas(strtoupper(utf8_encode($Fallas)));
			$idFallas= $fallas->consultarID();
			if (empty($idFallas)) {
				$fallas->registrarFalla();
				$idFallas=$fallas->consultarID();
			}
			
			$historico->setFallasID($idFallas[0]["idFallas"]);
			$fallas= NULL;
		}

		$exitoHistorico= $historico->añadirHistorico();
		$exitoStatusEquipo= $equipo->actualizarStatusEquipo();
		
		if ($exitoHistorico && $exitoStatusEquipo) {

			//se crea el registro
			$registros= new registros(1);
			$evento= new evento(1);

			$registros->setUsuario($UsuarioActivo);
			$registros->setFecha(date("Y-m-d H:i:s"));

			$descripcion= "Reporte de Falla del Equipo (idEquipo): ".$idEquipo." Realizado por Usuario: ".utf8_encode($UsuarioActivo);
			$evento->setEvento("Reporte de Falla");

			$registros->setDescripcion($descripcion);

			$Evento= $evento->consultarIDEvento();

			if (empty($Evento)) {
				$exitoEvento= $evento->añadirEvento();
				if ($exitoEvento) {
					$Evento= $evento->consultarIDEvento();
				} else {
					//mostrar error?
				}
			}
			$registros->setEventoID($Evento[0]["idEvento"]);
			$exitoRegistro= $registros->crearRegistro();

			$registros= NULL;
			$evento= NULL;

			$contador= 0;
			$equipo= new equipo(1);
			$Equipos= $equipo->consultarEquipos();
			foreach ($Equipos as $Equipo) {
				if ($Equipo["idEquipo"]==$idEquipo) {
					break;
				}
				$contador++;
			}
			$equipo=NULL;
			redireccionar("../Views/consultaEquipo.php?idEquipo=".($contador+1));

		} else {
			redireccionar("../Views/inicio.php");
		}
	}
?>