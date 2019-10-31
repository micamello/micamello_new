
    <div class="container-fluid">
        <img id="banner-principal" class="img-responsive" src="<?php echo PUERTO."://".HOST;?>/imagenes/banner-front.jpg" />
        <div id="buttonpc" class="centrado">
            <a class="big-button left" href="<?php echo PUERTO."://".HOST;?>/registro/">Soy Candidato</a>
          &nbsp;&nbsp;&nbsp;&nbsp;
            <a class="big-button right" href="<?php echo PUERTO."://".HOST;?>/registro/empresa/">Soy Empresa</a>
        </div>
        
        <img class="img-responsive" src="<?php echo PUERTO."://".HOST;?>/imagenes/seccion-completa.jpg"> 
      

      <br><br>
      <div class="container">
          <div class="col-md-12">
            <h1 class="blue-text big-text2">Últimas ofertas de camello</h1>
          </div>
      </div>
      

      <!--aqui llamar al modelo-->
      <?php
        $resultado = Modelo_Oferta::ultimasOfertasHome();
        if( isset($resultado) )
          //print_r($resultado);
          $cont = 1;
          $titulo;
          $salario;
          $ciudad;
          $provincia;
          $vacante;
          $tituloSup;
          $caracteres = 26; 

        foreach ( $resultado as $array ) {
          //echo $array['titulo'];
          $id_oferta[$cont] = $array['id_ofertas'];
          $titulo[$cont] = utf8_encode($array['titulo']);
          $salario[$cont] = $array['salario'];
          $ciudad[$cont] = utf8_encode($array['ciudad']);
          $provincia[$cont] = utf8_encode($array['provincia']);
          $vacante[$cont] = $array['vacantes'];
          $cont++;
        }
      ?>
      <div class="carousell">
        <!-- carousel -->
        <section id="brand" class="brand fix">
          <div class="container-fluid">
            <div class="carousel slide col-md-12" data-ride="carousel" data-type="multi" data-interval="3000" id="myCarousel3">
               <div class="carousel-inner">

                 <div class="item active">
                  <div class="brand_item col-md-2 col-md-6 top-30 ">
                    <a target="_blank" href="<?php echo PUERTO."://".HOST."/ofertaDetallada/".Utils::encriptar($id_oferta[1])."/"; ?>">
                    <div style="border-color: 2px solid #f9a60e;">
                      <div style="background-color: #f9a60e;" class="col-md-12">
                        <img id="ofertas" src="<?php echo PUERTO."://".HOST;?>/imagenes/foto-empleos.png" class="img-ofertas">
                      </div>
                      <div class="col-md-12 back-orange" style="height: 50px; font-size: 13pt;">
                        <p><?php 
                           if( strlen(utf8_encode($titulo[1])) > $caracteres ){
                              echo substr($titulo[1], 0, $caracteres).'...';
                           }
                           else 
                              echo $titulo[1]; ?></p>
                      </div>
                      <div class="col-md-12" style="border: 8px solid #f9a60e;">
                        <br>
                        <div style="text-align: left;">
                           <i class="fa fa-briefcase texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $titulo[1];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-dollar texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $salario[1];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-map-marker texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $provincia[1].' / '.$ciudad[1];?></span>  
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-user texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $vacante[1].' vacantes';?></span>  
                         </div>
                         <br> 
                      </div>

                    </div>
                    </a>
                  </div>
                </div>

                <div class="item">
                  <div class="brand_item col-md-2 col-md-6 top-30">
                    <a target="_blank" href="<?php echo PUERTO."://".HOST."/ofertaDetallada/".Utils::encriptar($id_oferta[2])."/"; ?>">
                    <div style="border-color: 2px solid #f9a60e;">
                      <div style="background-color: #f9a60e;" class="col-md-12">
                        <img id="ofertas" src="<?php echo PUERTO."://".HOST;?>/imagenes/foto-empleos.png" class="img-ofertas">
                      </div>
                      <div class="col-md-12 back-orange" style="height: 50px; font-size: 13pt;">
                        <p><?php 
                           if( strlen($titulo[2]) > $caracteres ){
                              echo substr($titulo[2], 0, $caracteres).'...';
                           }
                           else 
                              echo $titulo[2]; ?></p>
                      </div>
                      <div class="col-md-12" style="border: 8px solid #f9a60e;">
                        <br>
                        <div style="text-align: left;">
                           <i class="fa fa-briefcase texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $titulo[2];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-dollar texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $salario[2];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-map-marker texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $provincia[2].' / '.$ciudad[2];?></span>  
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-user texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $vacante[2].' vacantes';?></span>  
                         </div>
                         <br> 
                      </div>

                    </div>
                    </a>
                  </div>
                </div>

                <div class="item">
                  <div class="brand_item col-md-2 col-md-6 top-30">
                    <a target="_blank" href="<?php echo PUERTO."://".HOST."/ofertaDetallada/".Utils::encriptar($id_oferta[3])."/"; ?>">
                    <div style="border-color: 2px solid #f9a60e;">
                      <div style="background-color: #f9a60e;" class="col-md-12">
                        <img id="ofertas" src="<?php echo PUERTO."://".HOST;?>/imagenes/foto-empleos.png" class="img-ofertas">
                      </div>
                      <div class="col-md-12 back-orange" style="height: 50px; font-size: 13pt;">
                        <p><?php 
                           if( strlen($titulo[3]) > $caracteres ){
                              echo substr($titulo[3], 0, $caracteres).'...';
                           }
                           else 
                              echo $titulo[3]; ?></p>
                      </div>
                      <div class="col-md-12" style="border: 8px solid #f9a60e;">
                        <br>
                        <div style="text-align: left;">
                           <i class="fa fa-briefcase texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $titulo[3];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-dollar texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $salario[3];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-map-marker texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $provincia[3].' / '.$ciudad[3];?></span>  
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-user texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $vacante[3].' vacantes';?></span>  
                         </div>
                         <br> 
                      </div>

                    </div>
                    </a>
                  </div>
                </div>

                <div class="item">
                  <div class="brand_item col-md-2 col-md-6 top-30">
                    <a target="_blank" href="<?php echo PUERTO."://".HOST."/ofertaDetallada/".Utils::encriptar($id_oferta[4])."/"; ?>">
                    <div style="border-color: 2px solid #f9a60e;">
                      <div style="background-color: #f9a60e;" class="col-md-12">
                        <img id="ofertas" src="<?php echo PUERTO."://".HOST;?>/imagenes/foto-empleos.png" class="img-ofertas">
                      </div>
                      <div class="col-md-12 back-orange" style="height: 50px; font-size: 13pt;">
                        <p><?php 
                           if( strlen($titulo[4]) > $caracteres ){
                              echo substr($titulo[4], 0, $caracteres).'...';
                           }
                           else 
                              echo $titulo[4]; ?></p>
                      </div>
                      <div class="col-md-12" style="border: 8px solid #f9a60e;">
                        <br>
                        <div style="text-align: left;">
                           <i class="fa fa-briefcase texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $titulo[4];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-dollar texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $salario[4];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-map-marker texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $provincia[4].' / '.$ciudad[4];?></span>  
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-user texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $vacante[4].' vacantes';?></span>  
                         </div>
                         <br> 
                      </div>

                    </div>
                    </a>
                  </div>
                </div>

                <div class="item">
                  <div class="brand_item col-md-2 col-md-6 top-30">
                    <a target="_blank" href="<?php echo PUERTO."://".HOST."/ofertaDetallada/".Utils::encriptar($id_oferta[5])."/"; ?>">
                    <div style="border-color: 2px solid #f9a60e;">
                      <div style="background-color: #f9a60e;" class="col-md-12">
                        <img id="ofertas" src="<?php echo PUERTO."://".HOST;?>/imagenes/foto-empleos.png" class="img-ofertas">
                      </div>
                      <div class="col-md-12 back-orange" style="height: 50px; font-size: 13pt;">
                        <p><?php 
                           if( strlen($titulo[5]) > $caracteres ){
                              echo substr($titulo[5], 0, $caracteres).'...';
                           }
                           else 
                              echo $titulo[5]; ?></p>
                      </div>
                      <div class="col-md-12" style="border: 8px solid #f9a60e;">
                        <br>
                        <div style="text-align: left;">
                           <i class="fa fa-briefcase texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $titulo[5];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-dollar texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $salario[5];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-map-marker texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $provincia[5].' / '.$ciudad[5];?></span>  
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-user texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $vacante[5].' vacantes';?></span>  
                         </div>
                         <br> 
                      </div>

                    </div>
                    </a>
                  </div>
                </div>

                <div class="item">
                  <div class="brand_item col-md-2 col-md-6 top-30">
                    <a target="_blank" href="<?php echo PUERTO."://".HOST."/ofertaDetallada/".Utils::encriptar($id_oferta[6])."/"; ?>">
                    <div style="border-color: 2px solid #f9a60e;">
                      <div style="background-color: #f9a60e;" class="col-md-12">
                        <img id="ofertas" src="<?php echo PUERTO."://".HOST;?>/imagenes/foto-empleos.png" class="img-ofertas">
                      </div>
                      <div class="col-md-12 back-orange" style="height: 50px; font-size: 13pt;">
                        <p><?php 
                           if( strlen($titulo[6]) > $caracteres ){
                              echo substr($titulo[6], 0, $caracteres).'...';
                           }
                           else 
                              echo $titulo[6]; ?></p>
                      </div>
                      <div class="col-md-12" style="border: 8px solid #f9a60e;">
                        <br>
                        <div style="text-align: left;">
                           <i class="fa fa-briefcase texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $titulo[6];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-dollar texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $salario[6];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-map-marker texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $provincia[6].' / '.$ciudad[6];?></span>  
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-user texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $vacante[6].' vacantes';?></span>  
                         </div>
                         <br> 
                      </div>

                    </div>
                    </a>
                  </div>
                </div>

                <div class="item">
                  <div class="brand_item col-md-2 col-md-6 top-30">
                    <a target="_blank" href="<?php echo PUERTO."://".HOST."/ofertaDetallada/".Utils::encriptar($id_oferta[7])."/"; ?>">
                    <div style="border-color: 2px solid #f9a60e;">
                      <div style="background-color: #f9a60e;" class="col-md-12">
                        <img id="ofertas" src="<?php echo PUERTO."://".HOST;?>/imagenes/foto-empleos.png" class="img-ofertas">
                      </div>
                      <div class="col-md-12 back-orange" style="height: 50px; font-size: 13pt;">
                        <p><?php 
                           if( strlen($titulo[7]) > $caracteres ){
                              echo substr($titulo[7], 0, $caracteres).'...';
                           }
                           else 
                              echo $titulo[7]; ?></p>
                      </div>
                      <div class="col-md-12" style="border: 8px solid #f9a60e;">
                        <br>
                        <div style="text-align: left;">
                           <i class="fa fa-briefcase texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $titulo[7];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-dollar texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $salario[7];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-map-marker texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $provincia[7].' / '.$ciudad[7];?></span>  
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-user texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $vacante[7].' vacantes';?></span>  
                         </div>
                         <br> 
                      </div>

                    </div>
                    </a>
                  </div>
                </div>

                <div class="item">
                  <div class="brand_item col-md-2 col-md-6 top-30">
                    <a target="_blank" href="<?php echo PUERTO."://".HOST."/ofertaDetallada/".Utils::encriptar($id_oferta[9])."/"; ?>">
                    <div style="border-color: 2px solid #f9a60e;">
                      <div style="background-color: #f9a60e;" class="col-md-12">
                        <img id="ofertas" src="<?php echo PUERTO."://".HOST;?>/imagenes/foto-empleos.png" class="img-ofertas">
                      </div>
                      <div class="col-md-12 back-orange" style="height: 50px; font-size: 13pt;">
                        <p><?php 
                           if( strlen($titulo[8]) > $caracteres ){
                              echo substr($titulo[8], 0, $caracteres).'...';
                           }
                           else 
                              echo $titulo[8]; ?></p>
                      </div>
                      <div class="col-md-12" style="border: 8px solid #f9a60e;">
                        <br>
                        <div style="text-align: left;">
                           <i class="fa fa-briefcase texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $titulo[8];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-dollar texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $salario[8];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-map-marker texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $provincia[8].' / '.$ciudad[8];?></span>  
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-user texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $vacante[8].' vacantes';?></span>  
                         </div>
                         <br> 
                      </div>

                    </div>
                    </a>
                  </div>
                </div>

                <div class="item">
                  <div class="brand_item col-md-2 col-md-6 top-30">
                    <a target="_blank" href="<?php echo PUERTO."://".HOST."/ofertaDetallada/".Utils::encriptar($id_oferta[9])."/"; ?>">
                    <div style="border-color: 2px solid #f9a60e;">
                      <div style="background-color: #f9a60e;" class="col-md-12">
                        <img id="ofertas" src="<?php echo PUERTO."://".HOST;?>/imagenes/foto-empleos.png" class="img-ofertas">
                      </div>
                      <div class="col-md-12 back-orange" style="height: 50px; font-size: 13pt;">
                        <p><?php 
                           if( strlen($titulo[9]) > $caracteres ){
                              echo substr($titulo[9], 0, $caracteres).'...';
                           }
                           else 
                              echo $titulo[9]; ?></p>
                      </div>
                      <div class="col-md-12" style="border: 8px solid #f9a60e;">
                        <br>
                        <div style="text-align: left;">
                           <i class="fa fa-briefcase texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $titulo[9];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-dollar texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $salario[9];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-map-marker texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $provincia[9].' / '.$ciudad[9];?></span>  
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-user texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $vacante[9].' vacantes';?></span>  
                         </div>
                         <br> 
                      </div>

                    </div>
                    </a>
                  </div>
                </div>

                <div class="item">
                  <div class="brand_item col-md-2 col-md-6 top-30">
                    <a target="_blank" href="<?php echo PUERTO."://".HOST."/ofertaDetallada/".Utils::encriptar($id_oferta[10])."/"; ?>">
                    <div style="border-color: 2px solid #f9a60e;">
                      <div style="background-color: #f9a60e;" class="col-md-12">
                        <img id="ofertas" src="<?php echo PUERTO."://".HOST;?>/imagenes/foto-empleos.png" class="img-ofertas">
                      </div>
                      <div class="col-md-12 back-orange" style="height: 50px; font-size: 13pt;">
                        <p><?php 
                           if( strlen($titulo[10]) > $caracteres ){
                              echo substr($titulo[10], 0, $caracteres).'...';
                           }
                           else 
                              echo $titulo[10]; ?></p>
                      </div>
                      <div class="col-md-12" style="border: 8px solid #f9a60e;">
                        <br>
                        <div style="text-align: left;">
                           <i class="fa fa-briefcase texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $titulo[10];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-dollar texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $salario[10];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-map-marker texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $provincia[10].' / '.$ciudad[10];?></span>  
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-user texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $vacante[10].' vacantes';?></span>  
                         </div>
                         <br> 
                      </div>

                    </div>
                    </a>
                  </div>
                </div>

                <div class="item">
                  <div class="brand_item col-md-2 col-md-6 top-30">
                    <a target="_blank" href="<?php echo PUERTO."://".HOST."/ofertaDetallada/".Utils::encriptar($id_oferta[11])."/"; ?>">
                    <div style="border-color: 2px solid #f9a60e;">
                      <div style="background-color: #f9a60e;" class="col-md-12">
                        <img id="ofertas" src="<?php echo PUERTO."://".HOST;?>/imagenes/foto-empleos.png" class="img-ofertas">
                      </div>
                      <div class="col-md-12 back-orange" style="height: 50px; font-size: 13pt;">
                        <p><?php 
                           if( strlen($titulo[11]) > $caracteres ){
                              echo substr($titulo[11], 0, $caracteres).'...';
                           }
                           else 
                              echo $titulo[11]; ?></p>
                      </div>
                      <div class="col-md-12" style="border: 8px solid #f9a60e;">
                        <br>
                        <div style="text-align: left;">
                           <i class="fa fa-briefcase texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $titulo[11];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-dollar texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $salario[11];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-map-marker texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $provincia[11].' / '.$ciudad[11];?></span>  
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-user texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $vacante[11].' vacantes';?></span>  
                         </div>
                         <br> 
                      </div>

                    </div>
                    </a>
                  </div>
                </div>

                <div class="item">
                  <div class="brand_item col-md-2 col-md-6 top-30">
                    <a target="_blank" href="<?php echo PUERTO."://".HOST."/ofertaDetallada/".Utils::encriptar($id_oferta[12])."/"; ?>">
                    <div style="border-color: 2px solid #f9a60e;">
                      <div style="background-color: #f9a60e;" class="col-md-12">
                        <img id="ofertas" src="<?php echo PUERTO."://".HOST;?>/imagenes/foto-empleos.png" class="img-ofertas">
                      </div>
                      <div class="col-md-12 back-orange" style="height: 50px; font-size: 13pt;">
                        <p><?php 
                           if( strlen($titulo[12]) > $caracteres ){
                              echo substr($titulo[12], 0, $caracteres).'...';
                           }
                           else 
                              echo $titulo[12]; ?></p>
                      </div>
                      <div class="col-md-12" style="border: 8px solid #f9a60e;">
                        <br>
                        <div style="text-align: left;">
                           <i class="fa fa-briefcase texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $titulo[12];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-dollar texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $salario[12];?></span>
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-map-marker texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $provincia[12].' / '.$ciudad[12];?></span>  
                         </div>
                         <div style="text-align: left;">
                           <i class="fa fa-user texto-ofertas-home"></i>
                           <span class="texto-ofertas-home"><?php echo $vacante[12].' vacantes';?></span>  
                         </div>
                         <br> 
                      </div>

                    </div>
                    </a>
                  </div>
                </div>

              </div>
            </div>                
          </div>
        </section>
      <!-- carousel -->﻿
      </div> 
      
      <img id="caneapc" class="img-responsive top-50" src="<?php echo PUERTO."://".HOST;?>/imagenes/seccion-completa-canea.png">

      <img id="caneamovil" class="img-responsive top-50" src="<?php echo PUERTO."://".HOST;?>/imagenes/test-canea.png">


      <br><br> 
      <hr class="line-orange">
      <br><br> 
      <div class="container">
        <div class="col-md-5">
         <img id="foto2" class="img-responsive margin-10" src="<?php echo PUERTO."://".HOST;?>/imagenes/foto2.png">
        </div>
        <div class="col-md-7"><br><br><br>
              <h1 class="blue-text">¿CÓMO HACER UN CURRICULUM SIN EXPERIENCIA?</h1>
              <div id="card" class="card w-100 blue-card text-right">
                <div class="card-body">
                  <p class="card-text new-text">Vas a presentarte como candidato a un puesto relacionado con tus estudios y en el que no tienes nada de experiencia, por lo tanto, hay que destacar la formación. Sin embargo, hay que tener claros algunos puntos en este apartado.</p>
                  <a href="#" class="btn-link">Ver más...</a>&nbsp;&nbsp;&nbsp;&nbsp;
                </div>
              </div>
        </div>    
      </div>
      
      <br><br>
      
      <div class="container">
        <div class="col-md-2"></div>
          <div class="col-md-8 boton">
            <a class="big-beauty-button top-bootom" href="https://www.blog.micamello.com.ec" target="_blank">
              Visita nuestro blog
            </a>
          </div>
        <div class="col-md-2"></div>
      </div> 
      <br><br> 
      <hr class="line-orange">


      <img class="top-50 img-label" src="<?php echo PUERTO."://".HOST;?>/imagenes/titulo-tu-empresa.png">
      
      <br><br><br>
      <div class="container">
        <div class="col-md-4">
          <img class="img-promo" src="<?php echo PUERTO."://".HOST;?>/imagenes/tiempo.png">
        </div>
        <div class="col-md-4">
          <img class="img-promo" src="<?php echo PUERTO."://".HOST;?>/imagenes/ahorro.png">
        </div>
        <div class="col-md-4">
          <img class="img-promo" src="<?php echo PUERTO."://".HOST;?>/imagenes/proceso-seleccion.png">
        </div>      
      </div>

     
      <div class="col-md-12 top-bootom"><br></div>

      <div class="container">
        <div class="col-md-2"></div>
          <div class="col-md-8 boton">
            <a href="registro/" class="big-beauty-button-small top-bootom">
              CONOCE MÁS
            </a>
          </div>
        <div class="col-md-2"></div>
      </div>

      <br>
      <hr class="line-blue"> 

      <img id="seccomppc" class="img-responsive top-50" src="<?php echo PUERTO."://".HOST;?>/imagenes/seccion-completa-map.jpg">
      

      <img id="seccompmovil" class="img-responsive top-50" src="<?php echo PUERTO."://".HOST;?>/imagenes/mapa.png">


      <img id="ttipc" class="img-responsive" src="<?php echo PUERTO."://".HOST;?>/imagenes/seccion-completa-tti.jpg">

      <img id="ttimovil" class="img-responsive" src="<?php echo PUERTO."://".HOST;?>/imagenes/tti.png">

      <hr class="line-orange">

      <div id="news-container" class="container">
        <div>
          <img id="img-noticias" class="title-responsive" src="<?php echo PUERTO."://".HOST;?>/imagenes/noticias-empleo.png">
        </div>

        <div id="foto1" class="col-md-5">
           <img class="img-responsive margin-10" src="<?php echo PUERTO."://".HOST;?>/imagenes/foto1.png">
        </div>

        <div class="col-md-7">
            <h1 class="blue-text">Mi camello presentó a las empresas las bondades y beneficios de su herramienta.</h1>
            <div id="card" class="card w-100 blue-card text-right">
              <div class="card-body">
                <p class=" new-text">El Gerente General de la organización, Widman Hidrovo, agradeció la presencia de empresas participantes y su apoyo a este nuevo emprendimiento ecuatoriano que nace con aspiraciones de conquistar el mercado nacional e internacional.</p>
                <a href="#" class="btn-link">Ver más...</a>&nbsp;&nbsp;&nbsp;&nbsp;
              </div>
            </div>
        </div>
      </div>
      
      <br>
      <hr class="line-blue"> 

        <div class="col-md-6 top-20">
          <h2 class="email-text">Politicas de privacidad</h2>
          
          <div class="col-md-6">
            <p class="blue-texto" style="text-align: left;">
              <a href="<?php echo PUERTO."://".HOST."/terminoscondiciones/";?>" target="_blank">
                Condiciones legales de uso
              </a>
            </p>
          </div>

          <div class="col-md-6">
            <p class="blue-texto" style="text-align: left;">
              <a href="<?php echo PUERTO."://".HOST."/politicacookie/";?>" target="_blank">
                Políticas de Cookies
              </a>
            </p>
          </div>

          <div class="col-md-6">
            <p class="blue-texto" style="text-align: left;">
              <a href="<?php echo PUERTO."://".HOST."/politicaprivacidad/";?>" target="_blank">
                Politicas de privacidad
              </a>
            </p>
          </div>          

          <div class="col-md-6">
            <p class="blue-texto" style="text-align: left;">
              <a target="_blank" href="<?php echo PUERTO."://".HOST;?>/recomendacion/">  
                Recomendaciones
              </a>
            </p>
          </div>

          <div class="col-md-6">
            <p class="blue-texto" style="text-align: left;">
              <a target="_blank" href="<?php echo PUERTO."://".HOST;?>/preguntasfrecuentes/">  
                Preguntas frecuentes
              </a>
            </p>
          </div>

          <div class="col-md-6">
            &nbsp;
          </div>



        </div>
        <div class="col-md-6 top-20">
          <h2 class="email-text">Contacto</h2>
          <p class="email-text">
            <i class="fa fa-envelope-o" id="social-pie" aria-hidden="true"></i>
            <a class="email-text" target="_blank" href="<?php echo PUERTO."://".HOST;?>/recomendacion/">
              info@micamello.com.ec
            </a>
          </p>
        </div>

    </div>

<br>
