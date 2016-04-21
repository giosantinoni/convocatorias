<style>.datepicker { z-index: 1151 !important;  }</style>
<div class="modal fade" id="public_conv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style ="font-family:'Roboto', sans-serif;">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title" id="myModalLabel">Publicar Convocatoria</h4>
      </div>
      <div class="modal-body">
        <div style="width:90%; font-family:'Roboto', sans-serif; font-weight:400">
          <form style="float:left" name="guardarFechas" method="post" action="convocatorias_abiertas.php">
            <input id="nro_conv" type="hidden" name="id_conv"value="<?php echo $convocatoria['id'] ?>" />
           <div style="clear:both">
             <label>Fechas de Inscripcion</label>
           </div>
           <div class="input-append date" data-date-format="dd-mm-yyyy"style="float:left; margin-bottom: 15px;" id="fecha_inicio_insc">
            <input class="form-control" type="text" name="fecha_inicio_insc" placeholder="Inicio"  onChange="this.form.submit()" value="<?php  $date1 = new DateTime( $convocatoria['fecha_inicio_insc'] );
                        echo $date1->format("d/m/Y"); ?>">
            <span class="add-on"><i class="icon-th"></i></span>
          </div> 
          <div class="input-append date" data-date-format="dd-mm-yyyy"style="float:left; margin-bottom: 15px; margin-left: 10px;" id="fecha_fin_insc">
            <input class="form-control" type="text" name="fecha_fin_insc" placeholder="Fin"  onChange="this.form.submit()" value="<?php  $date1 = new DateTime( $convocatoria['fecha_fin_insc'] );
                        echo $date1->format("d/m/Y"); ?>">
            <span class="add-on"><i class="icon-th"></i></span>
          </div> 
        </form>
        <form name="publicar" method="post" action="../tcpdf/reportes/reporte_transparente.php">

          <div style="clear:both">
           <label>Lugar de Inscripción</label>
           <input name="lugar_insc"  value="" class="form-control" />
         </div>
         <div style="clear:both">
           <label>Horarios de Inscripcion</label>
           <input name="horario_insc"  value="" class="form-control" />
         </div>

         <input type="hidden" name="fecha_publicacion" value="<?php echo date('d/m/y');?>">
         <input id="nro_conv" type="hidden" name="nro_conv"value="<?php echo $convocatoria['id'] ?>" />
         <input id="inst" type="hidden" name="inst" value="<?php echo $organismo[0]['nombre']?> - <?php echo $organismo[0]['descripcion'] ?>"/>
         <input name="caracter_cargo" type="hidden" value="<?php echo $convocatoria['caracter_cargo']?>"/>
         <input name="area_curr"  type="hidden" value="<?php echo consultarMateria($convocatoria['id_materia']) ?>"/>
         <input name="cant_horas" type="hidden"  value="<?php echo $convocatoria['horas'] ?>"/>
         <input name="horarios" type="hidden" value="<?php echo $convocatoria['horario'] ?>"/>
         <input name="motivo" type="hidden" value="<?php echo $convocatoria['motivo'] ?>"/>

         <input name="fecha_insc" type="hidden"   value="Desde <?php echo $convocatoria['fecha_inicio_insc'] ?> hasta <?php echo $convocatoria['fecha_inicio_insc'] ?>" />
         <div class="modal-footer" style="clear: both;">
          <button type="submit" class="btn btn-primary" >Publicar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>


