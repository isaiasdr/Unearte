<?php 
	require_once("../Model/tipo.php");

	function getTipos() {
		
		$tipo= new tipo(1);
		$Tipos= $tipo->consultarTodosTipos();

		$listaTipos= '<option value="0" selected disabled>Seleccionar Tipo </option>';
		foreach ($Tipos as $Tipo) {
			$listaTipos .= '<option value="'.$Tipo["Tipo"].'">'.$Tipo["Tipo"].'</option>';
		}
		$listaTipos .= '<option value="">Otro</option>';

		$tipo= NULL;
		return $listaTipos;
	}

	echo getTipos();
?>