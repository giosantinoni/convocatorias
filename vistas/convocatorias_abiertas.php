<?php
include_once '../script/session.inc.php';
include_once '../controlador/convocatoriasDAO.php';
include_once '../controlador/conex.php';

@$usuario = $_SESSION["s_usuario"]; 
@$usuarionombre = $_SESSION["s_nombreusuario"];
@$usuarioapellido = $_SESSION["s_apellidousuario"];
@$usuarioorganismo = $_SESSION["s_organismo"];

$organismo = consultarOrganismo($usuarioorganismo);

$id_materia_sel = -1;
if(isset($_POST['id_materia_sel'])){
    $id_materia_sel = $_POST['id_materia_sel'];
}

$id_org = -1;
if(isset($_POST['id_org'])){
    $id_org = $_POST['id_org'];
}

$id_conv = -1;
if(isset($_POST['id_conv'])){
    $id_conv = $_POST['id_conv'];
}

$id_doc = -1;
if(isset($_POST['id_doc'])){
    $id_doc = $_POST['id_doc'];
}

$doc_checked = "";
if(isset($_POST['checked'])){
    $doc_checked = $_POST['checked'];
}
$inscripcion_success=false;

//Aqui efectuamos la inscripcion del docente a la convocatoria. Es decir se asienta la firma
if($id_doc != -1 && $id_conv != -1){
    if($doc_checked != "checked"){
        $inscripcion_success = inscribirDocente($id_doc, $id_conv);
    }

    else
        borrarInscripcionDocente($id_doc, $id_conv);
}

function inscribirDocente($id_doc, $id_conv){

    $sql = "INSERT INTO convocatoria_docente(id_docente, id_convocatoria, fecha_insc)" .
                "values (:id_doc, :id_conv, :fecha_insc)";
        try { 
            $con = conex::con();           
            $stmp = $con->prepare($sql);
            date_default_timezone_set('America/Argentina/Buenos_Aires');
            $hoy = date('Y-m-d H:i:s');
            $execute = $stmp->execute(array('id_doc' => $id_doc, 'id_conv' => $id_conv, 'fecha_insc' => $hoy));
            $con = null;  
            return true;          
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage();            
        }
}

function borrarInscripcionDocente($id_doc, $id_conv){

    $sql = "DELETE FROM convocatoria_docente WHERE convocatoria_docente.id_docente = :id_doc
                        AND convocatoria_docente.id_convocatoria = :id_conv";
        try { 
            $con = conex::con();           
            $stmp = $con->prepare($sql);
            $stmp->execute(array('id_doc'=>$id_doc, 'id_conv' => $id_conv));            
            $con = null;            
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage();            
        }
}

?>	


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:400,300">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sistema de Gestión Convocatorias docente</title>


       
		<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" /> 
        
        <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.min.css">       
        <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-select.min.js"></script> 
        
        <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" language="javascript" src="js/dataTables.bootstrap.min.js"></script>
		
    </head>

    <body style="background:#efefee"><!--#96D161 verde manzana-->
        <header>
            <?php include("header.php"); ?>
        </header>

        <?php 
          if($id_materia_sel != -1 && $id_org != -1){ 
                include_once("modal_lom.php");
           } 
           include_once("modal_publicar_conv.php");
         ?>

        <section>
            <center>

                <div class="panel-group" style="width:70%; font-family: 'Roboto', sans-serif; font-weight: 400;color:#777" id="accordion">
                    
                       
                    
                </div>


                <div style="width:90%; font-family:'Roboto', sans-serif; font-weight:300">

                <h4 style="margin-bottom:40px "><?php echo $organismo[0]['nombre'] .' - '. $organismo[0]['descripcion']?></h4>
                   
                    <?php
                    $registros = obtenerConvotorias(true, $usuarioorganismo);
					
                    echo '<table id="convocatorias" class="table table-striped table-bordered" cellspacing="0" width="100%">';
                    echo '<thead><tr><th>Id</th><th style="width:80px;">Materia</th><th>Caracter Cargo</th><th>Horas</th><th>Horario</th><th>Motivo</th><th>Inscripcion</th><th>Vacancia</th><th>Acciones</th></tr></thead>';					
                    
						
					echo "<tbody>";
					
                    foreach ($registros as $reg) {                                    
                        echo '<tr>';
                        echo '<td>';
                        echo $reg['id'];
                        echo '</td>';
                        echo '<td>';
                        echo $reg['mat'];
                        echo '</td>';
                        echo '<td>';
                        echo $reg['caracter_cargo'];
                        echo '</td>';
						echo '<td>';
                        echo $reg['horas'];
                        echo '</td>';
						echo '<td>';
                        echo $reg['horario'];
                        echo '</td>';
						echo '<td>';
                        echo $reg['motivo'];
                        echo '</td>';						
						echo '<td>';
                        echo $reg['fecha_inicio_ins'] .' a '.$reg['fecha_fin_ins'];;
                        echo '</td>';                  
                        echo '<td>';
                        echo $reg['fecha_inicio_vac'].' a '.$reg['fecha_fin_vac'];
                        echo '</td>';
                        echo '<td>';
                        echo '<form style="float:left" name="form1" method="post" action="convocatorias_abiertas.php">
                                <input id="id_materia_sel" name="id_materia_sel" type="hidden" value="' . $reg['id_mat'] . '" />
                                <input id="id_org" name="id_org" type="hidden" value="' . $reg['id_org'] . '" />
                                <input id="id_conv" name="id_conv" type="hidden" value="' . $reg['id'] . '" />
                                <acronym title="Ver Orden de Mérito">
                                <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-user" aria-hidden="true">
                                </button>
                                </acronym>                                
                                </form>

                                <form style="float:left" name="form2" method="post" action="convocatorias_abiertas.php">
                                
                                <acronym title="Publicar Convocatoria">
                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#public_conv">
                                <span class="glyphicon glyphicon-send" aria-hidden="true">
                                </button>
                                </acronym>                                
                                </form>';

                        echo '</td>';               
                        echo '</tr>';

                    }					
					
					echo "</tbody>";
					
                    echo '</table>';
                    ?>

					
                </div>
            </center>         
        </section>
        <footer style="background:#333333; clear:both; color:white;">
            <br>
                <center>Rectorado - Universidad Nacional de Catamarca | Año 2016 ©</center>
                <br>
                    </footer>
                    </body>   
                    </html>
                    <script>

                            $('#convocatorias').DataTable();
                      
                            $('#lom').DataTable();
                       

                     $('#myModal').modal({
                            show: 'true'
                        }); 

                        
                    </script>

