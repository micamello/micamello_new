<footer id="contact" class="footer p-top-30">
  <div class="container-fluid">
    <div class="foot_mic">
      <div class="container-fluid footer">
        <div class="col-md-8">
           <h2 class="white-text">micamello 2019 - Todos los derechos reservados</h2>  
        </div>
        <div class="col-md-3 top-1">
          <a href="<?php echo FACEBOOK; ?>" target="_blank">
          <img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/face-white.png" class="redes-soc pad">
          </a>
          <a href="<?php echo TWITTER; ?>" target="_blank">
            <img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/tw-white.png" class="redes-soc pad">
          </a>
          <a href="<?php echo INSTAGRAM; ?>" target="_blank">
            <img src="<?php echo PUERTO."://".HOST;?>/imagenes/redes/ins-white.png" class="redes-soc pad">
          </a>
        </div>
        
      </div>
      
    </div>    
  </div>
</div>

<input type="text" hidden id="puerto_host" value="<?php echo PUERTO."://".HOST ;?>">
<input type="hidden" id="iso" value="<?php echo SUCURSAL_ISO; ?>">

<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/jquery-3.0.0.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/vendor/bootstrap.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/assets/js/main.js"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/notificaciones.js" type="text/javascript"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/cookies.js" type="text/javascript"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/loader.js" type="text/javascript"></script>
<script src="<?php echo PUERTO."://".HOST;?>/js/sweetalert.v2.js"></script>

<?php
if (isset($template_js) && is_array($template_js)){
  foreach($template_js as $file_js){
    if ($file_js == "alignet"){
      //echo '<script type="text/javascript" src="https://integracion.alignetsac.com/VPOS2/js/modalcomercio.js"></script>';
      echo '<script type="text/javascript" src="'.PAYME_RUTA.'VPOS2/js/modalcomercio.js"></script>';
      
    }
    else{
      echo '<script type="text/javascript" src="'.PUERTO.'://'.HOST.'/js/'.$file_js.'.js"></script>';
    }
  }  
}
?>

<!--mensajes de error y exito-->
<?php if (isset($sess_err_msg) && !empty($sess_err_msg)){
  echo "<script type='text/javascript'>
        $(document).ready(function(){          
          Swal.fire({            
            text: '".$sess_err_msg."',
            imageUrl: '".PUERTO."://".HOST."/imagenes/wrong-04.png',
            imageWidth: 75,
            confirmButtonText: 'ACEPTAR',
            animation: true
          });     
        });
      </script>";
}?>

<?php if (isset($sess_suc_msg) && !empty($sess_suc_msg)){
  echo "<script type='text/javascript'>
        $(document).ready(function(){
          Swal.fire({            
            text: '".$sess_suc_msg."',
            imageUrl: '".PUERTO."://".HOST."/imagenes/logo-04.png',
            imageWidth: 210,
            confirmButtonText: 'ACEPTAR',
            animation: true
          });          
        });
        if($('#form_cambiar').length){
          $('html, body').animate({
            scrollTop: ($('.btnPerfil').offset().top-300)
        },1000);
        }
      </script>";
}?> 
 
<?php if (isset($sess_not_msg) && !empty($sess_not_msg)){
  echo "<script type='text/javascript'>
        $(document).ready(function(){
          Swal.fire({            
            text: '".$sess_not_msg."',
            imageUrl: '".PUERTO."://".HOST."/imagenes/logo-04.png',
            imageWidth: 210,
            confirmButtonText: 'ACEPTAR',
            animation: true
          });          
        });
      </script>";
}?>  
<!--<div class="container" id="Chart_details">
    <div id='chart_div' ></div><div id='g_chart_1' style="width: auto; height: auto;"></div>
</div>-->
<script type="text/javascript">
  if($("#form_payme").length || $("#form_deposito").length){
    function disableF5(e) { console.log(e.keyCode); if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 117) e.preventDefault(); };

    $(document).ready(function(){
         $(document).on("keydown", disableF5);
         $(document).on("contextmenu", function(e){
          e.preventDefault();
         });


    });

    // $(document).on('mobileinit', function () {
    //     $.mobile.ignoreContentEnabled = true;
    // });
  }
</script>
</body>
</html>