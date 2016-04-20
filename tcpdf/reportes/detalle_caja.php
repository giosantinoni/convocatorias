<?php

require_once('tcpdf_include.php');

// extend TCPF with custom functions
class MYPDF extends TCPDF {
	
	public $id_usuario;
	public $fecha_inicio;
	public $fecha_cierre;
	public $habilitada;
	public $id_caja;
	public $total_recargas;
	public $total_retiros;
	
	public function setIdUsuario($id){
		$this->id_usuario = $id;
	}
	
	public function setFechaInicio($fecha_inicio){
		$this->fecha_inicio = $fecha_inicio;
	}
	
	public function setFechaCierre($fecha_cierre){
		$this->fecha_cierre = $fecha_cierre;
	}
	
	public function setHabilitada($habilitada){
		$this->habilitada = $habilitada;
	}
	
	public function setIdCaja($id_caja){
		$this->id_caja = $id_caja;
	}
	
	public function consultarusuarioPorID($id) {
		try {
			$conn = new PDO('mysql:host=localhost;dbname=r6000631_turcat', 'r6000631_turcat', '40tifofuZI');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = $conn->prepare('SELECT * FROM usuario WHERE ID = '.$id);
			$sql->execute();
			$resul = $sql->fetchAll();
			foreach($resul as $reg){
				return $reg['USER_NOMBRE'].' '.$reg['USER_APELLIDO'];
			}
		} catch (PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}
	
	public function consultarDetalleCaja($fecha_inicio, $fecha_cierre, $habilitada, $id_usuario) {
		try {		
			$conn = new PDO('mysql:host=localhost;dbname=r6000631_turcat', 'r6000631_turcat', '40tifofuZI');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$consulta = '';
			if($habilitada){
				$consulta = "SELECT * FROM recarga WHERE USUARIO_ID =:usu AND FECHAHORA  >=:inicio";
				$sql = $conn->prepare($consulta);
				$sql->execute(array('usu' => $id_usuario, 'inicio' => $fecha_inicio));
				return $sql->fetchAll();
			}
			else{
				$consulta = "SELECT * FROM recarga WHERE USUARIO_ID =:usu AND FECHAHORA  between :inicio AND :fin";
				$sql = $conn->prepare($consulta);
				$sql->execute(array('usu' => $id_usuario, 'inicio' => $fecha_inicio, 'fin' => $fecha_cierre));
				return $sql->fetchAll();
			}		        
		} catch (PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}

	public function consultarRetiros($id_caja){
		try {		
			$conn = new PDO('mysql:host=localhost;dbname=r6000631_turcat', 'r6000631_turcat', '40tifofuZI');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);				
			$sql = $conn->prepare("SELECT retiro.ID, retiro.FECHAHORA, retiro.MONTO, 
								   usuario.USER_APELLIDO, usuario.USER_NOMBRE 
								   FROM retiro, usuario 
								   WHERE retiro.ID_SUPERVISOR = usuario.ID 
								   AND retiro.ID_CAJA = ".$id_caja);
			$sql->execute();
			return $sql->fetchAll();				       
		} catch (PDOException $e) {
			echo "ERROR: " . $e->getMessage();
		}
	}

    // Load table data from file
    public function LoadData() {
        // Read file lines     		
		$registros = $this->consultarDetalleCaja($this->fecha_inicio, $this->fecha_cierre, $this->habilitada, $this->id_usuario); 
        $data = array();			
        foreach($registros as $reg) {
			$id = $reg['ID'];                        
            $fecha_hora = $reg['FECHAHORA'];   
			$date = new DateTime($fecha_hora);	
			$monto_recarga = $reg['MONTORECARGA'];
            $total_recarga = floatval($monto_recarga) + $total_recarga;	
			
			$line = $id.';'.$date->format('d/m/Y H:i:s').';$ '.$monto_recarga;				
            $data[] = explode(';', chop($line));
        }
		$line_blanco = ';;'; 
		$line_total_regargas = ''.';'.'TOTAL RECARGAS'.';$ '.$total_recarga;								
		$data[] = explode(';', chop($line_blanco));	
		$data[] = explode(';', chop($line_total_regargas));	
		$this->total_recargas = $total_recarga;
        return $data;
    }	
	
	public function LoadDataRetiros() {
        // Read file lines     		
		$registros = $this->consultarRetiros($this->id_caja); 
        $data = array();			
        foreach($registros as $reg) {
			$id = $reg['ID'];                        
            $fecha_hora = $reg['FECHAHORA'];
			$date = new DateTime($fecha_hora);			
			$monto = $reg['MONTO'];	
			$nom_sup = 	$reg['USER_NOMBRE'] . ','. $reg['USER_APELLIDO'];
			$total_retiro = floatval($monto) + $total_retiro;	
			
			$line = $id.';'.$date->format('d/m/Y H:i:s').';$ '.$monto.';'.$nom_sup;				
            $data[] = explode(';', chop($line));
        }
		$line_blanco = ';;'; 
		$line_total_retiro = ''.';'.'TOTAL RETIROS'.';$ '.$total_retiro.';';								
		$data[] = explode(';', chop($line_blanco));	
		$data[] = explode(';', chop($line_total_retiro));	
		$this->total_retiros = $monto;
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
        $w = array(40, 55, 40);
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
            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
	
	public function ColoredTableRetiros($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(255, 0, 0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128, 0, 0);
        $this->SetLineWidth(0.3);
        $this->SetFont('', 'B');
        // Header
        $w = array(40, 55, 40, 45);
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
//echo 'llego abajo de la clase';
$params = $_GET['params'];
$valores=split("_",$params);	
$id_usuario = $valores[0];
$fecha_inicio = $valores[1];
$fecha_cierre = $valores[2];
$habilitada = $valores[3];
$id_caja = $valores[4];

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setIdUsuario($id_usuario);
$pdf->setFechaInicio($fecha_inicio);
$pdf->setFechaCierre($fecha_cierre);
$pdf->setHabilitada($habilitada);
$pdf->setIdCaja($id_caja);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('turismocat.com.ar');
$pdf->SetTitle('Detalle de Movimientos de Caja');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "DETALLE DE MOVIMIENTOS CAJA", PDF_HEADER_STRING);

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
$header = array('Código de Recarga', 'Fecha y Hora de Recarga', 'Monto Recarga');

$data = $pdf->LoadData();

$html1 = '<p><strong>Cajero: </strong>'.$pdf->consultarusuarioPorID($id_usuario).'</p>';
$pdf->writeHTML($html1, true, false, true, false, '');

$date = new DateTime($fecha_inicio);
$html1 = '<p><strong>Fecha Inicio Caja: </strong>'.$date->format('d/m/Y H:i:s').'</p>';
$pdf->writeHTML($html1, true, false, true, false, '');

$date = new DateTime($fecha_cierre);
$date = $date->format('d/m/Y H:i:s');
if($date == '30/11/-0001 00:00:00'){
	$date = '-';
}
$html1 = '<p><strong>Fecha Cierre Caja: </strong>'.$date.'</p>';
$pdf->writeHTML($html1, true, false, true, false, '');

$html1 = '<p><strong>Estado de Caja: </strong>'.$habilitada.'</p><br>';
$pdf->writeHTML($html1, true, false, true, false, '');

$html1 = '<center><p><strong>DETALLE DE RECARGAS: </strong></p></center><br>';
$pdf->writeHTML($html1, true, false, true, false, '');
// print colored table
$pdf->ColoredTable($header, $data);

$html1 = '<br><center><p><strong>DETALLE DE RETIROS: </strong></p></center><br>';
$pdf->writeHTML($html1, true, false, true, false, '');

$data = $pdf->LoadDataRetiros();
$header = array('Código de Retiro', 'Fecha y Hora de Retiro', 'Monto Retiro', 'Supervisor');
$pdf->ColoredTableRetiros($header, $data);

$html1 = '<br><center><p><strong>TOTAL EN CAJA: </strong> $ '.($pdf->total_recargas - $pdf->total_retiros).'</p></center><br>';
$pdf->writeHTML($html1, true, false, true, false, '');

$date = new DateTime();
$html1 = '<p><strong>Fecha y hora de impresión del informe: </strong>'.$date->format('d/m/Y H:i:s').'</p>';
$pdf->writeHTML($html1, true, false, true, false, '');

// ---------------------------------------------------------

// close and output PDF document
$pdf->Output('detalle_caja.pdf', 'I');

?>
