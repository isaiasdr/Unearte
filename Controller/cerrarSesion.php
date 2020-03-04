<?php 
	require_once("../Model/registros.php");
	require_once("../Model/evento.php");
	session_start();

	if(isset($_SESSION['Username'])) {
		$UsuarioActivo= $_SESSION['Username'];
		$RolUsuario= $_SESSION['clases_usuario_idClase'];
	} else {
		//redireccionar("../Views/login.php");
		//
	}

	//se crea el registro
	$registros= new registros(1);
	$registros->setUsuario($UsuarioActivo);
	$registros->setFecha(date("Y-m-d H:i:s"));
	$descripcion= "Cierre de Sesion de: ".$UsuarioActivo;
	$registros->setDescripcion($descripcion);

	$evento= new evento(1);
	$evento->setEvento("Logout");
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

	session_unset();
	session_destroy();
	redireccionar("../Views/login.php");
	//me gustaria mandar un mensaje hacia la siguiente pagina que cierre de sesion exitoso o algo
 ?>