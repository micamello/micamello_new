<?php
  header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
  header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta http-equiv="Expires" content="0">
  <meta http-equiv="Last-Modified" content="0">
  <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
  <meta http-equiv="Pragma" content="no-cache">

  <meta charset="utf-8">
  <meta name="google-site-verification" content="Hy5ewWRp0yOqH1Z_3Q59zSVffxTZDLa_T50VEoGBIBw" />
  <title>MiCamello - Portal de Empleos en Ecuador</title>
  <meta name="keywords" content="ofertas de trabajo, trabajos, empleos, bolsa de empleos, buscar trabajo, busco empleo, portal de empleo, ofertas de empleo, bolsa de empleo, trabajos en ecuador, paginas de empleo, empleos ecuador, camello">
  <meta name="description" content="Cientos de empresas publican las mejores ofertas en la bolsa de trabajo Mi Camello Ecuador. Busca empleo y apúntate y sé el primero en postular">
  <?php if (!isset($nomobile) || empty($nomobile)){ ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php }?>
  <meta property="og:image" content="https://www.micamello.com.ec/" />
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

  <?php
  if (isset($template_css) && is_array($template_css)){
    foreach($template_css as $file_css){
      echo '<link rel="stylesheet" href="'.PUERTO.'://'.HOST.'/css/'.$file_css.'.css">';
    }  
  }

  ?> 
</head>

<body>

<!--NOTIFICACIONES-->
<?php
if(isset($_SESSION['mfo_datos']['usuario'])){
  $notificaciones = Modelo_Notificacion::notificacionxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario'],$_SESSION['mfo_datos']['usuario']['tipo_usuario']);
  if(!empty($notificaciones)){ ?>
    <input type="hidden" name="msg_notificacion" id="msg_notificacion" value="1">
    <div class="modal fade" id="notificaciones" tabindex="-1" role="dialog" aria-labelledby="notificaciones" aria-hidden="true" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel" align="center">Notificaci&oacute;n</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12" style="font-size:16px; color:#333">
                <b class="text_large">
                  <?php echo $notificaciones['descripcion'];?>
                </b>
                <b class="text_small" style="text-align: justify;"><?php echo utf8_encode($notificaciones['descripcion']); ?></b>
                <br>
                <center>
                  <?php if ($notificaciones["tipo"] == Modelo_Notificacion::DESBLOQUEO_ACCESO && 
                  $notificaciones["tipo_usuario"] == Modelo_Usuario::CANDIDATO) { ?>
                    <a href="javascript:void(0);" onclick="cancelarAcceso(<?php echo $notificaciones['id_notificacion'];?>);" class="btn-red" id="btn-rojo">Cancelar</a>
                    <a href="javascript:void(0);" onclick="aceptarAcceso(<?php echo $notificaciones['id_notificacion'];?>);" class="btn-blue">Aceptar</a>
                    
                  <?php } else { ?>
                    <a href="javascript:void(0);" onclick="desactivarNotificacion(<?php echo $notificaciones['id_notificacion'];?>);" class="btn-blue">Aceptar</a>
                  <?php } ?>                  
                </center> 
              </div>
            </div>
          </div>      
        </div>
      </div>
    </div>
  <?php } 
} ?>

<?php 
$navegador = Utils::detectarNavegador();
$_SESSION['mfo_datos']['navegador'] = $navegador;
if($navegador == 'MSIE'){ ?>
  <div align="center" id="mensaje" style="height: 150px;background: #c36262; color:black;"><br>
    <h3>Usted esta usando internet explorer 8 o inferior</h3>
    <p>Esta es una versi&oacute;n antigua del navegador puede afectar negativamente a su seguridad y su experiencia de navegaci&oacute;n.</p>
    <p>Por favor, actualice a la version mas reciente de IE o cambie de navegador ahora.</p>
    <p><b><a href="https://www.microsoft.com/es-es/download/internet-explorer.aspx">Actualizar IE</a></b></p>
  </div>
<?php } ?>

