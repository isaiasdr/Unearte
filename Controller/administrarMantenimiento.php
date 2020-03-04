<?php
	require_once("../Model/registros.php");
	require_once("../Model/evento.php");
	require_once("../Model/equipo.php");
	require_once("../Model/historico.php");
	require_once("../Model/fallas.php");
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

	//solo puede acceder a estas funciones el administrador del sistema
	if ($RolUsuario != 1) {
		redireccionar("../Views/inicio.php");
	}
	
	if (isset($_POST['Mantenimiento'])) {
		$mantenimiento= $_POST['Mantenimiento'];
	} else {
		redireccionar("../Views/consultaEquipo.php");
	}

	if (is_numeric($mantenimiento)) {

		$_SESSION['idHistorico']= $_POST['Mantenimiento'];
		redireccionar('../Views/registrarMantenimientoEquipo.php');

	} elseif ($mantenimiento=="Mantenimiento_Registrado" ) {
		$idEquipo= $_POST["idEquipo"];
		$equipo= new equipo(1);
		$equipo->setIdEquipo($idEquipo);

		$Observaciones= strtoupper(utf8_encode($_POST["Observaciones"]));
		$equipo->setObservaciones($Observaciones);

		$idStatus= $_POST["Status"];
		if (is_numeric($idStatus)) {
			$equipo->setStatusID($idStatus);
		} else {
			$status= new status(1);
			$status->setStatus(strtoupper(utf8_encode($_POST["Status"])));
			if (strtoupper(utf8_encode($_POST["Status"]))=="DESINCORPORADO") {
				$equipo= NULL;
				$status= NULL;
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

		$historico= new historico(1);
		$idHistorico= $_POST["idHistorico"];
		$historico->setIdhistorico($idHistorico);
		$historico->setSolventado(1);
		$historico->setFechaMantenimiento(date("Y-m-d H:i:s"));

		$exitoStatusEquipo= $equipo->actualizarStatusEquipo();
		$exitoHistorico= $historico->registrarMantenimiento();

		if ($exitoHistorico && $exitoStatusEquipo) {

			//se crea el registro
			$registros= new registros(1);
			$evento= new evento(1);

			$registros->setUsuario($UsuarioActivo);
			$registros->setFecha(date("Y-m-d H:i:s"));

			$descripcion= "Reporte de Mantenimiento del Equipo (idEquipo): ".$idEquipo." Realizado por Usuario: ".utf8_encode($UsuarioActivo);
			$evento->setEvento("Reporte de Mantenimiento");

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
			$TotalEquipos= $equipo->consultarEquipos();
			foreach ($TotalEquipos as $Individual) {
				if ($Individual["idEquipo"]==$idEquipo) {
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