<?php 
	require_once("../Model/marca.php");

	function getMarcas() {
		
		$marca= new marca(1);
		$Marcas= $marca->consultarTodosMarcas();

		$listaMarcas= '<option value="0" selected disabled>Seleccionar Marca </option>';
		foreach ($Marcas as $Marca) {
			$listaMarcas .= '<option value="'.$Marca["idMarca"].'">'.$Marca["Marca"].'</option>';
		}
		$listaMarcas .= '<option value="">Otro</option>';

		$marca= NULL;
		return $listaMarcas;
	}

	echo getMarcas();
?>