<?php
$readonly = "";
$noautofill = "";
  if(Utils::detectarNavegador() != 'Safari'){
    $readonly = "readonly";
    $noautofill = "noautofill";
  }

  $fixed = "";
  if (isset($_SESSION['mfo_datos']['usuario']) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && isset($vista) && $vista == "inicio") { 
    //$fixed = "menu";
?>

    <!-- <div class="container-fluid"> -->
      <!--style="top: 0px; position: fixed; margin-bottom: 50px !important; z-index: 1000; width: 100%"-->
      <div id="barra" class="top-info-bar bg-color-3 hidden-xs" >
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <ul class="list-inline topList">
              <p>Ll&aacute;manos a nuestras líneas Call Center:</p>
            </ul>
          </div>

          <div class="col-sm-3">
            <ul class="list-inline topList">
              <li><i class="fa fa-phone" aria-hidden="true"></i> <b>Quito:</b> 02 6055990</li>
            </ul>
          </div>
          <div class="col-sm-3">
            <ul class="list-inline topList">
              <li><i class="fa fa-phone" aria-hidden="true"></i> <b>Guayaquil:</b> 04 6060111  </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- </div> -->
<?php } 

      if( !Modelo_Usuario::estaLogueado() ){?>
        <div id="menupc" class="container-fluid">
          <div class="col-md-4">
            <a href="<?php echo PUERTO.'://'.HOST; ?>">
              <img class="logo left" src="<?php echo PUERTO."://".HOST;?>/imagenes/logo.png" alt="micamellologo">
            </a>
          </div>
           <br>
           <div class="col-md-4">
           </div>
           <div class="col-md-2">
               <button type="button" class="white-button right" data-toggle="modal" data-target="#loginModal" data-whatever="@mdo">Ingresar</button>  
           </div>
           <div class="col-md-2">
               <a class="blue-button left" href="<?php echo PUERTO."://".HOST;?>/registro/">Registrarse</a>
           </div>
           

        </div>
      <?php } 
      else{?>
        <div id="menupc" class="container-fluid">
          <div class="col-md-4">
            <a href="<?php echo PUERTO.'://'.HOST; ?>">
              <img class="logo left" src="<?php echo PUERTO."://".HOST;?>/imagenes/logo.png" alt="micamellologo">
            </a>
          </div>
           <br>
           <div class="col-md-4">
           </div>
           <div class="col-md-2">
               <a type="button" class="white-button right" href="<?php echo PUERTO."://".HOST;?>/perfil/">Perfil</a>
           </div>
           <div class="col-md-2">
            <?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){ ?>
               <a class="blue-button left" href="<?php echo PUERTO."://".HOST;?>/vacantes/">Mis Ofertas</a>
            <?php }
                 else{?>
                  <a class="blue-button left" href="<?php echo PUERTO."://".HOST;?>/postulacion/">Mis Postulaciones</a>
            <?php }?>
           </div>

        </div>
      <?php } ?>

  <div id="menumovil">
    
    <div class="col-md-12 container-fluid">
      <a href="<?php echo PUERTO.'://'.HOST; ?>">
        <img class="logo center" src="<?php echo PUERTO."://".HOST;?>/imagenes/logo.png" alt="micamellologo">
      </a>
    </div>
    
    <?php 
    if( !Modelo_Usuario::estaLogueado() ){?>
    <div class="col-sm-6" >
      <button type="button" class="white-button right" data-toggle="modal" data-target="#loginModal" data-whatever="@mdo">Ingresar</button> 
    </div>

    <div class="col-sm-6" >
      <a class="blue-button left" href="registro/">Registrarse</a> 
    </div>
    
    <div class="col-sm-6">
      <a id="buttonmovil" class="big-button right" href="<?php echo PUERTO."://".HOST;?>/registro/">Soy Candidato</a>
    </div>

    <div class="col-sm-6">
      <a id="buttonmovil" class="big-button left" href="<?php echo PUERTO."://".HOST;?>/registro/empresa/">Soy Empresa</a>
    </div>
   
    <br>
    <br >
    <br id="buttonmovil">
    <?php }
    else{?>
     <div class="isTablet">
     <div class="col-sm-6" >
       <a type="button" class="white-button right" href="<?php echo PUERTO."://".HOST;?>/perfil/">Perfil</a> 
     </div>

     <div class="col-md-6">
      <?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){ ?>
         <a class="blue-button left" href="<?php echo PUERTO."://".HOST;?>/vacantes/">Mis Ofertas</a>
      <?php }
           else{?>
            <a class="blue-button left" href="<?php echo PUERTO."://".HOST;?>/postulacion/">Mis Postulaciones</a>
      <?php }?>
     </div>

     </div>
     <!--esto es solo para tablets
     <br><br><br>-->

    <?php }?>
    <br id="buttonmovil">
    <br id="buttonmovil">
    <br>
  </div>
  

  <nav class="navbar navbar-default menu">
    <div class="btn-whatsapp">
      <a href="https://api.whatsapp.com/send?phone=<?php echo WB_DATA['number']; ?>&text=<?php echo WB_DATA['mensaje']; ?>" target="_blank"> <!--PONER NUMERO-->
        <img style="max-width: 100%;" src="<?php echo PUERTO.'://'.HOST.'/imagenes/wp_logo.png' ?>" alt="chatWithMe.jpg">
      </a>
    </div>
