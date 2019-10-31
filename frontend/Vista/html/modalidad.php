<script>

  function seleccionar($dato){
    document.getElementById("seleccion"+$dato).checked = true;
}
</script>

<div class="text-center">
  <h2 class="blue-text">Test Canea</h2>
</div>
<div class="container">
  <!-- <div class="error"></div> -->
  <form id="metodoSeleccion" action="<?php echo PUERTO."://".HOST;?>/modalidad/" method="POST">
      <div class="row">
        <div class="col-md-12" style="background-color: #f96511;">
          <p class="qs-text-2">A continuación le presentamos dos métodos de respuesta, seleccione la opción con la que desee realizar el Test.</p>
        </div>
        <div class="col-md-12">

          <?php 
            foreach (METODO_SELECCION as $key => $value) {
          ?>
          <div class="col-md-12"><br></div>
          <div class="col-md-12" align="center">
            <img id="img-test" class="hasShadow" src="<?php echo PUERTO."://".HOST."/imagenes/metodoSel/".$key.".png";?>">
            <div class="col-md-12 text-center">
              <input type="radio" style="visibility: hidden;" name="seleccion" id="seleccion<?php echo $key;?>" value="<?php echo $key; ?>">
              <input type="submit" class="btn btn-orange margin-40 "  
                     onclick="seleccionar(<?php echo $key; ?>)" value="Escoger esta opción"/>
            </div>
          </div>
        <?php }?>
      </div>
    </div>
  </form>
</div>


<div class="modal fade" id="msg_canea" tabindex="-1" role="dialog" aria-labelledby="msg_canea" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="row">
        <div class="text-center">
          <br>
        </div>
        <div class="col-md-12">
          <img style="display:block; margin:auto;" src="../imagenes/iconOferta.png"/><br>
          <p class="qs-text" style="font-size: 22px">Antes de cargar tu hoja de vida, completa el <span class="texto-canea">TEST CANEA</span> que te ayudar&aacute; a postularte como uno de los primeros candidatos!</p>
        </div>

       <section>
        <div class="text-center">
          <button type="button" class="btn btn-orange" data-dismiss="modal">Continuar</button>
        </div>
     </section> 
      </div>     
    </div>
  </div>
</div>
