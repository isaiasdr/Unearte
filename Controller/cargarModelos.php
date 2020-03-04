<?php 
	require_once("../Model/modelo.php");

	function getModelos() {

		$idMarca= $_POST["idMarca"];

		$modelo= new modelo(1);
		$modelo->setMarcaID($idMarca);
		$Modelos= $modelo->consultarTodosmodelos();

		$listaModelos= '<option value="0" selected disabled>Seleccionar Modelo</option>';
		foreach ($Modelos as $Modelo) {
			$listaModelos .= '<option value="'.$Modelo["idModelo"].'">'.$Modelo["Modelo"].'</option>';
		}
		$listaModelos .= '<option value="">Otro</option>';

		$modelo= NULL;
		return $listaModelos;
	}
	echo getModelos();
?>