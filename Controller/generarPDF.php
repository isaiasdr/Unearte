<?php
	require_once __DIR__ . '/vendor/autoload.php';

	if (!isset($_POST['Busqueda-PDF'])) {
		redireccionar("../Views/inicio.php");
	}

	$_SESSION['busqueda']= $_POST["Busqueda-PDF"];

	ob_start();
	require_once("PDFconsultaInventario.php");
	$html= ob_get_contents();
	ob_get_clean();

	$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
	$mpdf->WriteHTML($html);
	$mpdf->Output('ReporteInventario.pdf', \Mpdf\Output\Destination::INLINE);

?>