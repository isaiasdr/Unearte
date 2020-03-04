<?php 
	require_once("../Model/equipo.php");
	require_once("../Model/historico.php");
	require_once("../Model/fallas.php");
	require_once("../Model/administrativo.php");
	require_once("../Model/departamento.php");
	require 'vendor/autoload.php';

	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\IOFactory;

	$spreadsheet = new Spreadsheet();
	$sheet = $spreadsheet->getActiveSheet();
	$sheet->setCellValue('D1', 'Incidencias Activas');
	$sheet->setCellValue('A2', 'Num falla');
	$sheet->setCellValue('B2', 'Num Equipo');
	$sheet->setCellValue('C2', 'Numero Serial');
	$sheet->setCellValue('D2', 'Numero Bien Nacional');
	$sheet->setCellValue('E2', 'Ubicacion');
	$sheet->setCellValue('F2', 'Falla');
	$sheet->setCellValue('G2', 'Requerimientos');

	$falla = new fallas(1);
	$Fallas= $falla->consultarTodasFallas();
	$contador=0;
	$indice= 3; 

	foreach ($Fallas as $Falla) {
		$historico= new historico(1);
		$idFalla= $Falla["idFallas"];
		$historico->setFallasID($idFalla);
		$historico->setSolventado(0);
		$Historicos= $historico->historicosPorFalla();

		foreach ($Historicos as $Historico) {
			$contador++;
			$equipo= new equipo(1);
			$equipo->setIdEquipo($Historico["equipo_idEquipo"]);
			$Equipo= $equipo->seleccionarEquipo();
			$administrativo= new administrativo(1);
			$administrativo->setIdAdministrativo($Equipo[0]["administrativo_idAdministrativo"]);
			$Administrativo= $administrativo->consultarAdministrativo();
			$departamento= new departamento(1);
			$departamento->setIdDepartamento($Administrativo[0]["departamento_idDepartamento"]);
			$Departamento= $departamento->consultarDepartamento();

			$sheet->setCellValue('A'.$indice.'', $contador);
			$sheet->setCellValue('B'.$indice.'', $Equipo[0]["idEquipo"]);
			$sheet->setCellValue('C'.$indice.'', $Equipo[0]["Serial"]);
			$sheet->setCellValue('D'.$indice.'', $Equipo[0]["Bien_Nacional"]);
			$sheet->setCellValue('E'.$indice.'', $Departamento[0]["Departamento"]);
			$sheet->setCellValue('F'.$indice.'', $Falla["Fallas"]);
			$sheet->setCellValue('G'.$indice.'', $Historico["Requerimientos"]);

			$equipo= NULL;
			$administrativo= NULL;
			$departamento= NULL;

			$indice++;
		}
		$historico= NULL;
	}
	$falla= NULL;

	$filename='ReporteFallasActivas.xlsx';

	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="' . $filename . '"');
	header('Cache-Control: max-age=0');

	$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
	$writer->save('php://output');
	exit;
?>