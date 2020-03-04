<?php 
	require_once("../Model/equipo.php");
	require_once("../Model/tipo.php");
	require_once("../Model/modelo.php");
	require_once("../Model/marca.php");
	require_once("../Model/status.php");
	require_once("../Model/sede.php");
	require_once("../Model/administrativo.php");
	require_once("../Model/departamento.php");
	require_once("../Model/piso.php");
	require_once("../Model/computador.php");
	require_once("../Model/grupo.php");
	require_once("../Model/sistema_operativo.php");
	require_once("../Model/registros.php");
	require_once("../Model/evento.php");

	session_start();

	if (isset($_SESSION['Ultima_Actividad']) && (time() - $_SESSION['Ultima_Actividad'])>60*10) {
		redireccionar("../Views/cerrarSesion.php");
	}

	if(isset($_SESSION['Username'])) {
		$UsuarioActivo= $_SESSION['Username'];
		$RolUsuario= $_SESSION['clases_usuario_idClase'];
		$_SESSION['Ultima_Actividad']= time();
	} else {
		redireccionar("../Views/login.php");
		//
	}

	//solo puede acceder a estas funciones el administrador del sistema
	if ($RolUsuario != 1) {
		redireccionar("../Views/inicio.php");
	}

	if (isset($_POST['multiple'])) {
		$multiple= $_POST['multiple'];
	} else {
		$multiple= false;
	}

	if (isset($_POST['individual'])) {
		$individual= $_POST['individual'];
	} else {
		$individual= false;
	}

	if ($multiple) {
		$file= $_FILES["archivo_Equipos"]["tmp_name"];
		if ($_FILES["archivo_Equipos"]["size"]>0) {
			$archivo= fopen($file, "r");
			//se crean los objetos para almacenar los datos
			$tipo= new tipo(1);
			$marca= new marca(1);
			$modelo= new modelo(1);
			$equipo= new equipo(1);
			$sede= new sede(1);
			$departamento= new departamento(1);
			$administrativo= new administrativo(1);
			$status= new status(1);
			$piso= new piso(1);

			while (($datos= fgetcsv($archivo, 1000, ";")) !== FALSE ) {

				//se verifica si el dato ya existe, si no lo añade a la tabla tipo
				$tipo->setTipo(strtoupper(utf8_encode($datos[0])));
				$idTipo= $tipo->consultarID();
				if ($idTipo==NULL) {
					$tipo->añadirTipo();
				}

				//se verifica si el dato ya existe, si no lo añade a la tabla marca
				$marca->setMarca(strtoupper(utf8_encode($datos[1])));
				$idMarca= $marca->consultarID();
				if ($idMarca==NULL) {
					$marca->añadirMarca();
				}
				
				//se verifica si el dato ya existe, si no lo añade a la tabla modelo
				$modelo->setModelo(strtoupper(utf8_encode($datos[2])));
				$idModelo= $modelo->consultarID();
				if ($idModelo==NULL) {
					$idMarca= $marca->consultarID();
					foreach ($idMarca as $id) {
						$modelo->setMarcaID($id["idMarca"]);
					}
					$modelo->añadirModelo();
				}
				
				//se verifica si el dato ya existe, si no lo añade a la tabla sede
				$sede->setSede(strtoupper(utf8_encode($datos[6])));
				$idSede= $sede->consultarID();
				if ($idSede==NULL) {
					$sede->añadirSede();
				}
				
				//se verifica si el dato ya existe, si no lo añade a la tabla piso
				$piso->setPiso($datos[8]);
				$idPiso= $piso->consultarID();
				if ($idPiso==NULL) {
					$piso->añadirPiso();
				}

				//se verifica si el dato ya existe, si no lo añade a la tabla departamento
				$departamento->setDepartamento(strtoupper(utf8_encode($datos[7])));
				$idDepartamento= $departamento->consultarID();
				if ($idDepartamento==NULL) {
					$idPiso= $piso->consultarID();
					foreach ($idPiso as $id) {
						$departamento->setPisoID($id["idPiso"]);
					}
					$departamento->añadirDepartamento();
				}
				
				//se verifica si el dato ya existe, si no lo añade a la tabla administrativo
				$administrativo->setPersonal(strtoupper(utf8_encode($datos[9])));
				$idAdministrativo= $administrativo->consultarID();
				if ($idAdministrativo==NULL) {
					$idDepartamento= $departamento->consultarID();
					foreach ($idDepartamento as $id) {
						$administrativo->setDepartamentoID($id["idDepartamento"]);
					}
					$administrativo->añadirAdministrativo();
				}
				
				//se verifica si el dato ya existe, si no lo añade a la tabla status
				$status->setStatus(strtoupper(utf8_encode($datos[16])));
				$idStatus= $status->consultarID();
				if ($idStatus==NULL) {
					$status->añadirStatus();
				}
				
				//se verifica si el dato ya existe, si no lo añade a la tabla equipo
				$equipo->setSerial(strtoupper($datos[3]));
				$idEquipo= $equipo->consultarID();
				if ($idEquipo==NULL) {
					$equipo->setChapa_Vieja(strtoupper($datos[4]));
					$equipo->setBien_Nacional(strtoupper($datos[5]));
					$equipo->setObservaciones(strtoupper(utf8_encode($datos[17])));
					$idStatus= $status->consultarID();
					foreach ($idStatus as $id) {
						$equipo->setStatusID($id["idStatus"]);
					}
					$idTipo= $tipo->consultarID();
					foreach ($idTipo as $id) {
						$equipo->setTipoID($id["idTipo"]);
					}
					$idSede= $sede->consultarID();
					foreach ($idSede as $id) {
						$equipo->setSedeID($id["idSede"]);
					}
					$idModelo= $modelo->consultarID();
					foreach ($idModelo as $id) {
						$equipo->setModeloID($id["idModelo"]);
					}
					$idAdministrativo= $administrativo->consultarID();
					foreach ($idAdministrativo as $id) {
						$equipo->setAdministrativoID($id["idAdministrativo"]);
					}
					$equipo->añadirEquipo();
				}

				$Tipo= $tipo->getTipo();
				if ($Tipo== "CASE O CPU") {

					$computador= new computador(1);
					$grupo= new grupo(1);
					$sistema_operativo= new sistema_operativo(1);

					//se verifica si el dato ya existe, si no lo añade a la tabla sistema operativo
					$sistema_operativo->setSO(strtoupper(utf8_encode($datos[18])));
					$idSO= $sistema_operativo->consultarID();
					if ($idSO==NULL) {
						$sistema_operativo->añadirSO();
					}

					//se verifica si el dato ya existe, si no lo añade a la tabla grupo
					$grupo->setGrupo(strtoupper(utf8_encode($datos[11])));
					$idGrupo= $grupo->consultarID();
					if ($idGrupo==NULL) {
						$grupo->añadirGrupo();
					}

					//se asignan los datos del computador
					$computador->setNombre_Equipo(strtoupper(utf8_encode($datos[10])));
					$computador->setMAC(strtoupper($datos[12]));
					$computador->setIP($datos[13]);
					$computador->setRed(strtoupper($datos[14]));
					$computador->setVoz(strtoupper($datos[15]));
					$idGrupo= $grupo->consultarID();
					foreach ($idGrupo as $id) {
						$computador->setGrupoID($id["idGrupo"]);
					}
					$idSO= $sistema_operativo->consultarID();
					foreach ($idSO as $id) {
						$computador->setSOID($id["idSistema_operativo"]);
					}
					$idAdministrativo= $administrativo->consultarID();
					foreach ($idAdministrativo as $id) {
						$computador->setAdministrativoID($id["idAdministrativo"]);
					}
					$computador->añadirComputador();

					$computador= NULL;
					$grupo= NULL;
					$sistema_operativo= NULL;
				}	
 			}

			$tipo= NULL;
			$marca= NULL;
			$modelo= NULL;
			$equipo= NULL;
			$sede= NULL;
			$departamento= NULL;
			$administrativo= NULL;
			$status= NULL;
			$piso= NULL;
		}

		$registros= new registros(1);
		$registros->setUsuario($UsuarioActivo);
		$registros->setFecha(date("Y-m-d H:i:s"));
		$descripcion= "Registro de multiples Equipos Realizado por Usuario: ".utf8_encode($UsuarioActivo);
		$registros->setDescripcion($descripcion);

		$evento= new evento(1);
		$evento->setEvento("Añadio Multiples Equipos");
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
		
		redireccionar("../Views/inicio.php");
	}

	if ($individual) {
		//se crean los objetos para almacenar los datos
		$equipo= new equipo(1);
		
		//pues de momento pensado para que todos los tipos, marcas, modelos, status, administrativos, so, ya esten guardados en la base de datos tengo que ver como hacer en caso de que no sea asi 
		$Tipo= $_POST["Tipo"];

		$tipo= new tipo(1);
		$tipo->setTipo(strtoupper(utf8_encode($_POST["Tipo"])));
		$Tipo= $tipo->consultarID();
		if (empty($Tipo)) {
			$tipo->añadirTipo();
			$Tipo= $tipo->consultarID();
			$tipo= NULL;
		}
		$equipo->setTipoID($Tipo[0]["idTipo"]);

		$Marca= $_POST["Marca"];
		if (!is_numeric($Marca)) {
			$marca= new marca(1);
			$marca->setMarca(strtoupper(utf8_encode($_POST["Marca"])));
			$idMarca= $marca->consultarID();
			if (empty($idMarca)) {
				$marca->añadirMarca();
				$idMarca= $marca->consultarID();
			}

			$Marca= $idMarca[0]["idMarca"];
			$marca= NULL;
		}

		$Modelo= $_POST["Modelo"];
		if (is_numeric($Modelo)) {
			$equipo->setModeloID($Modelo);
		} else {
			$modelo= new modelo(1);
			$modelo->setMarcaID($Marca);
			$modelo->setModelo(strtoupper(utf8_encode($_POST["Modelo"])));
			$idModelo= $modelo->consultarID();
			if (empty($idModelo)) {
				$modelo->añadirModelo();
				$idModelo= $modelo->consultarID();
			}
			$Modelo= $idModelo[0]["idModelo"];
			$modelo= NULL;

			$equipo->setModeloID($Modelo);
		}
		
		$Status= $_POST["Status"];
		if (is_numeric($Status)) {
			$equipo->setStatusID($Status);
		} else {
			$status= new status(1);
			$status->setStatus(strtoupper(utf8_encode($_POST["Status"])));
			if (strtoupper(utf8_encode($_POST["Status"]))=="DESINCORPORADO") {
				$equipo= NULL;
				$status= NULL;
				$tipo=NULL;
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

		$Sede= $_POST["Sede"];
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
			$piso->setPiso(strtoupper(utf8_encode($_POST["Piso"])));
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

		$Administrativo= $_POST["Administrativo"];
		if (is_numeric($Administrativo)) {
			$equipo->setAdministrativoID($Administrativo);
		} else {
			$administrativo= new administrativo(1);
			$administrativo->setDepartamentoID($Departamento);
			$administrativo->setPersonal(strtoupper(utf8_encode($_POST["Administrativo"])));
			$idAdministrativo= $administrativo->consultarID();
			if (empty($idAdministrativo)) {
				$administrativo->añadirAdministrativo();
				$idAdministrativo= $administrativo->consultarID();
			}
			$Administrativo= $idAdministrativo[0]["idAdministrativo"];
			$administrativo= NULL;

			$equipo->setAdministrativoID($Administrativo);
		}
		
		$Bien_Nacional= $_POST["Bien_Nacional"];
		$Chapa_Vieja= $_POST["Chapa_Vieja"];
		$Serial= strtoupper($_POST["Serial"]);
		$Observaciones= strtoupper($_POST["Observaciones"]);
		
		$equipo->setBien_Nacional($Bien_Nacional);
		$equipo->setChapa_Vieja($Chapa_Vieja);
		$equipo->setSerial($Serial);
		$equipo->setObservaciones($Observaciones);
		$equipo->añadirEquipo();

		$tipo= new tipo(1);
		$tipo->setIdTipo($Tipo[0]["idTipo"]);
		$consultaTipo= $tipo->consultarTipo();
		if ($consultaTipo[0]["Tipo"]=="CASE O CPU") {

			$Grupo= $_POST["Grupo"];
			if (!is_numeric($Grupo)) {
				$grupo= new grupo(1);
				$grupo->setGrupo(strtoupper(utf8_encode($_POST["Grupo"])));
				$idGrupo= $grupo->consultarID();
				if (empty($idGrupo)) {
					$grupo->añadirGrupo();
					$idGrupo= $grupo->consultarID();
				}

				$Grupo= $idGrupo[0]["idGrupo"];
				$grupo= NULL;
			}

			$SO= $_POST["SO"];
			if (!is_numeric($SO)) {
				$sistema_operativo= new sistema_operativo(1);
				$sistema_operativo->setSO(strtoupper(utf8_encode($_POST["SO"])));
				$idSO= $sistema_operativo->consultarID();
				if (empty($idSO)) {
					$sistema_operativo->añadirSO();
					$idSO= $sistema_operativo->consultarID();
				}

				$SO= $idSO[0]["SO"];
				$sistema_operativo= NULL;
			}

			$Nombre_Equipo= strtoupper(utf8_encode($_POST["Nombre_Equipo"]));
			$MAC= strtoupper($_POST["MAC"]);
			$IP= $_POST["IP"];
			$Red= $_POST["Red"];
			$Voz= $_POST["Voz"];

			$computador= new computador(1);

			$computador->setNombre_Equipo($Nombre_Equipo);
			$computador->setMAC($MAC);
			$computador->setIP($IP);
			$computador->setRed($Red);
			$computador->setVoz($Voz);
			$computador->setGrupoID($Grupo);
			$computador->setSOID($SO);
			$computador->setAdministrativoID($Administrativo);
			$computador->añadirComputador();

			$computador= NULL;
		}
		$tipo= NULL;
		$equipo= NULL;

		$registros= new registros(1);
		$registros->setUsuario($UsuarioActivo);
		$registros->setFecha(date("Y-m-d H:i:s"));
		$descripcion= "Registro de nuevo Equipo Realizado por Usuario: ".$UsuarioActivo;
		$registros->setDescripcion($descripcion);

		$evento= new evento(1);
		$evento->setEvento("Añadir Equipo");
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

		redireccionar("../Views/inicio.php");
	}
?>