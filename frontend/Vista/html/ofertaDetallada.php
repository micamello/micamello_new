<?php header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
      header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado

      require_once ('includes/Mobile-Detect/Mobile_Detect.php'); 
      $detect = new Mobile_Detect(); ?>

      <link rel="icon" type="image/x-icon" href="<?php echo PUERTO."://".HOST;?>/imagenes/favicon.ico">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/bootstrap.css">
  <!-- Archivo css micamello mic.css -->
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/mic.css">
  <!--Theme custom css -->  
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/media-queries.css">
  <link href="<?php echo PUERTO."://".HOST;?>/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="<?php echo PUERTO."://".HOST;?>/css/cookies.css" rel="stylesheet" type="text/css">  
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/bootstrap-multiselect.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/micamello.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/estilo.css">
  <link rel="stylesheet" href="<?php echo PUERTO."://".HOST;?>/css/sweetalert.css">

<br><br>
<div class="container">
  <div class="text-center">
    <h2 class="blue-text">Detalles de la Oferta</h2>
  </div>
</div>

<div >
<div >
    <div class="row" style="padding-right: 30px; padding-left: 30px;">
      <?php foreach ($arrayOferta as $key => $o) { ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <h3 class="titulo-detalle" style="margin-top: 10px; margin-bottom: 0px;">
            <?php echo utf8_encode($arrayOferta['titulo']); ?></h3>
        
        <?php
        $caracteres = 55; 
        $char_province = 13;

        if ($detect->isMobile()==true) {
              $caracteres = 15;
        }

        //print_r($arrayOferta);

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
        }?>

        <p class="detalles-subt">
          <span class="empresa-detalle"><?php
              if ($o['confidencial'] == 0) { 
                echo '<i class="fa fa-building tit-detalle-1 black-text"></i>&nbsp; '. utf8_encode($o['empresa']).' - ';
              }else {
                echo '<i class="fa fa-user-secret tit-detalle-1 black-text"></i>&nbsp; empresa confidencial - ';
              } ?>
              
          </span>
          <i class="fa fa-calendar tit-detalle-1 black-text"></i>&nbsp;
          <span class="tit-detalle-1 black-text">
            <?php $fecha = substr($o['fecha_contratacion'], 0, 10); echo date("d-m-Y", strtotime($fecha));?> 
          </span>
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
              <p id="postulacion-2"><?php echo $o['vacantes'].' vacantes'; ?></p>
          </div>

          <div class="col-md-2 cuadro-oferta-desc text-center">
             <i class="empleo-icono fa fa-clock-o"></i><br>
             <p id="postulacion-2"><?php echo $o['jornada']; ?></p>
          </div>

          <div class="col-md-2 cuadro-oferta-desc text-center">
            <i class="empleo-icono fa fa-map-marker"></i><br>
              <p id="postulacion-2">
                <?php if( strlen(utf8_encode($o['provincia'])) >= $char_province ){ 
                            echo substr(utf8_encode($o['provincia']), 0, $char_province).'...';
                    } else{ echo substr(utf8_encode($o['provincia']), 0, $char_province); } ?>
              </p>
          </div>

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
            
            <?php if(!Modelo_Usuario::estaLogueado()){?>
            <div class="col-md-12 form-seccion resumen shadow">
              <div align="center">
                  <div class="col-md-12">
                    <h5>
                      <a class="btn btn-login-reg" id="btn-verde" href="<?php echo PUERTO.'://'.HOST.'/registro/';?>">REGISTRATE PARA POSTULARTE</a>
                    </h5>
                  </div>
              </div>
            </div>
            <?php }
            else{?>
              <div class="col-md-12 form-seccion resumen shadow">
              <div align="center">
                  <div class="col-md-12">
                    <h5>
                      <a class="btn btn-login-reg" id="btn-verde" href="<?php echo PUERTO."://".HOST."/detalleOferta/oferta/".Utils::encriptar($o["id_ofertas"])."/"; ?>">Ir a Postulacion</a>
                    </h5>
                  </div>
              </div>
            </div>
            <?php }?> 

          

          <div class="col-md-12">
            <img class="auto-width" src="<?php echo PUERTO.'://'.HOST.'/imagenes/publicidad-micamello.png'; ?>">
          </div>   

        </div>
        <!--cierre del col-md-8-->

        <div class="col-md-4">
          <img class="auto-width text-center" src="<?php echo PUERTO.'://'.HOST.'/imagenes/publicidad-mi-camello-cuadrado.png';?>">
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
 <br>
