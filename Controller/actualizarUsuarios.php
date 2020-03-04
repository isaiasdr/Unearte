<?php
	require_once("../Model/usuario.php");
	require_once("../Model/clases_usuario.php");
	require_once("../Model/registros.php");
	require_once("../Model/evento.php");
	session_start();
	
	if (isset($_SESSION['Ultima_Actividad']) && (time() - $_SESSION['Ultima_Actividad'])>60*10) {
		redireccionar("../Controller/cerrarSesion.php");
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

	//debe hacer una funcion para eliminar usuario, para actualizar (en todo caso seria su rol dentro del sistema) y para cambio de contraseña
	if (isset($_POST["cambiarContraseña"])) {
		$usuario = new usuario(1);
		$usuario->setUsername($_POST['cambiarContraseña']);

		$Clase= $usuario->seleccionarUsuario();
		if ($Clase) {
			if ($Clase[0]['clases_usuario_idClase'] == 1) {
				exit();
			}
		}

		$_SESSION["UsuarioPassword"]= $_POST["cambiarContraseña"];
		redireccionar("../Views/cambiarContraseña.php");
	}

	if (isset($_POST['estado'])) {
		$estado= $_POST['estado'];
	} else {
		$estado= false;
	}

	if (isset($_POST["actualizar"])) {
		if ($_POST["actualizar"] == "cambiarRol") {
			$actualizar= $_POST["actualizar"];
		} else {
			$_SESSION["Actualizar"]= $_POST["actualizar"];
			redireccionar("../Views/actualizarRolUsuario.php");
		}
	} else {
		$actualizar= false;
	}

	if ($estado) {
		$usuario= $_POST["estado"];
		$Usuario= new Usuario(1);
		$Usuario->setUsername($usuario);

		$ConsultaClase= $Usuario->seleccionarUsuario();
		if ($ConsultaClase) {
		 	if ($ConsultaClase[0]['clases_usuario_idClase'] == 1) {
		 		exit();
		 	}
		 }

		if ($ConsultaClase[0]["Estado"]==1) {
			$Usuario->setEstado(0);
		} else {
			$Usuario->setEstado(1);
		}
		
		$consulta= $Usuario->CambiarEstado();
		if ($consulta) {

			$UsuarioActualizado= $Usuario->getUsername();
			$registros= new registros(1);
			$evento= new evento(1);

			$registros->setUsuario($UsuarioActivo);
			$registros->setFecha(date("Y-m-d H:i:s"));
			

			if ($ConsultaClase[0]["Estado"]==1) {

				$descripcion= "Usuario: ".$UsuarioActualizado." Deshabilitado, Realizado por Usuario: ".$UsuarioActivo;
				$registros->setDescripcion($descripcion);
				$evento->setEvento("Deshabilito Usuario");

			} else {

				$descripcion= "Usuario: ".$UsuarioActualizado." Habilitado, Realizado por Usuario: ".$UsuarioActivo;
				$registros->setDescripcion($descripcion);
				$evento->setEvento("Habilito Usuario");

			}

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

			$Usuario= NULL;
			redireccionar("../Views/administrarUsuarios.php");
		} else {
			$Usuario= NULL;
			redireccionar("../Views/administrarUsuarios.php");
		}
	}

	if ($actualizar) {
		$UsuarioActualizar= $_POST["Usuario"];
		$rol= $_POST["rolID"];
		$usuario= new usuario(1);
		$usuario->setUsername($UsuarioActualizar);
		$usuario->setRolID($rol);

		$ConsultaClase= $usuario->seleccionarUsuario();
		if ($ConsultaClase) {
		 	if ($ConsultaClase[0]['clases_usuario_idClase'] == 1) {
		 		exit();
		 	}
		 }

		$consulta= $usuario->cambioRol();
		if ($consulta) {

			$registros= new registros(1);
			$registros->setUsuario($UsuarioActivo);
			$registros->setFecha(date("Y-m-d H:i:s"));
			$descripcion= "Actualizacion del Usuario: ".$UsuarioActualizar." Realizado por Usuario: ".$UsuarioActivo;
			$registros->setDescripcion($descripcion);

			$evento= new evento(1);
			$evento->setEvento("Actualizacion Rol Usuario");
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

			echo "Usuario actualizado exitosamente";
			$Usuario= NULL;
			redireccionar("../Views/administrarUsuarios.php");
		} else {
			echo "Error en la actualizacion del usuario";
			$Usuario= NULL;
			redireccionar("../Views/administrarUsuarios.php");
		}
	}
?>