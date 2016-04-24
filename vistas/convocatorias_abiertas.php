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
    $convocatoria = obtenerConvocatoria($id_conv);
}

$id_doc = -1;
if(isset($_POST['id_doc'])){
    $id_doc = $_POST['id_doc'];
}

$ver_resul_prov = -1;
if(isset($_POST['ver_resul_prov'])){
    $ver_resul_prov = $_POST['ver_resul_prov'];
}

$doc_checked = "";
if(isset($_POST['checked'])){
    $doc_checked = $_POST['checked'];
}
$inscripcion_success=false;


if(isset($_POST['fecha_inicio_insc'])){
    $fecha = date('Y-m-d',strtotime($_POST['fecha_inicio_insc']));
    actualizarInicioInscripcion($fecha , $id_conv);
}

if(isset($_POST['fecha_fin_insc'])){
   $fecha = date('Y-m-d',strtotime($_POST['fecha_fin_insc']));
   actualizarFinInscripcion($fecha, $id_conv);
}

if(isset($_POST['fecha_publicacion'])){
    $fecha = date('Y-m-d H:i:s');
    actualizarFechaPublicacion($fecha, $id_conv);
}


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

    } catch (Exception $e) {
        echo "ERROR: " . $e->getMessage();            
    }
}


function actualizarInicioInscripcion($fecha, $id_conv){

   $sql = "UPDATE convocatoria set fecha_inicio_insc =:fecha_ini WHERE id= :id
   ";


   try { 
    $con = conex::con();           
    $stmp = $con->prepare($sql);

    $stmp->execute(array('fecha_ini'=>$fecha, 'id' => $id_conv));            

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();            
}
}

function actualizarFinInscripcion($fecha, $id_conv){

   $sql = "UPDATE convocatoria set fecha_fin_insc =:fecha_fin WHERE id= :id
   ";
   try { 
    $con = conex::con();           
    $stmp = $con->prepare($sql);
    $stmp->execute(array('fecha_fin'=>$fecha, 'id' => $id_conv));            

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage();            
}
}

