<?php
	require_once __DIR__ . '/vendor/autoload.php';

	ob_start();
	require_once("PDFconsultaEquipo.php");
	$html= ob_get_contents();
	ob_get_clean();

	$mpdf = new \Mpdf\Mpdf(['orientation' => 'L']);
	$mpdf->WriteHTML($html);
	$mpdf->Output('HistoricoEquipo_ID_'.$_SESSION['idEquipo'].'.pdf', \Mpdf\Output\Destination::INLINE);

?>