<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style ="font-family:'Roboto', sans-serif;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Listado de Orden de Mérito</h4>
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
          <?php 
            $registros = obtenerOrdenMerito($id_org, $id_materia_sel);
            echo '<table id="lom" class="table table-striped table-bordered" cellspacing="0" width="100%">';
            echo '<thead><tr><th>Orden</th><th>Docente</th><th>DNI</th><th>Puntaje</th><th>Inscribir</th></thead>';                  
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
                echo $reg['dni'];
                echo '</td>';
                echo '<td>';
                echo $reg['puntaje'];
                echo '</td>';                        
                echo '<td>';
                $checked = "";                        
                if(consultarDocenteInscripto($reg['id_doc'], $id_conv)){
                    $checked = "checked";
                }
                echo '<form style="float:right" name="form1" method="post" action="convocatorias_abiertas.php">
                        <input id="id_materia_sel" name="id_materia_sel" type="hidden" value="' .$id_materia_sel . '" />
                        <input id="id_org" name="id_org" type="hidden" value="' .$id_org. '" />
                        <input id="checked" name="checked" type="hidden" value="' .$checked. '" />   
                        <input id="id_conv" name="id_conv" type="hidden" value="' .$id_conv . '" />
                        <input id="id_doc" name="id_doc" type="hidden" value="' .$reg['id_doc'] . '" />                            
                        <acronym title="Confirmar Firma del Docente">

                        <label><input type="checkbox" value="" '.$checked.' onChange="this.form.submit()">
                        </label>                                
                        </button>
                        </acronym>                                
                        </form>';
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
 <script>

                       
                        </script>
