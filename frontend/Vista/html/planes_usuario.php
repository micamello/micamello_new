<div class="container-fluid"> 
        
  <div class="col-md-12">                  
    <div class="row">   
      <?php echo $html;?>                               
    </div>
    
    <!-- <div><p class="text-center" style="font-size: 20px;margin-bottom: 20px;">Planes Contratados</p></div> -->
    <div><h2 class="blue-text text-center">Planes Contratados</h2></div>
    <div class="panel-body ">
      <div id="no-more-tables">
        <table class="tabla-planes table table-bordered table-hover tabla-reg">
          <thead>
            <tr class="breadcrumb">
              <th class="text-center link-ord">Nombre del Plan</th> 
              <th class="text-center link-ord">Fecha de Inscripci&oacute;n</th>
              <th class="text-center link-ord">Fecha de Vencimiento</th>
              <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
              <th class="text-center link-ord">Autopostulaciones Restantes</th>
              <?php }else{ ?>
              <th class="text-center link-ord">Ofertas Restantes</th>
              <th class="text-center link-ord">Accesos Restantes</th>
              <?php } ?>  
              <th class="text-center link-ord">Fecha Pago</th>
              <th class="text-center link-ord">M&eacute;todo de Pago</th>
              <th class="text-center link-ord">Estado de Pago</th>
              <th class="text-center link-ord">Estado del Plan</th>
              <th class="text-center link-ord">Factura</th>                                                
            </tr>
          </thead>
          <tbody>
          <?php if(!empty($planUsuario)){ ?>
            <?php foreach ($planUsuario as $key => $value) { ?>
              
              <style>
                  #centrar{
                      text-align: center;
                  }
              </style>
              <tr align="center">
                  <td style="text-align: center;" data-title="Nombre:"><?php echo utf8_encode($value['nombre']); ?></td>
                  <td style="text-align: center; " data-title="Inscripci&oacute;n:"><?php echo date("d-m-Y", strtotime($value['fecha_compra'])); ?></td>
                  <td style="text-align: center;" data-title="Vencimiento:">
                      <?php if($value['fecha_caducidad'] != '-'){
                      echo date("d-m-Y", strtotime($value['fecha_caducidad'])); 
                      }else{ echo $value['fecha_caducidad']; } ?></td>
                  <?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
                    <td style="text-align:center;" data-title="Autopostulaciones:"><?php echo $value['num_post_rest'];?>
                    </td>
                  <?php }else{ ?>
                    <td style="text-align:center;" data-title="Ofertas:"><?php echo $value['num_post_rest'];?></td>   
                    <td style="text-align:center;" data-title="Accesos:"><?php echo $value['num_accesos_rest'];?></td>   
                  <?php } ?>    
                  
                  <?php if($value['costo'] == 0){ ?>
                      <td style="text-align: center;" data-title="M&eacute;todo" colspan="3">Plan Gratuito</td>
                  <?php }else{ 
                      if($value['id_comprobante'] != ""){                                                            
                      $datos = Modelo_Comprobante::obtieneComprobante($value['id_comprobante']); 
                  ?>
                      <td style="text-align: center;" data-title="Fecha Pago: "><?php echo date("d-m-Y", strtotime($datos['fecha_creacion'])); ?></td>
                      <td style="text-align: center;" data-title="M&eacute;todo"><?php echo Modelo_Comprobante::METODOS_PAGOS[$datos['tipo_pago']]; ?></td>
                      <td style="text-align: center;" data-title="Estado de Pago: "><?php echo  Modelo_Comprobante::TIPO_PAGOS[$datos['estado']]; ?></td>
                  <?php }else{ 

                      if(isset($value['id_empresa_plan_parent']) && $value['id_empresa_plan_parent'] != ""){
                      ?>
                          <td style="text-align: center;" data-title="M&eacute;todo: " colspan="3">Plan Heredado</td>
                  <?php }else{ ?>
                          <td style="text-align: center;" data-title="M&eacute;todo: " colspan="3">Plan Gratuito</td>
                  <?php  }
                      }
                  } ?>
                  <td style="text-align: center;" data-title="Estado del Plan: "><?php echo ESTADOS[$value['estado']]; ?></td>
                  <td style="text-align: center;" data-title="Factura: ">
                      <?php if(!empty($value['id_factura'])){ ?>

                        <a title="Descargar factura" href="<?php echo PUERTO.'://'.HOST.'/fileGEN/generarFactura/RIDE/'.Utils::encriptar($value['id_factura']).'/';?>"><img src="<?php echo PUERTO."://".HOST.'/imagenes/factura.png';?>" width="30%"></a>
                         
                      <?php }else{ echo '-'; } ?>
                  </td>                                                    
              </tr>
            <?php } ?>
          <?php }else{ ?>
              <tr><td colspan="10">No tiene ning&uacute;n plan comprado</td></tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>                                          

    <!-- Modal -->
    <div class="modal fade" id="msg_confirmplan" tabindex="-1" role="dialog" aria-labelledby="msg_confirmplan" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <form method="post" action="<?php echo PUERTO;?>://<?php echo HOST;?>/compraplan/" id="form_plan" name="form_plan">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Suscripci&oacute;n de plan</h5>        
              <input type="hidden" name="idplan" id="idplan" value="">
            </div>
            <div class="modal-body"><p>Procederas a suscribirte en el Plan, ¿Continuar?</p></div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary">Comprar</button>
            </div>
          </div>
        </form>
      </div>
    </div>            
  </div>
</div>