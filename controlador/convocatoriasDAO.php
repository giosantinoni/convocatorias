<?php

include_once 'conex.php';
include_once '../utilidades/fields.php';


if (isset($_POST["ac"])){

	@$ac = $_POST["ac"];

switch ($ac) {
    case "agregar":
        $con = conex::con();

        if (isset($_POST["id_organismo"]) &&
                isset($_POST["materia"]) &&
                isset($_POST["horas"]) && isset($_POST["horario"]) && isset($_POST["motivo"]) ) {
            
        
		
        $id_organismo = $_POST["id_organismo"];
        $id_materia = $_POST["materia"];
        $horas = $_POST["horas"];
        $horario = $_POST["horario"];
        $motivo = $_POST["motivo"];  
       // $motivo = "ALgun motivo";     
        
		

        $sql = "INSERT INTO convocatoria(id_materia, id_organismo, horas, horario, motivo)" .
                "values (:id_mat, :id_org, :horas, :horario, :motivo)";

        try {
            $campos_req = array($id_organismo, $id_materia, $horas, $horario,$motivo);
            verificar_campos_vacios($campos_req);            
            
            $stmp = $con->prepare($sql);
            $execute = $stmp->execute(array('id_mat' => $id_materia, 'id_org' => $id_organismo,
                'horas' => $horas,
                'horario' => $horario,
                'motivo' => $motivo));

            echo "<script language='javascript'>";
            echo "window.location='../vistas/convocatorias.php?exito=1'";
            echo "</script>";
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage();
            echo "<script language='javascript'>";
            echo "window.location='../vistas/convocatorias.php?exito=2'";
            echo "</script>";
        }

        } else{
        	echo "<script language='javascript'>";
            echo "window.location='../vistas/convocatorias.php?exito=2'";
            echo "</script>";
        }

        break;

	}

}



function consultarMateriasPorEscuela($id_organismo){
	try {
        $conn = conex::con();
		
			$sql = $conn->prepare('SELECT materia.descripcion,materia.id FROM materia, materia_organismo  
				WHERE  materia_organismo.id_materia = materia.id 
				AND materia_organismo.id_organismo =:id_organismo');
			$sql->execute(array('id_organismo'=>$id_organismo));
			
			return $sql->fetchAll();
		
    } catch (PDOException $e){
        echo "ERROR: " . $e->getMessage();
    }
}

function consultarOrganismo($id_organismo){
	try {
        $conn = conex::con();
		
			$sql = $conn->prepare('SELECT * FROM organismo WHERE  id =:id');
			$sql->execute(array('id'=>$id_organismo));
			
			return $sql->fetchAll();
		
    } catch (PDOException $e){
        echo "ERROR: " . $e->getMessage();
    }
}

?>
