<?php
include_once '../script/session.inc.php';
include_once '../controlador/convocatoriasDAO.php';
include_once '../controlador/conex.php';

@$usuario = $_SESSION["s_usuario"]; 
@$usuarionombre = $_SESSION["s_nombreusuario"];
@$usuarioapellido = $_SESSION["s_apellidousuario"];
@$usuarioorganismo = $_SESSION["s_organismo"];
?>	


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:400,300">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sistema de Gestión Convocatorias docente</title>


        <!--<link href="css/bootstrap.min.css" rel="stylesheet" />          
        <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-select.min.js"></script> -->
		<link href="css/bootstrap.min.css" type="text/css" rel="stylesheet" /> 
        
        <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.min.css">       
        <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-select.min.js"></script> 

       <script type="text/javascript" language="javascript" src="js/jquery-1.11.3.min.js"></script>
       <script type="text/javascript" language="javascript" src="js/jquery.dataTables.min.js"></script>
       <script type="text/javascript" language="javascript" src="js/dataTables.bootstrap.min.js"></script>
		
    </head>

    <body style="background:#efefee"><!--#96D161 verde manzana-->
        <header>
            <?php include("header.php"); ?>
        </header>
        <section>
            <center>

                <div class="panel-group" style="width:70%; font-family: 'Roboto', sans-serif; font-weight: 400;color:#777" id="accordion">
                    
                       
                    
                </div>


                <div style="width:90%; font-family:'Roboto', sans-serif; font-weight:300">
                    <?php
                    $registros = obtenerConvotorias(true, $usuarioorganismo);
					
                    echo '<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">';
                    echo '<thead><tr><th>Id</th><th>Organismo</th><th style="width:80px;">Materia</th><th>Caracter Cargo</th><th>Horas</th><th>Horario</th><th>Motivo</th><th>Inscripcion</th><th>Vacancia</th></tr></thead>';					
                    
						
					echo "<tbody>";
					
                    foreach ($registros as $reg) {                                    
                        echo '<tr>';
                        echo '<td>';
                        echo $reg['id'];
                        echo '</td>';
                        echo '<td>';
                        echo $reg['org'];
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
                    <script >
					
						$(document).ready(function() {
                            $('#example').DataTable();
                        } );


                        
                    </script>

