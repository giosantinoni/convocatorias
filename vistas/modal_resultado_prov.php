<div class="modal fade" id="myModalResultadoProv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style ="font-family:'Roboto', sans-serif;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Resultado Provisorio</h4>
      </div>
      <div class="modal-body">
        <div style="width:90%; font-family:'Roboto', sans-serif; font-weight:400">
          <?php             
            $registros = obtenerResultadoConvocatoria($id_org, $id_materia_sel, $id_conv);
            echo '<table id="lom2" class="table table-striped table-bordered" cellspacing="0" width="100%">';
            echo '<thead><tr><th>Orden</th><th>Docente</th><th>DNI</th><th>Puntaje</th></thead>';                  
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
