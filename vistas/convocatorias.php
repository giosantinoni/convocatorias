<?php
include_once '../controlador/conex.php';
include_once '../controlador/convocatoriasDAO.php';

include_once '../script/session.inc.php';

@$usuario = $_SESSION["s_usuario"]; 
@$usuarionombre = $_SESSION["s_nombreusuario"];
@$usuarioapellido = $_SESSION["s_apellidousuario"];
@$usuarioorganismo = $_SESSION["s_organismo"];
/*
@$idUsuarioMod = $_POST["id"];

if ($idUsuarioMod != "") {
    $usuarioMod = $_POST["usuario"];
    $claveMod = '';
    $nombreMod = $_POST["nombre"];
    $apellidoMod = $_POST["apellido"];
    $dniMod = '';
}
*/

$exito = 0;
if(isset($_GET['exito'])){
    $exito = $_GET['exito'];
}

$materias = consultarMateriasPorEscuela($usuarioorganismo);
$organismo = consultarOrganismo($usuarioorganismo);
?>	


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:400,300">
        <link href="css/bootstrap.min.css" rel="stylesheet" />     
        <link href="css/bootstrap.css" rel="stylesheet">     
        <link href="css/datepicker.css" rel="stylesheet">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sistema de Gestión Convocatorias docente</title>
        <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-select.min.js"></script>
         <script src="js/bootstrap-datepicker.js"></script>   
  
    </head>

    <body style="background:#efefee"><!--#96D161 verde manzana-->
        <header>
        	<?php include("header.php"); ?>
        </header>
        <section>
		    
			
            <center>

                <div class="panel-group" style="width:70%; font-family: 'Roboto', sans-serif; font-weight: 400;color:#777" id="accordion">
                        <div class="panel panel-default">
                            <div style="background:#FFF" class="panel-heading" >
                                <h4 style="text-align:left;color:#777" class="panel-title">
                                    Nueva Convocatoria
                                </h4>
                            </div>
                                <div style="text-align:left; width:70%;" class="panel-body">
                                    <form id="agregar" name="agregar" method="post" action="convocatorias.php" Enctype = "multipart/form-data" align="left">

                                    <?php if($exito == 1){ ?>
                                     <div class="alert alert-success" id="sucessconvocatoria">
                                      <span>
                                        <Strong>Convocatoria creada exitosamente!</Strong>
                                      </span>
                                     </div>
                                     <?php } 
                                     else if ($exito == 2){?>
                                    <div class="alert alert-danger" id="dangerconvocatoria">
                                      <span>
                                        <Strong>Debe ingresar un valor en todos los campos</Strong>
                                      </span>
                                     </div>
                                     <?php }?>

                                        <table align="left" width="99%">
                                          
                                            <tr>

                                                <td style="width:25%">
                                                    Organismo                                                   
                                                </td>
                                                <td style="width:70%">
                                                    <input type="hidden" name="id_organismo" value="<?php echo $organismo[0]['id'] ?>" />
                                                    <input class="form-control" type="text" name="id_org" id="id_org" disabled="true" value="<?php echo $organismo[0]['nombre'] .' - '. $organismo[0]['descripcion']?>" />
                                                </td>
                                              
                                            </tr>
                                            <tr>
                                                <td style="width:25%">
                                                    Materia                                                   
                                                </td>
                                                <td style="width:70%">
                                                    <select class="form-control" name="materia" id="materia">
                                                        <?php 
                                                            foreach($materias as $mat){
                                                                $id = $mat['id'];
                                                                $valor = $mat['descripcion'];?>
                                                                <option value="<?php echo $mat['id'];?>">
                                                                <?php echo $mat['descripcion'];?></option>

                                                            <?php }?>
                                                        
                                                        
                                                        
                                                    </select>
                                                </td>
                                              
                                            </tr>
                                             <tr>
                                                <td style="width:25%">
                                                    Caracter del Cargo *                                                  
                                                </td>
                                                <td style="width:0%">                                                  
                                                <select class="form-control" name="caracter" id="caracter">
                                                        <option value="suplencia">Suplencia</option>
                                                        <option value="interinato">Interinato</option>
                                                         
                                                        
                                                        
                                                        
                                                    </select>
                                                </td>
                                              
                                            </tr>
                                            <tr>
                                                <td style="width:25%">
                                                    Cantidad de horas *                                                  
                                                </td>
                                                <td style="width:0%">                                                  
                                                <input class="form-control" type="text" name="horas" id="horas"  />
                                                </td>
                                              
                                            </tr>
                                            <tr>
                                                <td style="width:25%">
                                                    Horario *                                                 
                                                </td>
                                                <td style="width:70%">
                                                    <input class="form-control" type="text" name="horario" id="horario"  />
                                                </td>
                                              
                                            </tr>

                                            <tr>
                                                <td style="width:25%">
                                                    Dias de Licencia                                   
                                                </td>
                                                <td style="width:70%">
                                                     <input class="form-control" type="text"  name="dias" id="dias" placeholder="Un valor vacio significa que la duracion es indeterminada." />
                                                </td>

                                                <tr>
                                    
                                             <tr>
                                                <td style="width:25%">
                                                    Motivo de la Vacancia *                                                
                                                </td>
                                                <td style="width:70%">
                                                     <input class="form-control" type="text"  name="motivo" id="motivo"  />
                                                </td>

                                              </tr>
                                              
                                                <tr>                                            
                                                    <td>
                                                        Vancancia
                                                    </td>
                                                
                                                    <td style="width:25%">
                                                    <div class="input-append date" id="fecha_inicio_vac1" data-date-format="dd-mm-yyyy"style="float:left; margin-right:20px; margin-top: 10px; ">
                                                      <input class="form-control" type="text" placeholder="Inicio" id="fecha_inicio_vac" name="fecha_inicio_vac">
                                                      <span class="add-on"><i class="icon-th"></i></span>
                                                    </div>  
                                                   
                                                    <div class="input-append date" id="fecha_fin_vac1" data-date-format="dd-mm-yyyy" style="float:left ; margin-top: 10px;" >
                                                      <input class="form-control" type="text" placeholder="Fin" id="fecha_fin_vac">
                                                      <span class="add-on"><i class="icon-th"></i></span>
                                                    </div>
                                                    </td>
                                                </tr>

                                                <tr>                                            
                                                    <td>
                                                        Inscripción
                                                    </td>
                                                
                                                    <td style="width:25%">
                                                    <div class="input-append date" id="fecha_inicio_insc" data-date-format="dd-mm-yyyy" style="float:left; margin-right:20px; margin-top: 10px; ">
                                                      <input class="form-control" type="text" placeholder="Inicio">
                                                      <span class="add-on"><i class="icon-th"></i></span>
                                                    </div>  
                                                   
                                                    <div class="input-append date" id="fecha_fin_insc" data-date-format="dd-mm-yyyy" style="float:left; margin-right:20px; margin-top: 10px; ">
                                                      <input class="form-control" type="text" placeholder="Fin">
                                                      <span class="add-on"><i class="icon-th"></i></span>
                                                    </div>  
                                                    </td>
                                                </tr>  
                                            
                                     </table>
                                        <div style="text-align: center">
                                        <button type="submit" class="btn btn-default" style="background:#efefee; color:#777; margin-top: 20px;" 
                                           onclick="agregar();">Agregar</button>
                                        <button type="button" class="btn btn-default" onclick="cancelar();" style="background:#efefee; padding-right:10px color:#777; margin-top: 20px">Cancelar</button> 
                                                   
                                        </div>                                                       
                                           
                                        <input type="hidden" name="ac" value="agregar">
                                </form>
                                
                            </div>
                        </div>
                    
                   
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

                        $('#fecha_fin_vac').datepicker();
                        $('#fecha_inicio_vac').datepicker();
                         $('#fecha_fin_insc').datepicker();
                        $('#fecha_inicio_insc').datepicker();
                    
                        function cancelar() {
                            window.location = 'convocatorias.php';
                        }

                      
                        
                    </script>

