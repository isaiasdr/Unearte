<?php
	//se incluye la clase usuario
	require_once("../Model/usuario.php");
	require_once("../Model/registros.php");
	require_once("../Model/evento.php");
	//se crea la sesion	
	session_start();

	if (!isset($_POST['username']) || !isset($_POST['password'])) {
		redireccionar("../Views/inicio.php");
	}

	//se capturan los datos enviados en el formulario
	$username= $_POST["username"];
	$password= $_POST["password"];

	//se crea el objeto
	$Usuario= new usuario(1);

	$Usuario->setUsername($username);
	$consulta= $Usuario->seleccionarUsuario();

	if (!empty($consulta)) {
		if ($consulta[0]["Estado"]==0) {

			$Usuario= NULL;
			$_SESSION['Login']=TRUE;
			redireccionar("../Views/login.php");

		} else {
			foreach ($consulta as $resultado) {
				if (password_verify($password, $resultado["Password"])) {
					$_SESSION['Username']= $resultado["Username"];
					$_SESSION['clases_usuario_idClase']= $resultado["clases_usuario_idClase"];
					$_SESSION['Ultima_Actividad']= time();
					$Usuario=NULL;

					//se crea el registro
					$registros= new registros(1);
					$registros->setUsuario($resultado["Username"]);
					$registros->setFecha(date("Y-m-d H:i:s"));
					$registros->setDescripcion("Inicio de Sesion Usuario: ".$resultado["Username"]);

					$evento= new evento(1);
					$evento->setEvento("Login");
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
				} else {
					$Usuario= NULL;
					$_SESSION['Login']=TRUE;
					redireccionar("../Views/login.php");
				}
			}
		}
	} else {
		$Usuario= NULL;
		$_SESSION['Login']=TRUE;
		redireccionar("../Views/login.php");
	}
?>