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
        $caracter_cargo = $_POST["caracter"];  
        $fecha_inicio_vac = $_POST["fecha_inicio_vac"];
        $fecha_fin_vac = $_POST["fecha_fin_vac"];
       
        
		

        $sql = "INSERT INTO convocatoria(id_materia, id_organismo, horas, horario, motivo, caracter_cargo, fecha_inicio_vac,fecha_fin_vac,estado)" .
                "values (:id_mat, :id_org, :horas, :horario, :motivo, :caracter_cargo, :fecha_inicio_vac, :fecha_fin_vac, :estado)";

        try {
            $campos_req = array($id_organismo, $id_materia, $horas, $horario,$motivo, $fecha_inicio_vac);
            verificar_campos_vacios($campos_req);            
            
            $stmp = $con->prepare($sql);
            $execute = $stmp->execute(array('id_mat' => $id_materia, 'id_org' => $id_organismo,
                'horas' => $horas,
                'horario' => $horario,
                'motivo' => $motivo,
                'caracter_cargo' => $caracter_cargo,
                'fecha_inicio_vac'=>$fecha_inicio_vac,
                'fecha_fin_vac' => $fecha_fin_vac,
                'estado'=> true));

            echo "<script language='javascript'>";
            echo "window.location='../vistas/convocatorias.php?exito=1'";
            echo "</script>";
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage();
            
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
		
			$sql = $conn->prepare('SELECT organismo.nombre, nivel.descripcion , organismo.id FROM organismo, nivel 
			 WHERE  organismo.id = :id AND 
			 organismo.id_nivel = nivel.id');
			$sql->execute(array('id'=>$id_organismo));
			
			return $sql->fetchAll();
		
    } catch (PDOException $e){
        echo "ERROR: " . $e->getMessage();
    }
}

function obtenerConvotorias($estado, $id_organismo){
	try {
        $conn = conex::con();
		
			$sql = $conn->prepare('SELECT convocatoria.id, materia.descripcion as mat, materia.id as id_mat, organismo.nombre as org, organismo.id as id_org, convocatoria.horas, convocatoria.caracter_cargo, convocatoria.horario, convocatoria.dias_duracion_lic, convocatoria.motivo, convocatoria.fecha_inicio_vac, convocatoria.fecha_fin_vac, convocatoria.fecha_inicio_insc, convocatoria.fecha_fin_insc FROM convocatoria, organismo, materia WHERE estado =:est AND organismo.id =:id_organismo
				AND convocatoria.id_organismo = organismo.id AND convocatoria.id_materia = materia.id
                ORDER BY convocatoria.id desc');
			$sql->execute(array('est'=>$estado, 'id_organismo' => $id_organismo));
			
			return $sql->fetchAll();
		
    } catch (PDOException $e){
        echo "ERROR: " . $e->getMessage();
    }
}

function obtenerConvocatoria($id_convocatoria){
    try {
        $conn = conex::con();
        
            $sql = $conn->prepare('SELECT * from convocatoria where id =:id');
            $sql->execute(array('id'=>$id_convocatoria));
            
            return $sql->fetch();
            
        
    } catch (PDOException $e){
        echo "ERROR: " . $e->getMessage();
    }
}

function obtenerOrdenMerito($id_organismo, $id_materia){
	try {
        $conn = conex::con();
		
			$sql = $conn->prepare('SELECT docente.id as id_doc, docente.nombre, docente.apellido, docente.dni, docente.email, lom.puntaje
						from docente, lom
						where docente.id = lom.id_docente
						and lom.id_materia =:id_materia
						and lom.id_nivel = (select organismo.id_nivel from organismo where
						organismo.id = :id_organismo)
						order by lom.puntaje desc');
			$sql->execute(array('id_materia'=>$id_materia, 'id_organismo' => $id_organismo));
			
			return $sql->fetchAll();
		
    } catch (PDOException $e){
        echo "ERROR: " . $e->getMessage();
    }
}

function consultarDocenteInscripto($id_doc, $id_conv){
	try {
        $conn = conex::con();
		
			$sql = $conn->prepare('SELECT convocatoria_docente.id_docente as id_doc
						from convocatoria_docente
						where convocatoria_docente.id_docente = :id_doc
						and convocatoria_docente.id_convocatoria = :id_conv');
			$sql->execute(array('id_doc'=>$id_doc, 'id_conv' => $id_conv));
			
			if(empty($sql->fetchAll())){
				return false;
			}
			return true;
		
    } catch (PDOException $e){
        echo "ERROR: " . $e->getMessage();
    }
}

function consultarMateria($id_materia){

  try {
        $conn = conex::con();
    
      $sql = $conn->prepare('SELECT materia.descripcion FROM materia
       WHERE  materia.id= :id');
      $sql->execute(array('id'=>$id_materia));
       
      $resultado = $sql->fetchAll();
      $materia = $resultado[0]['descripcion'];
      return $materia;

    
    } catch (PDOException $e){
        echo "ERROR: " . $e->getMessage();
    }
}

function obtenerResultadoConvocatoria($id_organismo, $id_materia, $id_convocatoria){
	try {
        $conn = conex::con();
		
			$sql = $conn->prepare('SELECT docente.id as id_doc, docente.nombre, docente.apellido, docente.dni, docente.email, lom.puntaje, convocatoria_docente.fecha_insc 
						from docente, lom, convocatoria_docente
						where docente.id = lom.id_docente
						and lom.id_materia =:id_materia
						and lom.id_nivel = (select organismo.id_nivel from organismo where
						organismo.id = :id_organismo)						
						and convocatoria_docente.id_convocatoria = :id_convocatoria
						and docente.id = convocatoria_docente.id_docente
						order by lom.puntaje desc');
			$sql->execute(array('id_materia'=>$id_materia, 'id_organismo' => $id_organismo, 'id_convocatoria'=>$id_convocatoria));
			
			return $sql->fetchAll();
		
    } catch (PDOException $e){
        echo "ERROR: " . $e->getMessage();
    }
}

/*function inscribirDocente($id_doc, $id_conv){

	$sql = "INSERT INTO convocatoria_docente(id_docente, id_convocatoria, fecha_insc)" .
                "values (:id_doc, :id_conv, :fecha_insc)";
        try { 
        	$con = conex::con();           
            $stmp = $con->prepare($sql);
            date_default_timezone_set('Argentina/Buenos Aires');
            $hoy = date('Y-m-d H:i:s');
            $execute = $stmp->execute(array('id_doc' => $id_doc, 'id_conv' => $id_conv, 'fecha_insc' => $hoy));
            $con = null;
            echo "<script language='javascript'>";
            echo "window.location='../vistas/convocatorias_abiertas.php'";
            echo "</script>";
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage();
            echo "<script language='javascript'>";
            echo "window.location='../vistas/convocatorias_abiertas.php'";
            echo "</script>";
        }
}*/

?>