function actualizarFechaPublicacion($fecha, $id_conv){

   $sql = "UPDATE convocatoria set fecha_publicacion =:fecha_pub WHERE id= :id
   ";
   try { 
    $con = conex::con();           
    $stmp = $con->prepare($sql);
    $stmp->execute(array('fecha_pub'=>$fecha, 'id' => $id_conv));            

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
   <link href="css/datepicker.css" rel="stylesheet">       
   <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
   <script type="text/javascript" src="js/bootstrap.min.js"></script>
   <script type="text/javascript" src="js/bootstrap-select.min.js"></script> 
   <script src="js/bootstrap-datepicker.js"></script>   
   <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
   <script type="text/javascript" language="javascript" src="js/dataTables.bootstrap.min.js"></script>

</head>

<body style="background:#efefee"><!--#96D161 verde manzana-->
    <header>
        <?php include("header.php"); ?>
    </header>

    <?php 
    if($id_materia_sel != -1 && $id_org != -1 && $ver_resul_prov == -1){ 
       include_once("modal_lom.php");
   } 
   if($id_conv != -1 && $id_materia_sel == -1 && $ver_resul_prov == -1){ 
       include_once("modal_publicar_conv.php");
   }

   if($id_conv != -1 && $id_materia_sel != -1 && $id_org != -1 && $ver_resul_prov == 1){ 
       include_once("modal_resultado_prov.php");
   }
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
            echo '<thead><tr><th>Id</th><th style="width:80px;">Materia</th><th>Caracter Cargo</th><th>Horas</th><th>Horario</th><th>Motivo</th><th>Vacancia</th><th>Inscripcion</th><th>Acciones</th></tr></thead>';					


            echo "<tbody>";

            foreach ($registros as $reg) {                                    
                echo '<tr>';
                echo '<td>';
                echo generarIdentificador($organismo[0],$reg['identificador']);
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
                $date1 = new DateTime($reg['fecha_inicio_vac']);
                echo $date1->format("d/m/Y");
                if($reg['fecha_fin_vac']!=''){
                    $date2 = new DateTime($reg['fecha_fin_vac']);
                    echo ' a '.$date2->format("d/m/Y");
                }

                echo '</td>';
                echo '<td>';

                if(!empty($reg['fecha_inicio_insc']) && !empty($reg['fecha_fin_insc'])){
                    $date3 = new DateTime($reg['fecha_inicio_insc']);
                    $date4 = new DateTime($reg['fecha_fin_insc']);
                    echo $date3->format("d/m/Y").' a '.$date4->format("d/m/Y");
                }
                echo '</td>'; 
                echo '<td>';
                echo '<form style="float:left" name="form2" method="post" action="convocatorias_abiertas.php">

                <acronym title="Publicar Convocatoria">
                    <input id="id_conv" name="id_conv" type="hidden" value="' . $reg['id'] . '" />
                    <button type="submit" class="btn btn-default" data-toggle="modal" data-target="#public_conv">
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true">
                        </button>
                    </acronym>                                
                </form>

                <form style="float:left" name="form1" method="post" action="convocatorias_abiertas.php">
                    <input id="id_materia_sel" name="id_materia_sel" type="hidden" value="' . $reg['id_mat'] . '" />
                    <input id="id_org" name="id_org" type="hidden" value="' . $reg['id_org'] . '" />
                    <input id="id_conv" name="id_conv" type="hidden" value="' . $reg['id'] . '" />
                    <acronym title="Ver Orden de Mérito">
                        <button type="submit" class="btn btn-default">
                            <span class="glyphicon glyphicon-user" aria-hidden="true">
                            </button>
                        </acronym>                                
                    </form>

                    <form style="float:left" name="form1" method="post" action="convocatorias_abiertas.php">
                        <input id="id_materia_sel" name="id_materia_sel" type="hidden" value="' . $reg['id_mat'] . '" />
                        <input id="id_org" name="id_org" type="hidden" value="' . $reg['id_org'] . '" />
                        <input id="id_conv" name="id_conv" type="hidden" value="' . $reg['id'] . '" />
                        <input id="ver_resul_prov" name="ver_resul_prov" type="hidden" value="1" /> 
                        <acronym title="Ver Resultados Provisorios">
                            <button type="submit" class="btn btn-default">
                                <span class="glyphicon glyphicon-send" aria-hidden="true">
                                </button>
                            </acronym>                                
                        </form>'

                        ;

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

        $(document).ready(function() {
            $('#convocatorias').DataTable( {
                "order": [[ 0, "desc" ]]
            } );
        } );

        $('#lom').DataTable();
        $('#lom2').DataTable();


        $('#myModal').modal({
            show: 'true'
        }); 
        $('#public_conv').modal({
            show: 'true'
        }); 
        $('#myModalResultadoProv').modal({
         show: 'true'
     });   


        $('#fecha_inicio_insc').datepicker();
        $('#fecha_fin_insc').datepicker();                      
    </script>
    <?php
    function generarIdentificador($organismo,$identificador){


        
        if(strlen($identificador)==1)
            $identificador = "0".$identificador;

        if(strcasecmp($organismo['nombre'], "Escuela Superior Fray Mamerto Esquiu") == 0
            && strnatcasecmp($organismo['descripcion'], "Nivel Inicial")==0){
            return "FI".$identificador;
        }
        if(strcasecmp($organismo['nombre'], "Escuela Superior Fray Mamerto Esquiu")==0
            && strnatcasecmp($organismo['descripcion'], "Nivel Primario")==0){
            return "FP".$identificador;
        }
        if(strcasecmp($organismo['nombre'], "Escuela Superior Fray Mamerto Esquiu")==0
            && strnatcasecmp($organismo['descripcion'], "Nivel Secundario")==0){
            return "FS".$identificador;
        }   
        if(strcasecmp($organismo['nombre'], "ENET")==0
            && strnatcasecmp($organismo['descripcion'], "Nivel Secundario")==0){
            return "ES".$identificador;
        }   

}?>