<?php //} ?> 
  
  
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar blue-toggle"></span>
        <span class="icon-bar blue-toggle"></span>
        <span class="icon-bar blue-toggle"></span>
      </button>
      
      
    </div>
    <!-- End Header Navigation -->


    <div class="collapse navbar-collapse" id="navbar-collapse-1">
      <!-- <ul class="nav navbar-nav"> 
      </ul> -->
      <ul class="nav navbar-nav navbar-right">                          
        <?php 
        if (isset($menu["menu"])){   
          foreach($menu["menu"] as $key=>$optmnu){?>                                                    
            <li <?php if($optmnu['vista'] == $vista){ ?>  
                  class="active" <?php } 
                 if($optmnu["nombre"] == 'Reg&iacute;strate' || $optmnu["nombre"] == 'Ingresar'){ 
                   echo 'class="btn-minimalist"'; 
                 }?> >
                  <a <?php
                   if(isset($optmnu['id'])){ 
                      echo 'id="'.$optmnu["id"].'"';
                   } 
                    if($optmnu['nombre'] == "Planes"){
                      //echo "style='display: inline;'";
                    }  
                      if(isset($optmnu['href'])){ 
                        echo 'href="'.$optmnu['href'].'"'; 
                      }
                      else{ echo 'onclick="'.$optmnu['onclick'].'"'; 
                      } ?> 
                        <?php echo (isset($optmnu["modal"])) ? ' ' : '';?>><?php 
                      if($optmnu["nombre"] == 'Inicio'){ echo 'Inicio';  }
                      else{
                        if($optmnu['nombre'] == "Planes"){
                          $planesLi = '<span class="crown-ph" style="text-align: center;">
                                            Planes
                                       </span>';
                          echo $planesLi;
                        }
                        else{ echo $optmnu["nombre"];
                        }
                      } ?>
                  </a>
            </li>                            
          <?php } ?>

          <?php //echo $menu["submenu_cuentas"];
            if (isset($menu["submenu_cuentas"])){ ?>  
            <li class="dropdown" >
              <a href="#" class="dropdown-toggle" style="top:5px; height: 50px;" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administraci&oacute;n &nbsp;<i class="fa fa-caret-down"></i></a>
              <ul class="dropdown-menu">
                <?php foreach($menu["submenu_cuentas"] as $submenu_cuentas){ ?>  
                 <li><a href="<?php echo $submenu_cuentas['href'];?>"><?php echo $submenu_cuentas['nombre'];?></a></li>
               <?php } ?>
             </ul>
           </li>                              
         <?php } ?>

         <?php if (isset($menu["submenu"])){ ?>                            
          <li class="dropdown" id="seccion_user">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" >
                
                <?php if( $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA  ){
                         $datos = Modelo_usuario::validaFotoEmpresa($_SESSION['mfo_datos']['usuario']['id_usuario']);
                      }
                      else{
                         $datos = Modelo_usuario::validaFoto($_SESSION['mfo_datos']['usuario']['id_usuario']);
                      } 
               if( $datos["foto"] == 1){?>
                  <img src="<?php echo PUERTO.'://'.HOST.'/imagenes/usuarios/profile/'.$_SESSION['mfo_datos']['usuario']['username'].'-thumb.jpg'; ?>" class="user-thumb <?php if(Utils::detectarNavegador()=='Safari'){
                    echo "usericon_safari";
              } ?>" width="35" height="35">&nbsp;<i class="fa fa-caret-down"></i>&nbsp;<span class="text-shadow"><?php echo strtoupper($_SESSION['mfo_datos']['usuario']['username']); ?></span>
                   <?php }
                   else{?>
                      <img src="<?php echo PUERTO.'://'.HOST.'/imagenes/img-perfil.jpg'; ?>" class="user-thumb <?php if(Utils::detectarNavegador()=='Safari'){
                    echo "usericon_safari";
              } ?>" width="35" height="35">&nbsp;<i class="fa fa-caret-down"></i>&nbsp;<span class="text-shadow"><?php echo strtoupper($_SESSION['mfo_datos']['usuario']['username']); ?></span>
                   <?php }?>

                <!-- <img src="<?php /*echo PUERTO.'://'.HOST.'/imagenes/imgthumb/'.$_SESSION['mfo_datos']['usuario']['username'].'/'; ?>" class="user-thumb <?php if(Utils::detectarNavegador()=='Safari'){
                echo "usericon_safari ";
              } ?>" width="35" height="35">&nbsp;<i class="fa fa-caret-down"></i>&nbsp;<?php echo strtoupper($_SESSION['mfo_datos']['usuario']['username'])*/; ?> -->

              <ul class="dropdown-menu">
                <li id="estilo_username"></li>
                <?php foreach($menu["submenu"] as $submenu){ ?>  
                  <li><a <?php if(isset($submenu['href'])){ echo 'href="'.$submenu['href'].'"'; }else{ echo 'onclick="'.$submenu['onclick'].'"'; } ?>><?php echo $submenu['nombre'];?></a></li>
                <?php } ?>
              </ul>
            </a>
          </li>
          <li>&nbsp;&nbsp;&nbsp;&nbsp;</li>                              
        <?php } ?>
      <?php } ?>
      </ul>
    </div> 
  </div>
