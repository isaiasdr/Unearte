<?php 
	require_once("../Model/usuario.php");
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

	if (!isset($_POST['password']) || !isset($_POST['confirm_password'])) {
		redireccionar("../Views/inicio.php");
	}

	//se capturan los datos enviados en el formulario
	$password= $_POST["password"];
	$confirm= $_POST["confirm_password"];

	if ($password == $confirm) {
		$password= password_hash($password, PASSWORD_DEFAULT);
		//se crea el objeto
		$Usuario= new usuario(1);
		$usuario= $UsuarioActivo;

		if (isset($_SESSION["UsuarioPassword"])) {
			$usuario= $_SESSION["UsuarioPassword"];
			unset($_SESSION["UsuarioPassword"]);
		}

		$Usuario->setUsername($usuario);
		$Usuario->setPassword($password);

		$consulta= $Usuario->cambioPassword();
		if ($consulta) {

			$registros= new registros(1);
			$registros->setUsuario($UsuarioActivo);
			$registros->setFecha(date("Y-m-d H:i:s"));
			$descripcion= "Cambio de Contraseña del Usuario: ".$UsuarioActivo;
			$registros->setDescripcion($descripcion);

			$evento= new evento(1);
			$evento->setEvento("Cambio de Contraseña");
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

			echo "Cambio de contraseña realizado exitosamente";
			redireccionar("../Views/inicio.php");
			//me gustaria actualizar automaticamente la pag
		}
		echo "error en el cambio de contraseña";
		redireccionar("../Views/inicio.php");
	}

 ?>