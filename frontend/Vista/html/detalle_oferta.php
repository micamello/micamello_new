<?php require_once ('includes/Mobile-Detect/Mobile_Detect.php'); 
      $detect = new Mobile_Detect(); ?>
<div class="container">
  <div class="text-center">
    <h2 class="blue-text">Detalles de la <?php if(!empty($vista) && $vista != 'postulacion'){ echo 'Oferta'; }else{ echo 'Postulaci&oacute;n'; } ?></h2>
  </div>
</div>


<div class="main_business">
  <div class="container">
    <div class="row">
      <?php foreach ($oferta as $key => $o) { ?>
      <!--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">-->
        <!-- <h3 class="titulo-detalle" style="margin-top: 10px; margin-bottom: 0px;"><?php echo utf8_encode($o['titulo']); ?></h3> -->
        
        <?php
        $caracteres = 35; 
        $char_province = 13;

        if ($detect->isMobile()==true) {
              $caracteres = 15;
        }

        $aspirantesXoferta = Modelo_Oferta::aspirantesXofertas();

        if($o['tipo_oferta'] == 1){ 
              $clase = 'titulo-postulaciones';
              $sueldo = 'sueldo-post'; 
              $t = 'Aviso Urgente';
            }
        else if($o['tipo_oferta'] == 0){
              $clase = 'titulo-postulaciones-normal';
              $sueldo = 'sueldo-post-normal';
              $t = 'Aviso Normal';
            }
        if( $o['estado'] == Modelo_Oferta::PORAPROBAR && $vista != 'postulacion' ){
             $clase = 'titulo-postulaciones-pendiente';
             $sueldo = 'sueldo-post-pendiente';
             $t = 'Aviso Pendiente de Aprobaci&oacute;n';
        }
        ?>
        <p class="detalles-subt">
          <span class="empresa-detalle"><?php
            if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA){
              if ($o['confidencial'] == 0) { 
                echo '<i class="fa fa-building tit-detalle-1 black-text"></i>&nbsp; '. utf8_encode($o['empresa']).' - ';
              }else {
                echo '<i class="fa fa-user-secret tit-detalle-1 black-text"></i>&nbsp; empresa confidencial - ';
              }
            } ?></span>
          <i class="fa fa-calendar tit-detalle-1 black-text"></i>&nbsp;<span class="tit-detalle-1 black-text"> Fecha de contrato: <?php $fecha = substr($o['fecha_contratacion'], 0, 10); echo date("d-m-Y", strtotime($fecha));?> </span>
        </p>

         
        <div class="col-md-8" >
          <div class="col-md-10 shadow <?php echo $clase;?>">
            <?php if( strlen(utf8_encode($o['titulo'])) > $caracteres ){?>
            <p class="titulo-post"><i class="fa fa-briefcase "></i>
            <?php echo '&nbsp; '  .substr(utf8_encode($o['titulo']), 0, $caracteres).'...</p>';
          }
          else{?>
            <p class="titulo-post"><i class="fa fa-briefcase "></i>
            <?php echo '&nbsp; '  .substr(utf8_encode($o['titulo']), 0, $caracteres).'</p>';
          }?>
          </div>

          <div class="col-md-2 shadow <?php echo $sueldo;?>">
            <p class="paga-post">
              <?php echo SUCURSAL_MONEDA.number_format($o['salario'],2);?>
            </p>
          </div>

          <div class="col-md-4">&nbsp;</div>

          <div class="col-md-2 cuadro-oferta-desc text-center">
             <i class="empleo-icono fa fa-user-circle"></i><br>
              <p id="postulacion-2"><?php echo $o['vacantes'].' vacante'; ?></p>
          </div>

          <div class="col-md-2 cuadro-oferta-desc text-center">
             <i class="empleo-icono fa fa-clock-o"></i><br>
             <p id="postulacion-2"><?php echo $o['jornada']; ?></p>
          </div>

          <div class="col-md-2 cuadro-oferta-desc text-center">
            <i class="empleo-icono fa fa-map-marker"></i><br>
              <p id="postulacion-2"><?php if( strlen(utf8_encode($o['provincia'])) >= $char_province ){ echo substr(utf8_encode($o['provincia']), 0, $char_province).'...';
                    } else{ echo substr(utf8_encode($o['provincia']), 0, $char_province); } ?></p>
          </div>
          
          <?php if($vista == 'postulacion'){?>
          <div class="col-md-2 cuadro-oferta-desc text-center" style="width: auto;">
             <i class="empleo-icono fa fa-hand-pointer-o"></i><br>
              <p id="postulacion-2"><?php echo POSTULACIONES[$o['tipo']]; ?></p>
          </div>
         <?php }
         else if( $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA ){?>
            <div class="col-md-2 cuadro-oferta-desc text-center" style="width: auto;">
            <?php $cantd = 0;
                if(isset($aspirantesXoferta[$o['id_ofertas']])){ 
                  $cantd = $aspirantesXoferta[$o['id_ofertas']]; ?>
                  <a href="<?php echo PUERTO.'://'.HOST.'/verAspirantes/1/'.Utils::encriptar($o['id_ofertas']).'/1/'; ?>">
                <?php } ?>
                <i class="empleo-icono-post fa fa-user"></i><br>
                <?php 
                if($cantd == 0){
                  echo '<p class="text-icono-post">'.$cantd.' Postulados</p>';
                }else{
                  echo '<p class="text-icono-post">'.$cantd.' Postulados</p></a>';
                }?>
            </div>
         <?php }
         else{?>
            &nbsp;
         <?php }?>
          <br class="isMovil"><br class="isMovil"><br class="isMovil">
          <br class="isTablet"><br class="isTablet">
          <br>
          <div class="col-md-12 resumen shadow black-text" id="altura-detalle">
            <h5 class="tit-detalle-1 black-text" style="text-align: left; margin-top: 0px;"><b>Titulo:</b>
              <?php echo utf8_encode($o['titulo']); ?>
            </h5>
            <h5 class="tit-detalle-1 black-text" style="text-align: left; margin-top: 0px;"><b>Descripci&oacute;n:</b></h5>
            <p class="black-text"><?php echo html_entity_decode($o['descripcion']); ?></p>
          </div>

          <div class="col-md-12 resumen shadow">
            <h5 class="tit-detalle-1" style="text-align: left; margin-top: 0px;"><b>Requerimientos:</b></h5>
              <h5>
                <p class="black-text">Años de Experiencia: 
                  <?php echo ANOSEXP[$o['anosexp']]; ?></p>                   
              </h5>
              <h5>
                <p class="black-text">Nivel de Estudios: 
                <?php echo utf8_encode($o['escolaridad']); ?></p>             
              </h5>
              <h5>
                <p class="black-text">Nivel de Idiomas:
                <?php 
                  $idiomas = Modelo_NivelxIdioma::relacionIdiomaNivel($o['idiomas']);
                  if(!empty($idiomas)){ 
                   foreach ($idiomas as $key => $value) {
                      echo utf8_encode($value['descripcion'].' - '.$value['nombre']).'<br>';
                   }
                  }else{
                    echo 'No exige idiomas en especifico';
                  }?>
                </p>                        
              </h5>
              <h5> 
                <p class="black-text">Área (subáreas):
                <?php echo utf8_encode($o['area']);  
                  $areas_subareas = Modelo_AreaSubarea::obtieneAreasSubareas($o['subareas']);
                  $areas = '';
                  foreach ($areas_subareas as $key => $datos) {
                    $areas .= utf8_encode($datos['nombre_area'].' ('.$datos['nombre_subarea']).')<br>';
                  } 
                  echo $areas;
                ?>
                </p>     
              </h5>
              <h5>
                <p class="black-text">Disponibilidad de Viajar:
                <?php if ($o['viajar'] == 0) { echo 'NO'; }else{ echo 'SI'; } ?>
                </p>                      
              </h5>
              <h5>
                <p class="black-text">Disponibilidad de Cambio de Residencia: 
                <?php if ($o['residencia'] == 0) { echo 'NO'; }else{ echo 'SI'; } ?>
                </p>                       
              </h5>
              <h5>
                <p class="black-text">Tipo de licencia para conducir:
                <?php if($o['licencia'] == 0){
                  echo 'Sin licencia';
                }else{ 
                  echo $licencias[$o['licencia']]; 
                } ?>
                </p>                        
              </h5>
          </div>

            <?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO && $o['estado'] == Modelo_Oferta::ACTIVA){ ?>
            <div class="col-md-12 form-seccion resumen shadow">
            <form role="form" name="form_postulacion" id="form_postulacion" method="post" action="<?php echo PUERTO."://".HOST;?>/detalleOferta/<?php echo $vista.'/'.Utils::encriptar($o['id_ofertas']); ?>/">
            <input type="hidden" name="postulado" id="postulado" value="1">
            <input type="hidden" name="opcion" id="opcion" value="">
              <?php if(!empty($vista) && $vista != 'postulacion'){ ?>
                <input type="hidden" name="tipo" id="tipo" value="1">

                <?php if(!empty($postulado)){ ?>
                  <div align="center">
                    <div class="cambiar">
                      <h5 class="centro">
                        <br>
                       <button type="button" class="btn-red" style="cursor:pointer">Ya aplic&oacute; para la oferta</button>
                      </h5>
                    </div>
                  </div>
                <?php }else{ ?>
                  <div align="center">
                    <div class="cambiar">
                      <div class="col-md-12">
                        <div id="seccion_asp" class="form-group">
                          <h5 class="tit-detalle-1" style="text-align: center; margin-top: 0px;"><b>Aspiraci&oacute;n salarial</b></h5><div id="err_asp" class="help-block with-errors"></div>
                            <input class="form-control" type="text" min="1" onkeydown="return validaNumeros(event)" onkeyup="caracteresEspecial()" onblur="caracteresEspecial()" name="aspiracion" id="aspiracion" pattern='[0-9]+' maxlength="5" placeholder="Ej: <?php echo number_format(450,0); ?>" required value="<?php if(!empty($aspiracion)){ echo $aspiracion; } ?>"/>
                        </div>
                        <h5>
                          <button type="button" class="btn btn-login-reg" id="btn-verde" onclick="validarAspiracion();">POSTULARSE</button>
                        </h5>
                      </div>
                    </div>
                  </div>
                <?php } ?>
                </form>
              <?php }else{ ?>
                <input type="hidden" name="tipo" id="tipo" value="2">

                <div align="center">
                  <div align="cambiar">
                    <label for="status"><p class="tit-detalle-1"><b>Estatus del candidato en la oferta</b></p></label>
                    <select class="form-control" name="status" id="status">
                      <option value="0" disabled>Seleccione un estatus</option>

                      <?php 
                        foreach(ESTATUS_OFERTA as $key => $v){ 

                            echo "<option value='".$key."'";
                            if($key == strtoupper($postulado['0']['resultado'])){
                              echo " selected='selected'";
                            }
                            echo ">".utf8_encode($v)."</option>";
                        } 
                      ?>
                    </select>
                    <br>
                    <h5>
                      <button type="submit" class="btn btn-login-reg" id="btn-verde">GUARDAR</button>
                    </h5>
                  </div>
                </div>
                </form>
              <?php } ?>
            </form>
           </div> 
          <?php } ?>
          

          <div class="col-md-12">
            <img class="auto-width" src="<?php echo PUERTO.'://'.HOST.'/imagenes/publicidad-micamello.png'; ?>">
          </div>   

        </div>
        <!--cierre del col-md-8-->

        <div class="col-md-4">
          <img src="<?php echo PUERTO.'://'.HOST.'/imagenes/publicidad-mi-camello-cuadrado.png';?>">
        </div>
        
        <div class="col-md-4 resumen-blue">

          <h5 class="resumen-text">
            <b><i class="fa fa-map-marker big-icon" aria-hidden="true"></i></b>&nbsp;&nbsp;<?php echo utf8_encode($o['provincia'].'/'.$o['ciudad']); ?>
          </h5>

          <h5 class="resumen-text">
            <b><i class="fa fa-clock-o big-icon" aria-hidden="true"></i></b>&nbsp;&nbsp;<?php echo utf8_encode($o['jornada']); ?>
          </h5>

          <h5 class="resumen-text">
            <b><i class="fa fa-usd big-icon" aria-hidden="true"></i></b>&nbsp;&nbsp;<?php if(!empty($o['a_convenir'])){ echo '(a convenir)'; } ?></b> 
            <?php echo SUCURSAL_MONEDA.number_format($o['salario'],2);?>
          </h5>

          <h5 class="resumen-text">
            <b><i class="fa fa-wheelchair big-icon" aria-hidden="true"></i></b>&nbsp;&nbsp;<?php echo REQUISITO[$o['discapacidad']]; ?>
          </h5>

          <h5 class="resumen-text">
            <b><i class="fa fa-user-circle big-icon" aria-hidden="true"></i></b>&nbsp;&nbsp;Vacantes: <?php echo $o['vacantes']; ?>
          </h5>

          <h5 class="resumen-text">
            <b><i class="fa fa-calendar big-icon" aria-hidden="true"></i></b>&nbsp;&nbsp;Edad: <?php echo $o['edad_minima'].' a '.$o['edad_maxima']; ?> a&ntilde;os
          </h5>

          <h5 class="resumen-text">
            <b><i class="fa fa-suitcase big-icon" aria-hidden="true"></i></b>&nbsp;&nbsp;Primer Empleo: <?php if($o['primer_empleo']){ echo 'S&iacute;'; }else{ echo 'No'; } ?>
          </h5>
          
        </div>

        
      <?php } ?>
    </div>
  </div>
</div>

<?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){ ?>
<!-- <div class=" banner-publicidad" align="center">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="banner-light col-md-9 click ">est&aacute; a un solo click de encontrar el <b>candidato ideal</b></div>
        <button class="btn-blue-2 pulse animated infinite col-md-2"><a href="<?php echo PUERTO."://".HOST;?>/publicar/">Publicar Oferta</a></button>
      </div>
    </div>
  </div>
</div> -->
<?php } ?>