</nav>

<?php
  if (isset($breadcrumbs) && is_array($breadcrumbs)){ ?>

    <div class="container-fluid">
      <ol class="breadcrumb" style="text-align: left;">
        <?php 
        $cont = 1;
        echo '<li><a href="'.PUERTO."://".HOST.'/">Inicio</a></li>';
        foreach($breadcrumbs as $key => $accion){ 
          if((count($breadcrumbs)-1) >= $cont){
              $enlace = '<a href="'.PUERTO."://".HOST.'/'.$key.'/">'.$accion.'</a>';
          }else{
            $enlace = $accion;
          }
            echo '<li>'.$enlace.'</li>';
          $cont++;
        } ?>
      </ol> 
    </div>
 
<?php } ?>


<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar" onclick="cleanAll()">
          <span aria-hidden="true">
            <label class="rounded">
              &times;
            </label>
          </span>
        </button>
      </div>
      <div class="modal-body">
        <div>
          <img style="width: 35%; display:block; margin-left: auto; margin-right: auto;" src="<?php echo PUERTO."://".HOST;?>/imagenes/logo.png">
        </div>  
        
        <!-- <h2 class="blue-text">Ingresar</h2> -->
        <form action = "<?php echo PUERTO."://".HOST;?>/login/" method = "post" id="form_login" name="form_login" autocomplete="off">
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Usuario:
            <span title="Este campo es obligatorio">*</span></label>
            <input type="text" name="username" id="username" class="form-control <?php //echo $noautofill; ?>" maxlength="50" minlength="4" onkeyup="validaForm(1,'btn_sesion')" required>
            <div id="err_username" class="help-block with-errors"></div>
            <input type="hidden" name="login_form" id="login_form" value="1" <?php echo $readonly; ?>>
            
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Password:
            <span title="Este campo es obligatorio">*</span></label>
            <div class="input-group">
              <span class="input-group-addon show_hidden" onclick="pass_reveal(this);"><i class="fa fa-eye"></i></span>
              <input type="password" class="form-control <?php echo $noautofill; ?>" title="Letras y números, mínimo 8 caracteres" type="password" name="password1" id="password1" maxlength="20" minlength="8" onkeyup="validaForm(1,'btn_sesion')" <?php echo $readonly; ?> required>
              <div id="err_password" class="help-block with-errors"></div>
            </div>
          </div>
          <div class="form-group">
            <input type="checkbox" name="">&nbsp;<a href="#">Recordar usuario y contrase&ntilde;a</a></label>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <a href="<?php echo PUERTO."://".HOST;?>/contrasena/">¿Olvide mi contrase&ntilde;a?</a><br><br>
        <button id="btn_sesion" type="button" class="btn btn-login" onclick="validaForm(1,'btn_sesion')">Iniciar sesion</button>
        <br><br>
        <a class="btn btn-login-reg" href="<?php echo PUERTO."://".HOST;?>/registro/">¿Aún no estás registrado?</a>
      </div>
    </div>
  </div>
</div>



<script type="text/javascript">
  $('#loginModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget)
  var recipient = button.data('abrir')
  var modal = $(this)
  modal.find('.modal-title').text('Login ' + recipient)
  modal.find('.modal-body input').val(recipient)
})

  
</script>