<?php
	require_once("../Model/usuario.php");
	require_once("../Model/clases_usuario.php");
	require_once("../Model/registros.php");
	require_once("../Model/evento.php");
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

	if ($RolUsuario != 1) {
		redireccionar("../Views/inicio.php");
	}

	//se capturan los datos enviados en el formulario
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

	if ($individual) {
		$username= utf8_encode($_POST["username"]);
		$password= $_POST["password"];
		$confirm= $_POST["confirm_password"];
		$rol= $_POST["rolID"];

		if ($password == $confirm) {
			$password= password_hash($password, PASSWORD_DEFAULT);
			//se crea el objeto
			$Usuario= new usuario(1);

			//se asignan los valores de sus atributos
			$Usuario->setUsername($username);
			$consultaUsuario= $Usuario->seleccionarUsuario();
			if (empty($consultaUsuario)) {
				$Usuario->setPassword($password);
				$Usuario->setRolID($rol);
				$Usuario->setEstado(1);

				$consulta= $Usuario->crearUsuario();
				$Usuario= NULL;

				if ($consulta) {
					$registros= new registros(1);
					$registros->setUsuario($UsuarioActivo);
					$registros->setFecha(date("Y-m-d H:i:s"));
					$descripcion= "Registro de nuevo Usuario: ".$username."  Realizado por Usuario: ".utf8_encode($UsuarioActivo);
					$registros->setDescripcion($descripcion);

					$evento= new evento(1);
					$evento->setEvento("Añadir Usuario");
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
					
					redireccionar("../Views/administrarUsuarios.php");
				}
			}
			
		} else {
			redireccionar("../Views/registrarUsuario.php");
		}
	}

	if ($multiple) {
		$file= $_FILES["Archivo_Usuarios"]["tmp_name"];
		if ($_FILES["Archivo_Usuarios"]["size"]>0) {
			$archivo= fopen($file, "r");
			
			while (($datos= fgetcsv($archivo, 1000, ";")) !== FALSE ) {
				$usuario= new usuario(1);

				//se verifica si el dato ya existe, si no lo añade a la tabla tipo
				$usuario->setUsername(utf8_encode($datos[0]));
				$idUsuario= $usuario->seleccionarUsuario();
				if ($idUsuario==NULL) {
					$password= utf8_encode($datos[1]);
					$password= password_hash($password, PASSWORD_DEFAULT);
					$usuario->setPassword($password);

					$clases_usuario= new clases_usuario(1);
					$clases_usuario->setTipo_Usuario(strtoupper($datos[2]));
					$idRol= $clases_usuario->consultaIdTipoUsuario();

					if (empty($idRol)) {
						continue;
					} else {
						$usuario->setRolID($idRol[0]["idClase"]);
						$usuario->setEstado(1);
						$usuario->crearUsuario();
					}

					$clases_usuario= NULL;
				}

				$usuario= NULL;
			}
		}
		$registros= new registros(1);
		$registros->setUsuario($UsuarioActivo);
		$registros->setFecha(date("Y-m-d H:i:s"));
		$descripcion= "Registro de multiples Usuarios Realizado por Usuario: ".utf8_encode($UsuarioActivo);
		$registros->setDescripcion($descripcion);

		$evento= new evento(1);
		$evento->setEvento("Añadio Multiples Usuarios");
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