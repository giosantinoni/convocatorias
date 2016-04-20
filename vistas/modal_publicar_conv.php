<div class="modal fade" id="public_conv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style ="font-family:'Roboto', sans-serif;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Publicar Convocatoria</h4>
        Se enviará un e-mail a los siguientes docentes
      </div>
      <div class="modal-body">
      <?php 
            if($inscripcion_success){ 
        ?>  
      <div class="alert alert-success" id="sucessinscripcion" style="width:90%; font-family:'Roboto', sans-serif; font-weight:300">
          <span>
            <Strong>Docente inscripto.</Strong>
          </span>
        </div>
        <?php }?>
        <div style="width:90%; font-family:'Roboto', sans-serif; font-weight:400">
          
          <div class="input-append date" id="fecha_pub" data-date-format="dd-mm-yyyy"style="float:left; margin-bottom: 30px;">
           <label style="margin-bottom: 5px;">Fecha de Publicacion </label>
            <input class="form-control" type="text" id="fecha_publicacion" name="fecha_publicacion" value="<?php echo date('d/m/y');?>" disabled = "true">
            <span class="add-on"><i class="icon-th"></i></span>
          </div> 
         <div style="clear:both">
           Fechas de Inscripcion
         </div>
          <div class="input-append date" id="fecha_pub" data-date-format="dd-mm-yyyy"style="float:left; margin-bottom: 30px;">
            <input class="form-control" type="text" name="fecha_inicio_insc" placeholder="Inicio">
            <span class="add-on"><i class="icon-th"></i></span>
          </div> 


          <div class="input-append date" id="fecha_pub" data-date-format="dd-mm-yyyy"style="float:left; margin-bottom: 30px;">
            <input class="form-control" type="text" name="fecha_fin_insc" placeholder="Fin">
            <span class="add-on"><i class="icon-th"></i></span>
          </div> 

          <?php 
            $registros = obtenerOrdenMerito($id_org, $id_materia_sel);
            echo '<table id="lom" class="table table-striped table-bordered" cellspacing="0" width="100%">';
            echo '<thead><tr><th>Orden</th><th>Docente</th><th>e-mail</th></thead>';                  
            echo "<tbody>";
            $i=1;
            foreach ($registros as $reg) {                        
                echo '<tr>';
                echo '<td>';
                echo $i . '&deg';
                echo '</td>';
                echo '<td>';
                echo $reg['apellido'].', '.$reg['nombre'];
                echo '</td>';
                echo '<td>';
                echo $reg['email'];
                echo '</td>';
               
                echo '</tr>';
                
            $i++;
            }
            echo "</tbody>";
            echo '</table>';
          ?>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
