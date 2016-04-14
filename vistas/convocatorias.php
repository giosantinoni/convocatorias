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
        <link rel="stylesheet" href="css/bootstrap-combobox.css">
        <link href="css/bootstrap.min.css" rel="stylesheet" />          
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Sistema de Gestión Convocatorias docente</title>
        <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type="text/javascript" src="js/bootstrap3-typeahead.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/bootstrap-select.min.js"></script>     
        <script src="js/bootstrap-combobox.js"></script>   
    </head>

    <body style="background:#efefee"><!--#96D161 verde manzana-->
        <header>
        	<?php include("header.php"); ?>
        </header>
        <section>
		    
			
            <center>

                <div class="panel-group" style="width:70%; font-family: 'Roboto', sans-serif; font-weight: 400;color:#777" id="accordion">
                    <?//php if ($idUsuarioMod == "") { ?>
                        <div class="panel panel-default">
                            <div style="background:#FFF" class="panel-heading" >
                                <h4 style="text-align:left;color:#777" class="panel-title">
                                    Nueva Convocatoria
                                </h4>
                            </div>
                                <div style="text-align:left; width:70%;" class="panel-body">
                                    <form id="agregar" name="agregar" method="post" action="convocatorias.php" Enctype = "multipart/form-data" align="left">

                                    <?php if($exito == 1){ ?>
                                     <div class="alert alert-success" id="passwordsNoMatchRegister">
                                      <span>
                                        <p>Convocatoria creada exitosamente!</p>
                                      </span>
                                     </div>
                                     <?php } 
                                     ?>

                                        <table align="left" width="99%">
                                          
                                            <tr>

                                                <td style="width:25%">
                                                    Organismo                                                   
                                                </td>
                                                <td style="width:70%">
                                                    <input type="hidden" name="id_organismo" value="<?php echo $organismo[0]['id'] ?>" />
                                                    <input class="form-control" type="text" name="id_org" id="id_org" disabled="true" value="<?php echo $organismo[0]['nombre'] .' - '. $organismo[0]['nivel']?>" />
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
                                                    Cantidad de horas                                                   
                                                </td>
                                                <td style="width:0%">                                                  
                                                <input class="form-control" type="text" name="horas" id="horas"  />
                                                </td>
                                              
                                            </tr>
                                            <tr>
                                                <td style="width:25%">
                                                    Horario                                                  
                                                </td>
                                                <td style="width:70%">
                                                    <input class="form-control" type="text" name="horario" id="horario"  />
                                                </td>
                                              
                                            </tr>
                                    
                                             <tr>
                                                <td style="width:25%">
                                                    Motivo                                                
                                                </td>
                                                <td style="width:70%">
                                                     <input class="form-control" type="text"  name="motivo" id="motivo"  />
                                                </td>
                                              
                                            </tr>
                                        
                                            <tr>
                                            
                                                <td>                                                                                                       
                                                    <button type="submit" class="btn btn-default" style="background:#efefee; padding-right:10px; color:#777" onclick="return comprobaragregar();" >Agregar</button>
                                                    <button type="button" class="btn btn-default" onclick="cancelar();" style="background:#efefee; padding-right:10px color:#777">Cancelar</button> 
                                                    
                                                </td>
                                                                                              
                                            </tr>
                                        </table>
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

                        //$('#passwordsNoMatchRegister').hide();

                        function comprobarpass() {
                            var c1 = document.getElementById("clave").value;
                            var c2 = document.getElementById("clave2").value;
                            var alerta = document.getElementById("alerta");
                            var alerta2 = document.getElementById("alerta2");
                            if (c1 == c2) {
                                alerta2.style.display = "block";
                                alerta.style.display = "none";
                            } else {
                                alerta.style.display = "block";
                                alerta2.style.display = "none";
                            }
                        }

                        function comprobarpassmod() {
                            var c1 = document.getElementById("clavemod").value;
                            var c2 = document.getElementById("clave2mod").value;
                            var alerta = document.getElementById("alertamod");
                            var alerta2 = document.getElementById("alerta2mod");
                            if (c1 === c2) {
                                alerta2.style.display = "block";
                                alerta.style.display = "none";
                            } else {
                                alerta.style.display = "block";
                                alerta2.style.display = "none";
                            }
                        }

                        function comprobaragregar() {                           
                            var alerta2 = document.getElementById("alerta2");
                            var alertn = document.getElementById("alertn");
                            var alertap = document.getElementById("alertap");
                            var alertdni = document.getElementById("alertdni");
                            var alertu = document.getElementById("alertu");
                            var alertc = document.getElementById("alertc");
                            var alertc2 = document.getElementById("alertc2");
                            var nombre = document.getElementById("nombre").value;
                            var apellido = document.getElementById("apellido").value;
                            var usuario = document.getElementById("usuario").value;
                            var dni = document.getElementById("dni").value;
                            var clave = document.getElementById("clave").value;
                            var clave2 = document.getElementById("clave2").value;
                            var condicion = 0;
                            if (nombre == "") {
                                alertn.style.display = "block";
                                condicion = 1;
                            } else {
                                alertn.style.display = "none";
                            }

                            if (apellido == '') {
                                alertap.style.display = "block";
                                condicion = 1;
                            } else {
                                alertap.style.display = "none";
                            }

                            if (dni == "") {
                                alertdni.style.display = "block";
                                condicion = 1;
                            } else {
                                alertdni.style.display = "none";
                            }

                            if (usuario == "") {
                                alertu.style.display = "block";
                                condicion = 1;
                            } else {
                                alertu.style.display = "none";
                            }

                            if (clave == "") {
                                alertc.style.display = "block";
                                condicion = 1;
                            } else {
                                alertc.style.display = "none";
                            }

                            if (clave2 == "") {
                                alertc2.style.display = "block";
                                condicion = 1;
                            } else {
                                alertc2.style.display = "none";
                            }                            

                            if (alerta2.style.display == "none") {
                                alert("Las contraseñas no coinciden.");
                                condicion = 1;
                            }
                            if (condicion == 1) {
                                return false;
                            } else {
                                return true;
                            }
                        }

                        function comprobarmodificar() {                           
                            var alerta2 = document.getElementById("alerta2mod");
                            var alertn = document.getElementById("alertnmod");
                            var alertap = document.getElementById("alertapmod");
                            var alertdni = document.getElementById("alertdnimod");
                            var alertu = document.getElementById("alertumod");
                            var alertc = document.getElementById("alertcmod");
                            var alertc2 = document.getElementById("alertc2mod");
                            var nombre = document.getElementById("nombremod").value;
                            var apellido = document.getElementById("apellidomod").value;
                            var dni = document.getElementById("dnimod").value;
                            var usuario = document.getElementById("usuariomod").value;
                            var clave = document.getElementById("clavemod").value;
                            var clave2 = document.getElementById("clave2mod").value;
                            var condicion = 0;
                            if (nombre == "") {
                                alertn.style.display = "block";
                                condicion = 1;
                            } else {
                                alertn.style.display = "none";
                            }

                            if (apellido == "") {
                                alertap.style.display = "block";
                                condicion = 1;
                            } else {
                                alertap.style.display = "none";
                            }

                            if (dni == "") {
                                alertap.style.display = "block";
                                condicion = 1;
                            } else {
                                alertdni.style.display = "none";
                            }

                            if (usuario == "") {
                                alertu.style.display = "block";
                                condicion = 1;
                            } else {
                                alertu.style.display = "none";
                            }

                            if (clave == "") {
                                alertc.style.display = "block";
                                condicion = 1;
                            } else {
                                alertc.style.display = "none";
                            }

                            if (clave2 == "") {
                                alertc2.style.display = "block";
                                condicion = 1;
                            } else {
                                alertc2.style.display = "none";
                            }

                            if (alerta2.style.display == "none") {
                                alert("Las contraseñas no coinciden.");
                                condicion = 1;
                            }
                            if (condicion == 1) {
                                return false;
                            } else {
                                return true;
                            }
                        }

                        function cancelar() {
                            window.location = 'convocatorias.php';
                        }

                        function confirmar() {
                            return confirm("¿Esta seguro que desea inactivar este usuario?");
                        }
                    
                 

                    </script>

