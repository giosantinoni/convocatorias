<?php
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
/*$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 048');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');*/

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

//PARAMETROS
$fecha_actual = new DateTime();
$nro_conv = '';
if(isset($_POST['nro_conv'])){
	$nro_conv = $_POST['nro_conv'];
}
$inst = '';
if(isset($_POST['inst'])){
	$inst = $_POST['inst'];
}
$caracter_cargo = '';
if(isset($_POST['caracter_cargo'])){
	$caracter_cargo = $_POST['caracter_cargo'];
}
$area_curr= '';
if(isset($_POST['area_curr'])){
	$area_curr = $_POST['area_curr'];
}
$cant_horas = '';
if(isset($_POST['cant_horas'])){
	$cant_horas = $_POST['cant_horas'];
}
$horarios = '';
if(isset($_POST['horarios'])){
	$horarios = $_POST['horarios'];
}
$motivo = '';
if(isset($_POST['motivo'])){
	$motivo = $_POST['motivo'];
}
$lugar_insc = '';
if(isset($_POST['lugar_insc'])){
	$lugar_insc = $_POST['lugar_insc'];
}
$fecha_insc = '';
if(isset($_POST['fecha_insc'])){
	$fecha_insc = $_POST['fecha_insc'];
}
$horario_insc = '';
if(isset($_POST['horario_insc'])){
	$horario_insc = $_POST['horario_insc'];
}
//FIN PARAMETROS

// set font
$pdf->SetFont('helvetica', 'B', 14);

// add a page
$pdf->AddPage();

//$pdf->Write(0, 'Llamado a inscripción para cobertura de cargo vacante', '', 0, 'C', true, 0, false, false, 0);

$pdf->SetFont('helvetica', '', 12);
$pdf->Write(0, '', '', 0, 'R', true, 0, false, false, 0); //Linea en blanco
$pdf->Write(0, 'San Fernando del Valle de Catamarca, '. $fecha_actual->format('d/m/Y'), '', 0, 'R', true, 0, false, false, 0);
$pdf->Write(0, '', '', 0, 'R', true, 0, false, false, 0); //Linea en blanco
$pdf->Write(0, 'Convocatoria para Cobertura Número '.$nro_conv, '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Institución: '.$inst, '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Descripción del Cargo:', '', 0, 'L', true, 0, false, false, 0);

$html = '
    <ol>
        <ul>
            <li>Carácter del cargo (Interinato/Suplencia): '.$caracter_cargo.'</li>
            <li>Área curricular: '.$area_curr.'</li>
            <li>Cantidad de horas semanales: '.$cant_horas.'</li>
            <li>Horarios de prestación de servicio: '.$horarios.'</li>
        </ul>
    </ol>
';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Write(0, '', '', 0, 'R', true, 0, false, false, 0); //Linea en blanco
$pdf->Write(0, 'Motivo de la vacancia: '.$motivo, '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Lugar de inscripción: '.$lugar_insc, '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Fecha de inscripción: '.$fecha_insc, '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Horarios de inscripción: '.$horario_insc, '', 0, 'L', true, 0, false, false, 0);

$pdf->Write(0, '', '', 0, 'R', true, 0, false, false, 0); //Linea en blanco
$pdf->Write(0, '', '', 0, 'R', true, 0, false, false, 0); //Linea en blanco
$pdf->Write(0, '', '', 0, 'R', true, 0, false, false, 0); //Linea en blanco
$pdf->Write(0, '', '', 0, 'R', true, 0, false, false, 0); //Linea en blanco
$pdf->Write(0, 'Firma de Autoridad Competente', '', 0, 'R', true, 0, false, false, 0);

// -----------------------------------------------------------------------------

$pdf->AddPage();

//$pdf->SetFont('helvetica', 'B', 14);
//$pdf->Write(0, 'Llamado a inscripción para cobertura de cargo vacante', '', 0, 'C', true, 0, false, false, 0);

$pdf->Write(0, '', '', 0, 'R', true, 0, false, false, 0); //Linea en blanco
$pdf->Write(0, 'San Fernando del Valle de Catamarca, '. $fecha_actual->format('d/m/Y'), '', 0, 'R', true, 0, false, false, 0);
$pdf->Write(0, '', '', 0, 'R', true, 0, false, false, 0); //Linea en blanco
$pdf->Write(0, 'Convocatoria para Cobertura Número '.$nro_conv, '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Institución: '.$inst, '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Descripción del Cargo:', '', 0, 'L', true, 0, false, false, 0);

$html = '
    <ol>
        <ul>
            <li>Carácter del cargo (Interinato/Suplencia): '.$caracter_cargo.'</li>
            <li>Área curricular: '.$area_curr.'</li>
            <li>Cantidad de horas semanales: '.$cant_horas.'</li>
            <li>Horarios de prestación de servicio: '.$horarios.'</li>
        </ul>
    </ol>
';

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Write(0, '', '', 0, 'R', true, 0, false, false, 0); //Linea en blanco
$pdf->Write(0, 'Motivo de la vacancia: '.$motivo, '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Lugar de inscripción: '.$lugar_insc, '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Fecha de inscripción: '.$fecha_insc, '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, 'Horarios de inscripción: '.$horario_insc, '', 0, 'L', true, 0, false, false, 0);
$pdf->Write(0, '', '', 0, 'R', true, 0, false, false, 0); //Linea en blanco
$pdf->Write(0, '', '', 0, 'R', true, 0, false, false, 0); //Linea en blanco

$tbl = <<<EOD
<table cellspacing="0" cellpadding="1" border="1" align="center">
 <tr nobr="true">
  <th colspan="5">Docentes inscriptos</th>
 </tr>
 <tr nobr="true">
  <td style="width:15%">Nro Orden de Mérito</td>
  <td style="width:40%">Apellidos y Nombres</td>
  <td style="width:15%">D.N.I.</td>
  <td style="width:15%">Puntaje</td>
  <td style="width:15%">Firma</td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
 <tr nobr="true">
  <td></td>
  <td></td>
  <td></td>
  <td></td>
  <td></td>
 </tr>
</table>
EOD;

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
$pdf->Output('example_048.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
