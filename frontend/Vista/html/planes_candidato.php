<div class="comparison container-fluid">
  <h4 class="blue-text">Planes</h4>
  
  <div class="col-md-6">
    <div class="plus" style="box-shadow: 0px 0px 5px grey;">
      <img class="bag-planes" src="<?php echo PUERTO.'://'.HOST.'/imagenes/bag-plan.png';?>">
      <img class="img-plan-cand" src="<?php echo PUERTO.'://'.HOST.'/imagenes/plan-candidato.png';?>">
    </div>
    <div style="box-shadow: 0px 10px 5px grey; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
      <?php $indicador = "✔";?>
      <br>
      <br>
      <br>
      <ul>
        <li class="detalle-plan-user"><span><?php echo $indicador;?> Autopostulaciones</span></li>
        <br>
        <li class="detalle-plan-user"><span><?php echo $indicador;?> Primeros puestos en la b&uacute;squeda</span></li>
        <br>
        <li class="detalle-plan-user"><span><?php echo $indicador;?> Descubre tus Fortalezas Laborales</span></li>
        <br>
        <li class="detalle-plan-user"><span><?php echo $indicador;?> Notificaciones de ofertas laborales de su inter&eacute;s</span></li>
      </ul>
      <br>
      <br>
      <?php         
        foreach($planes as $key=>$plan){ 
          if($plan['id_plan'] == 1){continue;}
          $plan["id_plan"] = Utils::encriptar($plan["id_plan"]);
          $enlace = (empty($plan['costo'])) ? "href='".PUERTO."://".HOST."/compraplan/".$plan["id_plan"]."/'" : 
                                              "onclick=\"msg_compra('".$plan["id_plan"]."','".utf8_encode($plan["nombre"])."');\"";
          echo "<a ".$enlace." class='btn btn-blue'>Comprar</a>"; 
        }                            
        ?>
      <br>
      <br>
      <br>
      <br>
    </div>
  </div>

  <div class="col-md-6 top-50">
    <h1 style="color: #0a5472; font-size: 60px; font-weight: bold;">Test Canea</h1>
    <br>
    <br>
    <h3 style="color: black; font-weight: bold;">
      Obt&eacute;n mayor efectividad en la b&uacute;squeda de empleo
    </h3>
    <br>
    <h3 style="color: black;">
      Es un Test que tiene por objetivo evaluar las competencias laborales de los candidatos y facilitar el proceso de reclutamiento de las empresas.
    </h3>
    <br>
    <br>
    <br>
    <hr class="line-orange">
    <div class="col-md-12 center" style="padding-bottom: 10px;">
      <a href="<?php echo PUERTO.'://'.HOST.'/oferta/'?>" class="btn btn-orange">
        <h4 style="text-shadow: 1px 1px rgba(0, 0, 0, 0.7);">Buscar Empleos</h4>
      </a>  
    </div>
  </div>

  
</div>
 
<br>
<br>  
<!-- Modal -->
<div class="modal fade" id="msg_confirmplan" tabindex="-1" role="dialog" aria-labelledby="msg_confirmplan" aria-hidden="true">
  <div class="modal-dialog" role="document">    
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Confirmaci&oacute;n de Suscripci&oacute;n de Plan</h5>                        
      </div>
      <div class="modal-body">                           
        <h5>Usted procedera a suscribirse en el <b>Plan <span id="desplan"></span></b>&nbsp;¿Desea continuar?</h5>
        <!-- <p class="text-center"><i class="fa fa-shopping-cart fa-5x" aria-hidden="true"></i></p> -->
      </div>    
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <a class="btn btn-primary" href="" id="btncomprar">Continuar</a>
      </div>
    </div>    
  </div>
</div>