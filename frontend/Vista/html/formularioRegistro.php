<div class="container-fluid top-0">
    <?php if( isset($empresa) ){?>
      <div id="backColor" class="text-center back-blue">
    <?php }
          else{?>
      <div id="backColor" class="text-center back-yellow">
    <?php }?>
    <br>
    <div class="container">
       <div class="white tabla-reg">
        <div class="text-right">
            <?php 
                if(isset($empresa)){
                    echo "<input type='hidden' id='empresaForm'>";
                }
            ?>
             <div class="btn-group controlTipo top-bottom-10">
              <button type="button" id="btnCand" class="btn btn-lg btn-primary" onclick="changeBack(1)">Candidato</button>
              <button type="button" id="btnEmp" class="btn btn-lg btn-default" onclick="changeBack(2)">Empresa</button>
            </div>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">
                <?php if( isset($empresa) ){?>
                  <h2 id="tituloReg" class="registro-titulo text-orange"></h2>
                <?php }
                      else{?>
                  <h2 id="tituloReg" class="registro-titulo blue-text"></h2>
                <?php }?>
                <div>
                  <form action="<?php echo PUERTO.'://'.HOST.'/registroUsuario/' ?>" method="POST" id="registroFormulario" autocomplete="off">

                        <input type="hidden" name="tipo_usuario" id="tipo_usuario">
                        <input type="hidden" name="tipo_documentacion" id="tipo_documentacion">
                        <input type="hidden" name="formularioRegistro" id="formularioRegistro" value="1">

                        <div class="col-md-6 form-group">
                            <label class="campo">Nombre <span class="no"> *</span></label>
                            <div class="errorContainer"></div>
                            <input type="text" name="nombresCandEmp" class="espacio form-control" id="nombresCandEmp" placeholder="Nombres *">
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="campo">Apellido <span class="no"> *</span></label>
                            <div class="errorContainer"></div>
                            <input type="text" class="espacio  form-control" placeholder="Apellidos *" name="apellidosCand" id="apellidosCand"/>
                        </div>
                        
                        <div class="col-md-6 form-group">
                            <label class="campo">Sector industrial <span class="no"> *</span></label>
                            <div class="errorContainer"></div>
                            
                            <select id="sectorind" name="sectorind" class="espacio form-control">
                                <option value="" selected="selected" disabled="disabled">Sector industrial *</option>
                                <?php 
                                  if(!empty($arrsectorind)){
                                    foreach($arrsectorind as $sectorind){
                                      echo "<option value='".$sectorind['id_sectorindustrial']."'>".utf8_encode($sectorind['descripcion'])."</option>";
                                    }
                                  }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="campo">Correo <span class="no"> *</span></label>
                            <div class="errorContainer"></div>
                            
                            <input type="text" class="espacio form-control" placeholder="Correo *" id="correoCandEmp" name="correoCandEmp" />
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="campo">Celular <span class="no"> *</span></label>
                            <div class="errorContainer"></div>
                            
                            <input type="text" class="espacio form-control" placeholder="Celular *" id="celularCandEmp" name="celularCandEmp"/>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="campo">Tipo documentación <span class="no">*</span></label>
                            <div class="errorContainer"></div>
                            
                            <select class=" espacio form-control" id="tipoDoc" name="tipoDoc">
                                <option value="">Tipo documentación *</option>
                                    <?php 
                                        foreach (TIPO_DOCUMENTO as $key => $value) {
                                            if($key != 1){
                                            echo "<option value='".$key."'>".utf8_encode($value)."</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="campo">Documento <span class="no"> *</span></label>
                            <div class="errorContainer"></div>
                            
                            <input type="text" class="espacio form-control" placeholder="Documento *" id="documentoCandEmp" name="documentoCandEmp"/>
                        </div>
                        <div class="col-md-6 form-group">
                            <label class="campo">Género <span class="no">*</span></label>
                            <div class="errorContainer"></div>
                            
                            <select class="espacio form-control" name="generoUsuario" id="generoUsuario">
                                <option value="" selected="selected" disabled="disabled">Género *   </option>
                                <?php 
                                  if(!empty($arrgenero)){
                                    foreach ($arrgenero as $gen) {
                                      echo "<option value='".$gen['id_genero']."'>".$gen['descripcion']."</option>";
                                    }
                                  }
                                ?>
                              </select>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="campo">Fecha nacimiento <span class="no">*</span></label>
                            <div class="errorContainer"></div>
                            
                            <input placeholder="Fecha de Nacimiento *" type="text" data-field="date" class="espacio form-control noautofill <?php echo $noautofill; ?>" name="fechaNac" id="fechaNac">
                            <div id="fechaShow"></div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="campo">Contraseña <span class="no">*</span></label>
                            <div class="errorContainer"></div>
                            
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-eye"></i></div>
                                <input type="password" class="espacio form-control noautofill <?php echo $noautofill; ?>" placeholder="Contraseña *" value="" id="password_1" name="password_1" <?php echo $readonly; ?>/>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="campo">Repita contraseña<span class="no">*</span></label>
                            <div class="errorContainer"></div>
                            
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-eye"></i></div>
                                <input type="password" class="espacio form-control noautofill <?php echo $noautofill; ?>"  placeholder="Repita Contraseña *" id="password_2" name="password_2" <?php echo $readonly; ?>/>
                            </div>
                        </div>

                        <div id="datosContactoLabel" style="text-align: center;" class="col-md-12 form-group">
                            <h3 class="blue-text">Datos de contacto</h3>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="campo">Nombres <span class="no">*</span></label>
                            <div class="errorContainer"></div>
                            <input type="text" class="espacio form-control" placeholder="Nombres *" id="nombreConEmp" name="nombreConEmp"/>
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="campo">Apellidos<span class="no">*</span></label>
                            <div class="errorContainer"></div>
                            <input type="text" class="espacio form-control" placeholder="Apellidos *" id="apellidoConEmp" name="apellidoConEmp" />
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="campo">Celular<span class="no">*</span></label>
                            <div class="errorContainer"></div>
                            <input type="text" class="espacio form-control" placeholder="Celular *" id="tel1ConEmp" name="tel1ConEmp" />
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="campo">T&eacute;lefono Convencional <span class="no"></span></label>
                            <div class="errorContainer"></div>
                            <input type="text" class="espacio form-control" placeholder="Convencional (opcional)" id="tel2ConEmp" name="tel2ConEmp" />
                        </div>


                        <div class="col-md-12 text-center">
                            <div class="form-group check_box">
                                <div class="checkbox subt-registro">

                                    <label>
                                        <div class="errorContainer"></div>
                                        <input type="checkbox" style="position: relative;" class="terminosCond" name="terminosCond" id="terminosCond"> He le&iacute;do y acepto las <a class="link" href="<?php echo PUERTO."://".HOST."/politicaprivacidad/";?>" target="_blank">pol&iacute;ticas de privacidad</a> y <a class="link" href="<?php echo PUERTO."://".HOST."/terminoscondiciones/";?>" target="_blank">t&eacute;rminos y condiciones</a>
                                    </label>
                                </div>
                            </div>
                            <input type="submit" class="btn-orange"  value="Registrarse"/>
                        </div>
                    </form>  
                </div>
              </th>
            </tr>
          </thead>
        </table>
       </div> 
    </div>
    <img src="<?php echo PUERTO."://".HOST;?>/imagenes/portal-empleo.png" class="center img-portal">
   </div> 
   
  </div>
  <div class="back-white">
       <div class="col-md-6 top-20">
          <h2 class="black-text">Politicas de privacidad</h2>
          
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

        </div>
        <div class="col-md-6 top-20">
          <h2 class="black-text">Contacto</h2>
          <p class="black-text">
            <i class="fa fa-envelope-o" id="social-pie" aria-hidden="true"></i>
            <a class="black-text" target="_blank" href="<?php echo PUERTO."://".HOST;?>/recomendacion/">
              info@micamello.com.ec
            </a>
          </p>
        </div>
   </div>
</div>



<script type="text/javascript">

    function changeBack( dato ){
        if( dato == 1 ){
           $("#backColor").removeClass('back-blue').addClass('back-yellow');
           $("#tituloReg").removeClass('text-orange').addClass('blue-text');
        }
        else{
           $("#backColor").removeClass('back-yellow').addClass('back-blue');
           $("#tituloReg").removeClass('blue-text').addClass('text-orange');
        }
        
    }

</script>

