<?php
	require_once("../Model/tipo.php");
	require_once("../Model/equipo.php");
	require_once("../Model/marca.php");
	require_once("../Model/modelo.php");
	require_once("../Model/sede.php");
	require_once("../Model/departamento.php");
	require_once("../Model/piso.php");
	require_once("../Model/administrativo.php");
	require_once("../Model/status.php");
	require_once("../Model/computador.php");
	require_once("../Model/grupo.php");
	require_once("../Model/sistema_operativo.php");
	require 'vendor/autoload.php';

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;

	if (!isset($_POST['Busqueda-Excel'])) {
		redireccionar("../Views/inicio.php");
	}

	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();
	$sheet->setCellValue('K1', 'Consulta del Inventario');
	$sheet->setCellValue('A2', 'Num');
	$sheet->setCellValue('B2', 'Equipo');
	$sheet->setCellValue('C2', 'Marca');
	$sheet->setCellValue('D2', 'Modelo');
	$sheet->setCellValue('E2', 'Numero Serial');
	$sheet->setCellValue('F2', 'Numero Chapa Vieja');
	$sheet->setCellValue('G2', 'Numero Activo Fijo');
	$sheet->setCellValue('H2', 'Sede');
	$sheet->setCellValue('I2', 'Departamento');
	$sheet->setCellValue('J2', 'Piso');
	$sheet->setCellValue('K2', 'Usuario');
	$sheet->setCellValue('L2', 'Nombre Equipo');
	$sheet->setCellValue('M2', 'Grupo');
	$sheet->setCellValue('N2', 'MAC');
	$sheet->setCellValue('O2', 'IP');
	$sheet->setCellValue('P2', 'Red');
	$sheet->setCellValue('Q2', 'Voz');
	$sheet->setCellValue('R2', 'Estado');
	$sheet->setCellValue('S2', 'Observaciones');
	$sheet->setCellValue('T2', 'Sistema Operativo');

	$indice= 3;

	$busqueda= strtoupper($_POST["Busqueda-Excel"]);

	if ($busqueda=='') {
		$tipo= new tipo(1);
		$equipo= new equipo(1);
		$marca= new marca(1);
		$modelo= new modelo(1);
		$sede= new sede(1);
		$departamento= new departamento(1);
		$piso= new piso(1);
		$administrativo= new administrativo(1);
		$status= new status(1);

		$TodosEquipos= $equipo->consultarEquipos();
		$i=0;
		foreach ($TodosEquipos as $equipos) {
			//contador que muestra el numero del registro del equipo
			$i++;

			$tipo->setIdTipo($equipos["tipo_idTipo"]);
			$Tipo= $tipo->consultarTipo();

			$modelo->setIdModelo($equipos["modelo_idModelo"]);
			$Modelo= $modelo->consultarModelo();
			
			$marca->setIdMarca($Modelo[0]["marca_idMarca"]);
			$Marca= $marca->consultarMarca();

			$sede->setIdSede($equipos["sede_idSede"]);
			$Sede= $sede->consultarSede();

			$administrativo->setIdAdministrativo($equipos["administrativo_idAdministrativo"]);
			$Administrativo= $administrativo->consultarAdministrativo();

			$departamento->setIdDepartamento($Administrativo[0]["departamento_idDepartamento"]);
			$Departamento= $departamento->consultarDepartamento();

			$piso->setIdPiso($Departamento[0]["piso_idPiso"]);
			$Piso= $piso->consultarPiso();

			$status->setIdStatus($equipos["status_idStatus"]);
			$Status= $status->consultarStatus();

			$sheet->setCellValue('A'.$indice.'', $i);
			$sheet->setCellValue('B'.$indice.'', $Tipo[0]["Tipo"]);
			$sheet->setCellValue('C'.$indice.'', $Marca[0]["Marca"]);
			$sheet->setCellValue('D'.$indice.'', $Modelo[0]["Modelo"]);
			$sheet->setCellValue('E'.$indice.'', $equipos["Serial"]);
			$sheet->setCellValue('F'.$indice.'', $equipos["Chapa_Vieja"]);
			$sheet->setCellValue('G'.$indice.'', $equipos["Bien_Nacional"]);
			$sheet->setCellValue('H'.$indice.'', $Sede[0]["Sede"]);
			$sheet->setCellValue('I'.$indice.'', $Departamento[0]["Departamento"]);
			$sheet->setCellValue('J'.$indice.'', $Piso[0]["Piso"]);
			$sheet->setCellValue('K'.$indice.'', $Administrativo[0]["Personal"]);

			if ($Tipo[0]["Tipo"]== "CASE O CPU") {
				$computador= new computador(1);
				$grupo= new grupo(1);
				$sistema_operativo= new sistema_operativo(1);$grupo= new grupo(1);

				$computador->setAdministrativoID($equipos["administrativo_idAdministrativo"]);
				$Computador= $computador->consultarComputador();

				$grupo->setIdGrupo($Computador[0]["grupo_idGrupo"]);
				$Grupo= $grupo->consultarGrupo();

				$sistema_operativo->setID($Computador[0]["sistema_operativo_idSistema_operativo"]);
				$SO= $sistema_operativo->consultarSO();

				$sheet->setCellValue('L'.$indice.'', $Computador[0]["Nombre_Equipo"]);
				$sheet->setCellValue('M'.$indice.'', $Grupo[0]["Grupo"]);
				$sheet->setCellValue('N'.$indice.'', $Computador[0]["MAC"]);
				$sheet->setCellValue('O'.$indice.'', $Computador[0]["IP"]);
				$sheet->setCellValue('P'.$indice.'', $Computador[0]["Red"]);
				$sheet->setCellValue('Q'.$indice.'', $Computador[0]["Voz"]);
				$sheet->setCellValue('R'.$indice.'', $Status[0]["Status"]);
				$sheet->setCellValue('S'.$indice.'', $equipos["Observaciones"]);
				$sheet->setCellValue('T'.$indice.'', $SO[0]["SO"]);

				$computador= NULL;
				$grupo= NULL;
				$sistema_operativo= NULL;
			} else {
				$sheet->setCellValue('R'.$indice.'', $Status[0]["Status"]);
				$sheet->setCellValue('S'.$indice.'', $equipos["Observaciones"]);
			}

			$indice++;
		}

		$tipo= NULL;
		$equipo= NULL;
		$marca= NULL;
		$modelo= NULL;
		$sede= NULL;
		$departamento= NULL;
		$piso= NULL;
		$administrativo= NULL;
		$status= NULL;

	} else {
		$tipo= new tipo(1);
		$equipo= new equipo(1);
		$marca= new marca(1);
		$modelo= new modelo(1);
		$sede= new sede(1);
		$departamento= new departamento(1);
		$piso= new piso(1);
		$administrativo= new administrativo(1);
		$status= new status(1);

		$TodosEquipos= $equipo->consultarEquipos();
		$i=0;
		foreach ($TodosEquipos as $equipos) {
			//contador que muestra el numero del registro del equipo
			$i++;

			$tipo->setIdTipo($equipos["tipo_idTipo"]);
			$Tipo= $tipo->consultarTipo();

			$modelo->setIdModelo($equipos["modelo_idModelo"]);
			$Modelo= $modelo->consultarModelo();
			
			$marca->setIdMarca($Modelo[0]["marca_idMarca"]);
			$Marca= $marca->consultarMarca();

			$sede->setIdSede($equipos["sede_idSede"]);
			$Sede= $sede->consultarSede();

			$administrativo->setIdAdministrativo($equipos["administrativo_idAdministrativo"]);
			$Administrativo= $administrativo->consultarAdministrativo();

			$departamento->setIdDepartamento($Administrativo[0]["departamento_idDepartamento"]);
			$Departamento= $departamento->consultarDepartamento();

			$piso->setIdPiso($Departamento[0]["piso_idPiso"]);
			$Piso= $piso->consultarPiso();

			$status->setIdStatus($equipos["status_idStatus"]);
			$Status= $status->consultarStatus();

			if ($Departamento[0]["Departamento"]==$busqueda || $Piso[0]["Piso"]== $busqueda || $Tipo[0]["Tipo"]==$busqueda || $equipos["Serial"]==$busqueda || $equipos["Bien_Nacional"]==$busqueda) {

				$sheet->setCellValue('A'.$indice.'', $i);
				$sheet->setCellValue('B'.$indice.'', $Tipo[0]["Tipo"]);
				$sheet->setCellValue('C'.$indice.'', $Marca[0]["Marca"]);
				$sheet->setCellValue('D'.$indice.'', $Modelo[0]["Modelo"]);
				$sheet->setCellValue('E'.$indice.'', $equipos["Serial"]);
				$sheet->setCellValue('F'.$indice.'', $equipos["Chapa_Vieja"]);
				$sheet->setCellValue('G'.$indice.'', $equipos["Bien_Nacional"]);
				$sheet->setCellValue('H'.$indice.'', $Sede[0]["Sede"]);
				$sheet->setCellValue('I'.$indice.'', $Departamento[0]["Departamento"]);
				$sheet->setCellValue('J'.$indice.'', $Piso[0]["Piso"]);
				$sheet->setCellValue('K'.$indice.'', $Administrativo[0]["Personal"]);

				if ($Tipo[0]["Tipo"]== "CASE O CPU") {
					$computador= new computador(1);
					$grupo= new grupo(1);
					$sistema_operativo= new sistema_operativo(1);$grupo= new grupo(1);

					$computador->setAdministrativoID($equipos["administrativo_idAdministrativo"]);
					$Computador= $computador->consultarComputador();

					$grupo->setIdGrupo($Computador[0]["grupo_idGrupo"]);
					$Grupo= $grupo->consultarGrupo();

					$sistema_operativo->setID($Computador[0]["sistema_operativo_idSistema_operativo"]);
					$SO= $sistema_operativo->consultarSO();

					$sheet->setCellValue('L'.$indice.'', $Computador[0]["Nombre_Equipo"]);
					$sheet->setCellValue('M'.$indice.'', $Grupo[0]["Grupo"]);
					$sheet->setCellValue('N'.$indice.'', $Computador[0]["MAC"]);
					$sheet->setCellValue('O'.$indice.'', $Computador[0]["IP"]);
					$sheet->setCellValue('P'.$indice.'', $Computador[0]["Red"]);
					$sheet->setCellValue('Q'.$indice.'', $Computador[0]["Voz"]);
					$sheet->setCellValue('R'.$indice.'', $Status[0]["Status"]);
					$sheet->setCellValue('S'.$indice.'', $equipos["Observaciones"]);
					$sheet->setCellValue('T'.$indice.'', $SO[0]["SO"]);

					$computador= NULL;
					$grupo= NULL;
					$sistema_operativo= NULL;
				} else {
					$sheet->setCellValue('R'.$indice.'', $Status[0]["Status"]);
					$sheet->setCellValue('S'.$indice.'', $equipos["Observaciones"]);
				}
				$indice++;
			}
		}

		$tipo= NULL;
		$equipo= NULL;
		$marca= NULL;
		$modelo= NULL;
		$sede= NULL;
		$departamento= NULL;
		$piso= NULL;
		$administrativo= NULL;
		$status= NULL;
	}

	$filename='ReporteInventario.xlsx';

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="' . $filename . '"');
	header('Cache-Control: max-age=0');

	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	$writer->save('php://output');
	exit;
?>