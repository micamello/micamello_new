<div class="container-fluid">
  <div class="container">
    <h4 class="blue-text">Planes</h4>
    
    <div class="col-md-12">

      <input type="hidden" id="simbolo" value="<?php echo SUCURSAL_MONEDA;?>">

      <div class="pricingdiv flex-container">
      <?php 
      if (!empty($gratuitos) && is_array($gratuitos)){ 
        $opc_select = '';
        foreach($gratuitos as $gratuito){ 
          $gratuito["id_plan"] = Utils::encriptar($gratuito["id_plan"]);
      ?>
          <input type="hidden" id="grattitulo_<?php echo $gratuito["id_plan"];?>" value="<?php echo utf8_encode($gratuito["nombre"]);?>">
          <input type="hidden" id="gratprom_<?php echo $gratuito["id_plan"];?>" value="<?php echo $gratuito["promocional"];?>">
          <input type="hidden" id="gratext_<?php echo $gratuito["id_plan"];?>" value="<?php echo $gratuito["extension"];?>">
          <input type="hidden" id="gratid_<?php echo $gratuito["id_plan"];?>" value="<?php echo $gratuito["id_plan"];?>">
          <input type="hidden" id="gratdura_<?php echo $gratuito["id_plan"];?>" value="<?php echo $gratuito["duracion"];?>">
          <input type="hidden" id="gratcosto_<?php echo $gratuito["id_plan"];?>" value="<?php echo number_format($gratuito["costo"],2);?>">
          <?php
          $listadoAcciones = explode(",",$gratuito['acciones']);
          $listadoPermisos = explode(",",$gratuito['permisos']);
          $permisos_grat = '';
          foreach($listadoPermisos as $key => $permiso){
            if ($listadoAcciones[$key] == "publicarOferta" || $listadoAcciones[$key] == "publicarOfertaConfidencial"){
              $permiso = str_replace('NRO',$gratuito["num_post"],$permiso);                        
              $permiso = ($gratuito["num_post"] > 1) ? str_replace("publicaci","publicaciones",$permiso) : str_replace("publicaci","publicaci&oacute;n",$permiso);                     
            }
            if ($listadoAcciones[$key] == "adminEmpresas"){
              $permiso = str_replace('NRO',$gratuito["num_cuenta"],$permiso);
            }
            if ($listadoAcciones[$key] == "accessos"){
              $permiso = str_replace('NRO',$gratuito["num_accesos"],$permiso);
            } 
            if ($listadoAcciones[$key] == "buscarCandidatosPostulados"){
              if (!empty($gratuito["limite_perfiles"])){
                $permiso = str_replace('NRO',$gratuito["limite_perfiles"],$permiso);  
              }
              else{
               $permiso = str_replace('NRO','',$permiso);   
              }
            } 
            if ($listadoAcciones[$key] == "descargarHv"){
              if (!empty($gratuito["limite_perfiles"])){
                $permiso = str_replace('NRO',"los ".$gratuito["limite_perfiles"],$permiso);
              }
              else{
                $permiso = str_replace('NRO','todos los ',$permiso);   
              }
            }
            $permisos_grat .= utf8_encode(trim($permiso)).'||';
          }
          $text_publicacion = ($gratuito["num_post"] > 1) ? $gratuito["num_post"]."&nbsp;publicaciones" : $gratuito["num_post"]."&nbsp;publicaci&oacute;n";                 
          $opc_select .= '<option value="'.$gratuito["id_plan"].'">'.$gratuito["nombre"].'&nbsp;-&nbsp;'.$gratuito["num_post"].'&nbsp;'.$text_publicacion.'</option>';
          ?>
          <input type="hidden" id="gratpermiso_<?php echo $gratuito["id_plan"];?>" value="<?php echo $permisos_grat;?>">  
        <?php } ?> 

        <!--plan gratis-->
        <div id="gratul" style="" class="izq theplan plan-tabla col-xs-12 col-md-4 flex-item shadow-box-planes">
          <br>
          <div style="background-color: #155476; 
                      border-radius: 20px 20px 0 0;
                      color: white;
                      font-family: ‘Roboto’;
                      font-size: 24pt;
                      font-weight: 900;
                      text-shadow: 1px 1px rgba(0, 0, 0, 0.7);
                      height: auto;"  
               id="grattitulo">
          </div>
          <div id="avisocosto" class="plan-precio-gratis">
            <?php $msgcosto = (isset($aviso_promocional) && $aviso_promocional==1) ? "Antes " : "";?>             
            <?php echo $msgcosto.SUCURSAL_MONEDA.number_format($aviso["costo"],2);?>
          </div>

          <div style="background-color: #155476; color: white; text-shadow: 1px 1px rgba(0, 0, 0, 0.7);"><small>(El precio incluye IVA)</small></div>
          <?php //} ?> 
          <div id="gratdura" class="plan-dias-gratis"></div>
          <br><br><br>


          <?php if (count($gratuitos) > 1){ ?>
          <div class="select-plan1">
            <select class="form-control" id="gratcmb">
              <?php echo $opc_select; ?>
            </select>
          </div>                   
          <?php } else{  ?>
              <input type="hidden" id="gratcmb" value="<?php echo $gratuito["id_plan"];?>">
              <input type="hidden" id="gratnombre" value="<?php echo utf8_encode($gratuito["nombre"]);?>">
          <?php }?>
          <div id="gratpermisos"></div>                    
          <br>
          <br>
          <br>
          <br> 

          <!--plan gratis-->
          <div>
            <a class="btn btn-plan-gratis" onclick="buttongrat();">
              <span class="icon-tag"></span>Comenzar
            </a>
            <img class="top-0" src="<?php echo PUERTO."://".HOST."/imagenes/plan2-base.png"?>">
          </div>

          <p><br></p>
        </div>
      <?php } ?> 

      <?php 
      if (!empty($planes) && is_array($planes)){

        $opc_select = '';
        foreach($planes as $plan){ 
          $plan["id_plan"] = Utils::encriptar($plan["id_plan"]);
      ?>
          <input type="hidden" id="plantitulo_<?php echo $plan["id_plan"];?>" value="<?php echo utf8_encode($plan["nombre"]);?>">
          <input type="hidden" id="planprom_<?php echo $plan["id_plan"];?>" value="<?php echo $plan["promocional"];?>">
          <input type="hidden" id="planext_<?php echo $plan["id_plan"];?>" value="<?php echo $plan["extension"];?>">
          <input type="hidden" id="planid_<?php echo $plan["id_plan"];?>" value="<?php echo $plan["id_plan"];?>">
          <input type="hidden" id="plandura_<?php echo $plan["id_plan"];?>" value="<?php echo $plan["duracion"];?>">
          <input type="hidden" id="plancosto_<?php echo $plan["id_plan"];?>" value="<?php echo number_format($plan["costo"],2);?>">
          <?php
          $listadoAcciones = explode(",",$plan['acciones']);
          $listadoPermisos = explode(",",$plan['permisos']);
          $permisos_plan = '';
          foreach($listadoPermisos as $key => $permiso){
            if ($listadoAcciones[$key] == "publicarOferta" || $listadoAcciones[$key] == "publicarOfertaConfidencial"){
                $permiso = str_replace('NRO',$plan["num_post"],$permiso);
                $permiso = ($plan["num_post"] > 1) ? str_replace("publicaci","publicaciones",$permiso) : str_replace("publicaci","publicaci&oacute;n",$permiso);
            }
            if ($listadoAcciones[$key] == "adminEmpresas"){
              $permiso = str_replace('NRO',$plan["num_cuenta"],$permiso);
            }
            if ($listadoAcciones[$key] == "accessos"){
              $permiso = str_replace('NRO',$plan["num_accesos"],$permiso);
            }
            if ($listadoAcciones[$key] == "buscarCandidatosPostulados"){
              if (!empty($plan["limite_perfiles"])){    
                $permiso = str_replace('NRO',$plan["limite_perfiles"],$permiso);
              }
              else{
                $permiso = str_replace('NRO','',$permiso); 
              }
            }
            if ($listadoAcciones[$key] == "descargarHv"){
              if (!empty($plan["limite_perfiles"])){
                $permiso = str_replace('NRO',"los ".$plan["limite_perfiles"],$permiso);
              }
              else{
                $permiso = str_replace('NRO','todos los ',$permiso);   
              }
            }  
            $permisos_plan .= utf8_encode(trim($permiso)).'||';
          }                   
            $text_publicacion = ($plan["num_post"] > 1) ? $plan["num_post"]."&nbsp;publicaciones" : $plan["num_post"]."publicaci&oacute;n";
          $opc_select .= '<option value="'.$plan["id_plan"].'">'.$plan["nombre"].'&nbsp;-&nbsp;'.$text_publicacion.'</option>';
          ?>
          <input type="hidden" id="planpermiso_<?php echo $plan["id_plan"];?>" value="<?php echo $permisos_plan;?>">
        <?php } ?>

        <?php 
        if (/*(isset($aviso_promocional) && $aviso_promocional==1) || (*/!isset($gratuitos) || empty($gratuitos)/*)*/){
          $estilo = "izq col-md-offset-2";
        }  
        else{
          $estilo = "cen";
        }?>

        <div id="planul" style="" class="<?php echo $estilo;?> theplan plan-tabla col-xs-12 col-md-4 flex-item shadow-box-planes">
          <div style="background-color: #fd5b15; 
                      border-radius: 20px 20px 0 0;
                      font-family: ‘Roboto’;
                      font-size: 24pt;
                      font-weight: 900;
                      text-shadow: 1px 1px rgba(0, 0, 0, 0.7);
                      height: auto;"  
               id="plantitulo">
          </div>
          <div id="plancosto" class="plan-precio-efectivo"></div>
          <div style="background-color: #fd5b15; color: white; text-shadow: 1px 1px rgba(0, 0, 0, 0.7);"><small>(El precio incluye IVA)</small></div>
          <div id="plandura" class="plan-dias-efectivo"></div>
          <br>
          <?php if (count($planes) > 1){ ?>
          <div class="select-plan">
            <select class="form-control select-planes" id="plancmb">
              <?php echo $opc_select; ?>
            </select><br>
          </div>
          <?php } else{ ?>
            <input type="hidden" id="plancmb" value="<?php echo Utils::encriptar($plan["id_plan"]);?>">
            <input type="hidden" id="plannombre" value="<?php echo utf8_encode($plan["nombre"]);?>">
          <?php } ?>  
          <div id="planpermisos"></div>                     
          <br>
          <br>
          <br>
          
          <!--plan efectivo-->
          <div>
            <a class="btn btn-plan-efectivo" onclick="buttonplan();">
              <span class="icon-tag"></span>Comenzar
            </a>
            <img class="top-0" src="<?php echo PUERTO."://".HOST."/imagenes/plan1-base.png"?>">
          </div>

          <p><br></p>
        </div>
                                            
        <?php } ?> 

        <?php 
        if (!empty($avisos) && is_array($avisos)){ 
          $opc_select = '';
          foreach($avisos as $aviso){                 
            $aviso["id_plan"] = Utils::encriptar($aviso["id_plan"]);
        ?>
            <input type="hidden" id="avisotitulo_<?php echo $aviso["id_plan"];?>" value="<?php echo (isset($aviso_promocional) && $aviso_promocional==1) ? utf8_encode($aviso["nombre"])." (Promocional)" : utf8_encode($aviso["nombre"]);?>">
            <input type="hidden" id="avisoprom_<?php echo $aviso["id_plan"];?>" value="<?php echo $aviso["promocional"];?>">
            <input type="hidden" id="avisoext_<?php echo $aviso["id_plan"];?>" value="<?php echo $aviso["extension"];?>">
            <input type="hidden" id="avisoid_<?php echo $aviso["id_plan"];?>" value="<?php echo $aviso["id_plan"];?>">
            <?php $duracion = (empty($_SESSION['mfo_datos']['planes'])) ? $aviso["prom_duracion"] : $aviso["duracion"];?>
            <input type="hidden" id="avisodura_<?php echo $aviso["id_plan"];?>" value="<?php echo $duracion;?>">
            <?php //$costo = (empty($_SESSION['mfo_datos']['planes'])) ? $aviso["prom_costo"] : $aviso["costo"];?>
            <input type="hidden" id="avisocosto_<?php echo $aviso["id_plan"];?>" value="<?php echo number_format($aviso["costo"],2);?>">
            <?php
            $listadoAcciones = explode(",",$aviso['acciones']);
            $listadoPermisos = explode(",",$aviso['permisos']);
            $permisos_aviso = '';
            foreach($listadoPermisos as $key => $permiso){
              if ($listadoAcciones[$key] == "publicarOferta" || $listadoAcciones[$key] == "publicarOfertaConfidencial"){
                  $permiso = str_replace('NRO',$aviso["num_post"],$permiso);
                  $permiso = ($aviso["num_post"] > 1) ? str_replace("publicaci","publicaciones",$permiso) : str_replace("publicaci","publicaci&oacute;n",$permiso);                   
              }  
              if ($listadoAcciones[$key] == "adminEmpresas"){
                $permiso = str_replace('NRO',$aviso["num_cuenta"],$permiso);
              }
              if ($listadoAcciones[$key] == "accessos"){
                $permiso = str_replace('NRO',$aviso["num_accesos"],$permiso);
              }
              if ($listadoAcciones[$key] == "buscarCandidatosPostulados"){
                if (!empty($aviso["limite_perfiles"])){
                  $permiso = str_replace('NRO',$aviso["limite_perfiles"],$permiso);
                }
                else{
                  $permiso = str_replace('NRO','',$permiso); 
                }
              }
              if ($listadoAcciones[$key] == "descargarHv"){
                if (!empty($aviso["limite_perfiles"])){
                  $permiso = str_replace('NRO',"los ".$aviso["limite_perfiles"],$permiso);
                }
                else{
                  $permiso = str_replace('NRO','todos los ',$permiso);   
                }
              }  
              $permisos_aviso .= utf8_encode(trim($permiso)).'||';
            }       
            $text_publicacion = ($aviso["num_post"] > 1) ? $aviso["num_post"]."&nbsp;publicaciones" : $aviso["num_post"]."&nbsp;publicaci&oacute;n";                
            $opc_select .= '<option value="'.$aviso["id_plan"].'">'.$aviso["nombre"].'&nbsp;-&nbsp;'.$text_publicacion.'</option>';
            ?>
            <input type="hidden" id="avisopermiso_<?php echo $aviso["id_plan"];?>" value="<?php echo $permisos_aviso;?>">  
        <?php } ?>
        

        
        <div id="avisoul" class="top-10 theplan plan-tabla col-xs-12 col-md-4 flex-item shadow-box-planes">  
          <br>
          <div style="background-color: #bd5091; 
                      border-radius: 20px 20px 0 0;
                      color: white;
                      font-family: ‘Roboto’;
                      font-size: 24pt;
                      font-weight: 900;
                      text-shadow: 1px 1px rgba(0, 0, 0, 0.7);
                      height: auto;"  
               id="avisotitulo">
          </div>
            <div id="avisocosto" class="plan-precio-basico">
            <?php $msgcosto = (isset($aviso_promocional) && $aviso_promocional==1) ? "Antes " : "";?>             
            <?php echo $msgcosto.SUCURSAL_MONEDA.number_format($aviso["costo"],2);?>
            </div>
                      
          <?php //if (isset($aviso_promocional) && $aviso_promocional==1){ ?>  
            <!--<div class="plan-interno-info" style="margin: 4px auto;">
            <div class="descuento" style="background:url(<?php //echo PUERTO."://".HOST."/imagenes/planes-06.png"?>) no-repeat; background-size:100%;">
              <p class="promo-1">PRECIO</p>
              <p  class="promo-2">PROMOCIONAL</p>
            </div>
            <h2  style="margin-bottom: 0px; font-size: 36px; line-height: 38px; text-align:center;">
              <strong id="plan-precio" style="color: #ec3131;"><?php //echo (empty($aviso["prom_costo"])) ? "GRATIS" : SUCURSAL_MONEDA.number_format($aviso["prom_costo"],2); ?></strong>
            </h2>
            
            <div id="avisodura" class="plan-dias"></div>
            </div>-->            
          <?php //} else{ ?>
            <div style="background-color: #bd5091; color: white; text-shadow: 1px 1px rgba(0, 0, 0, 0.7);"><small>(El precio incluye IVA)</small></div>
            <div id="avisodura" class="plan-dias-basico"></div>
          <?php //} ?> 
          
          <?php if (count($avisos) > 1){ ?>
          <div class="select-plan">
            <select class="form-control" id="avisocmb">
              <?php echo $opc_select; ?>                           
            </select>
          </div>
          <?php } else { ?>
              <input type="hidden" id="avisocmb" value="<?php echo $aviso["id_plan"];?>">   
              <input type="hidden" id="avisonombre" value="<?php echo utf8_encode($aviso["nombre"]);?>">
          <?php } ?><br><br><br>  
          <div id="avisopermisos"></div>                  
          <br>
          <br>
          <br>
          <br> 
          <?php //$enlace = (isset($aviso_promocional) && $aviso_promocional==1) ? "buttonavisograt();" : "buttonaviso();"; ?>
          
          <!--plan basico-->
          <div>
          <a class="btn btn-plan-basico" onclick="buttonaviso();">
            <span class="icon-tag"></span>Comenzar
          </a>
          <img class="top-0" src="<?php echo PUERTO."://".HOST."/imagenes/plan-basico-base.png"?>">
          </div>

          <p><br></p>
        </div>
      <?php } ?>
      </div>
    </div>
  </div>
  <br><br><br>
</div>

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