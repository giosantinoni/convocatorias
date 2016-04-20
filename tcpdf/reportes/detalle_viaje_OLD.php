<?php

require_once('tcpdf_include.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {
	
	public $chequear_viaje;
	
	public function setChequearViaje($chequear_viaje){
		$this->chequear_viaje = $chequear_viaje;
	}
	
	function get_cant_debitos_sin_tarjeta_por_chequear_viajes($chequear_viaje){
		try {		
			$conn = new PDO('mysql:host=localhost;dbname=r6000631_turcat', 'r6000631_turcat', '40tifofuZI');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = $conn->prepare('SELECT COUNT(DEBITO) AS CANT FROM debito WHERE CHEQUEAR_VIAJE = :chequear_viaje AND DEBITO = 0' );
			$sql->execute(array('chequear_viaje' => $chequear_viaje));
			$resul = $sql->fetchAll();
			foreach ($resul as $reg) {
				return $reg['CANT'];
			}
			return '0';
		} catch (PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}

	function get_cant_debitos_con_tarjeta_por_chequear_viajes($chequear_viaje){
		try {		
			$conn = new PDO('mysql:host=localhost;dbname=r6000631_turcat', 'r6000631_turcat', '40tifofuZI');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = $conn->prepare('SELECT COUNT(DEBITO) AS CANT FROM debito WHERE CHEQUEAR_VIAJE = :chequear_viaje AND DEBITO = 1' );
			$sql->execute(array('chequear_viaje' => $chequear_viaje));
			$resul = $sql->fetchAll();
			foreach ($resul as $reg) {
				return $reg['CANT'];
			}
			return '0';
		} catch (PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}

	function get_debitos_agrupados_por_chequear_viaje(){
		try {		
			$conn = new PDO('mysql:host=localhost;dbname=r6000631_turcat', 'r6000631_turcat', '40tifofuZI');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = $conn->prepare('SELECT CHEQUEAR_VIAJE FROM debito GROUP BY CHEQUEAR_VIAJE ORDER BY FECHAHORA');
			$sql->execute();
			return $sql->fetchAll();
		} catch (PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}

	function get_detalle_debitos_por_chequear_viaje($chequear_viaje){
		try {
			//$conn = this->con();
			$conn = new PDO('mysql:host=localhost;dbname=r6000631_turcat', 'r6000631_turcat', '40tifofuZI');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = $conn->prepare('SELECT debito.FECHAHORA, debito.MONTODEBITO, debito.DEBITO, 
							   cliente.APELLIDO, cliente.NOMBRE, corredor.DESCRIPCION AS CORREDOR, seccion.DESCRIPCION AS SECCION 
							   FROM debito, cliente, tarjeta, corredor, seccion 
							   WHERE debito.TARJETA_ID = tarjeta.ID 
							   AND tarjeta.CLIENTE_ID = cliente.ID
							   AND debito.SECCION_ID = seccion.ID 
							   AND seccion.CORREDOR_ID = corredor.ID	
							   AND debito.CHEQUEAR_VIAJE = :chequear_viaje');
			$sql->execute(array('chequear_viaje' => $chequear_viaje));
			return $sql->fetchAll();		
		} catch (PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	function get_detalle_debitos_por_chequear_viaje_OLD($chequear_viaje){
		try {
			//$conn = this->con();
			$conn = new PDO('mysql:host=localhost;dbname=r6000631_turcat', 'r6000631_turcat', '40tifofuZI');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = $conn->prepare('SELECT debito.FECHAHORA, debito.MONTODEBITO, debito.DEBITO, 
								   cliente.APELLIDO, cliente.NOMBRE
								   FROM debito, cliente, tarjeta 
								   WHERE debito.TARJETA_ID = tarjeta.ID 
								   AND tarjeta.CLIENTE_ID = cliente.ID 
								   AND debito.CHEQUEAR_VIAJE = :chequear_viaje');
			$sql->execute(array('chequear_viaje' => $chequear_viaje));
			return $sql->fetchAll();		
		} catch (PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	

	function get_chofer_por_usuario($usuario_chefer){
		try {
			$conn = new PDO('mysql:host=localhost;dbname=r6000631_turcat', 'r6000631_turcat', '40tifofuZI');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
			$sql = $conn->prepare('SELECT USER_APELLIDO, USER_NOMBRE FROM usuario WHERE USER_NAME = :usuario_chefer');
			$sql->execute(array('usuario_chefer' => $usuario_chefer));
			$resul = $sql->fetchAll();
			foreach ($resul as $reg) {
				return $reg['USER_APELLIDO'].', '.$reg['USER_NOMBRE'];
			}
			return 'chofer no encontrado';
		} catch (PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}

    // Load table data from file
    public function LoadData() {
        // Read file lines     		
		$registros = $this->get_detalle_debitos_por_chequear_viaje($this->chequear_viaje); 
        $data = array();
		$total_con_tarjeta = 0;
		$total_sin_tarjeta = 0;			
        foreach($registros as $reg) {
			$monto = $reg['MONTODEBITO'];
			$tipo_cobro = 'CON TARJETA';
			if($reg['DEBITO'] == '0'){
				$tipo_cobro = 'SIN TARJETA';
				$total_sin_tarjeta = floatval($monto) + $total_sin_tarjeta;		
			}	
			else{
				$total_con_tarjeta = floatval($monto) + $total_con_tarjeta;			
			}	
			$date = new DateTime($reg['FECHAHORA']);			
			$line = $date->format('d/m/Y H:i:s').';'.$reg['APELLIDO']. ', '.$reg['NOMBRE'].';$ '.$monto.';'.$tipo_cobro;				
            $data[] = explode(';', chop($line));
        }
		$line_blanco = ';;;'; 
		$line_total_sin_tarjeta = ''.';'.'TOTAL SIN TARJETA'.';$ '.$total_sin_tarjeta.';'.'';				
		$line_total_con_tarjeta = ''.';'.'TOTAL CON TARJETA'.';$ '.$total_con_tarjeta.';'.'';	
		$line_total_recaudado = ''.';'.'TOTAL RECAUDADO'.';$ '.($total_con_tarjeta+$total_sin_tarjeta).';'.'';	
		$data[] = explode(';', chop($line_blanco));	
		$data[] = explode(';', chop($line_total_sin_tarjeta));	
		$data[] = explode(';', chop($line_total_con_tarjeta));	
		$data[] = explode(';', chop($line_total_recaudado));	
        return $data;
    }	

    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(45, 55, 40, 45);
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {
            $this->Cell($w[0], 6, $row[0], 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, $row[1], 'LR', 0, 'C', $fill);
            $this->Cell($w[2], 6, $row[2], 'LR', 0, 'C', $fill);
            $this->Cell($w[3], 6, $row[3], 'LR', 0, 'C', $fill);
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

//$chequear_viaje_global = $_POST['chequear_viaje'];
$chequear_viaje_global = $_GET['check'];
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setChequearViaje($chequear_viaje_global);

$valores=split("_",$chequear_viaje_global);						
$fecha_inicio_viaje = $valores[0];
$usuario_chefer = $valores[1];
$corredor = $valores[2];		
$chofer = $pdf->get_chofer_por_usuario($usuario_chefer); 


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('turismocat.com.ar');
$pdf->SetTitle('Detalle de viaje');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "DETALLE DE VIAJE", PDF_HEADER_STRING);

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

// set font
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage();

// column titles
$header = array('FECHA DEBITO', 'PASAJERO', 'MONTO COBRADO', 'TIPO DE COBRO');

$data = $pdf->LoadData();

$date = new DateTime($fecha_inicio_viaje);

$html1 = '<p><strong>FECHA Y HORA DEL VIAJE: </strong>'.$date->format('d/m/Y H:i:s').'</p>';
$pdf->writeHTML($html1, true, false, true, false, '');

$html1 = '<p><strong>CHOFER: </strong>'.$chofer.'</p>';
$pdf->writeHTML($html1, true, false, true, false, '');

$html1 = '<p><strong>CORREDOR: </strong>'.$corredor.'</p><br>';
$pdf->writeHTML($html1, true, false, true, false, '');

// print colored table
$pdf->ColoredTable($header, $data);

$date = new DateTime();
$html1 = '<br><p><strong>Fecha y hora de impresión del informe: </strong>'.$date->format('d/m/Y H:i:s').'</p>';
$pdf->writeHTML($html1, true, false, true, false, '');

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('example_011.pdf', 'I');

?>
