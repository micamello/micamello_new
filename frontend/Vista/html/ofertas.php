<?php require_once ('includes/Mobile-Detect/Mobile_Detect.php'); 
      $detect = new Mobile_Detect(); ?>
<style>
	.shadow-panel1{
		cursor:pointer;
	}
</style>

<div class="container-fluid">
	<div class="text-center">
		<h2 class="blue-text"><?php echo $breadcrumbs[$vista]; ?></h2>
	</div>
</div>

<?php if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){ ?>
<!-- <br>
<div class="banner-publicidad " align="center">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="banner-light col-md-9 click ">est&aacute; a un solo click de encontrar el <b>candidato ideal</b></div>
        <button class="btn-blue-2 pulse animated infinite col-md-2"><a href="<?php echo PUERTO."://".HOST;?>/publicar/">Publicar Oferta</a></button>
      </div>
    </div>
  </div>
</div>
<br> -->
<?php } ?>

<div class="container-fluid">
	<div class="col-md-3 visible-md-inline visible-lg-inline">
		<br/><br/>
		<div class="panel panel-default shadow-panel1">
			<div class="panel-heading">
				<span>Palabra Clave</span>
			</div>
			<div class="panel-body">
				<div class="filtros">
					<div class="form-group">
						<div class="input-group">
							<input type="text" onclick="javascript: predictWord($(this), 'oferta');" onkeyup="javascript: predictWord($(this), 'oferta');" maxlength="30" class="form-control" id="inputGroup" aria-describedby="inputGroup" onkeypress="return check(event)" placeholder="Ej: Enfermero(a) &oacute; xx-xx-xxxx"> 
							<?php 
							$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/';
							?>
							<span class="input-group-addon">
								<a href="#" onclick="enviarPclave('<?php echo $ruta; ?>','1','1')"><i class="fa fa-search blue-search"></i>
								</a>
							</span>
						</div>
					</div>			    
				</div>
			</div>
		</div>
		<?php if($vista == 'cuentas'){ ?>
			<div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#subempresas-desplegable">
					<div class="row">
						<div class="col-md-10" id="drop-tit" >
							<span>
								<i class="fa fa-list-ul"></i> Subempresas
							</span>
						</div>
						<div class="col-md-2" >
							<span class="caret"></span>
						</div>
					</div>
				</div>
				<div class="panel-body collapse" id="subempresas-desplegable" aria-expanded="false">
					<div class="filtros">
						<?php
						if (!empty($array_empresas_hijas)) { 
							foreach ($array_empresas_hijas as $key => $v) {
								$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/S'.$key.'/';
								echo '<li class="lista"><a href="'.$ruta.'1/" class="cuentas" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
							}
						}
						?></div>
					</div>
				</div>
		<?php } ?>
			<div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#areas-desplegable">
					<div class="row">
						<div class="col-md-10" id="drop-tit" >
							<span>
								<i class="fa fa-briefcase"></i>&nbsp; &Aacute;reas de Empleos
							</span>
						</div>
						<div class="col-md-2" >
							<span class="caret"></span>
						</div>
					</div>
				</div>

				<div class="panel-body collapse" id="areas-desplegable" aria-expanded="false">
					<div class="filtros">
						<?php
						if (!empty($arrarea)) { 
							foreach ($arrarea as $key => $v) {
								$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/A'.$key.'/';
								echo '<li class="lista"><a href="'.$ruta.'1/" class="area" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
							}
						}
						?></div>
					</div>
			</div>

			<div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#provincias-desplegable">
					<div class="row">
						<div class="col-md-10" id="drop-tit" >
							<span>
								<i class="fa fa-map-marker"></i>&nbsp; Provincias
							</span>
						</div>
						<div class="col-md-2" >
							<span class="caret"></span>
						</div>
					</div>
				</div>

				<div class="panel-body collapse" id="provincias-desplegable" aria-expanded="false">
					<div class="filtros">
						<?php
						if (!empty($arrprovincia)) {
							foreach ($arrprovincia as $key => $v) {
								$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/P'.$key.'/';
								echo '<li class="lista"><a href="'.$ruta.'1/" class="provincia" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
							}
						}
						?>
					</div>
				</div>
			</div>

			<div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#jornada-desplegable">
					<div class="row">
						<div class="col-md-10" id="drop-tit" >
							<span>
								<i class="fa fa-clock-o"></i>&nbsp; Jornada
							</span>
						</div>
						<div class="col-md-2" >
							<span class="caret"></span>
						</div>
					</div>
				</div>

				<div class="panel-body collapse" id="jornada-desplegable" aria-expanded="false">
					<div class="filtros">
						<?php
						if (!empty($jornadas)) {
							foreach ($jornadas as $key => $v) {
								$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/J'.$key.'/';
								echo '<li class="lista"><a href="'.$ruta.'1/" class="jornada" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
							}
						}
						?>
					</div>
				</div>
			</div>

			<div class="panel panel-default shadow-panel1">
				<div class="panel-heading" data-toggle="collapse" href="#salario-desplegable">
					<div class="row">
						<div class="col-md-10" id="drop-tit" >
							<span>
								<i class="fa fa-dollar"></i> Salario
							</span>
						</div>
						<div class="col-md-2" >
							<span class="caret"></span>
						</div>
					</div>
				</div>

				<div class="panel-body collapse" id="salario-desplegable" aria-expanded="false">
					<div class="filtros">
						<?php
						if (!empty(SALARIO)) {
							foreach (SALARIO as $key => $v) {
								$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/K'.$key.'/';
								echo '<li class="lista"><a href="'.$ruta.'1/" class="salario" id="' . $key . '">' . utf8_encode(ucfirst(strtolower($v))). '</a></li>';
							}
						}
						?>
					</div>
				</div>
			</div>
	</div>

	<div class="col-md-12 hidden-md hidden-lg">
		<form role="form" name="form1" id="filtros" method="post" action="<?php echo PUERTO."://".HOST;?>//">
			<div class="panel panel-default shadow" style="border-radius: 5px;">
				<div class="panel-heading collapsed" style="cursor:pointer" data-toggle="collapse" data-target="#contenedor" aria-expanded="false">
					<i class="fa fa-angle-down"></i>&nbsp;Filtros
				</div>
				<div class="panel-body collapse" id="contenedor" aria-expanded="false" style="height: 30px;">
					<div class="form-group">
						<input type="text" onkeyup="javascript: predictWord($(this), 'oferta', <?php echo "'".$id_oferta."'"; ?>);" maxlength="30" class="form-control" id="inputGroup1" placeholder="Ej: Enfermero(a) &oacute; xx-xx-xxxx"> 
					</div>
					<div class="form-group">
						<?php 
						$ruta = PUERTO.'://'.HOST.'/'.$vista.'/1/'; 
						?>
						<select id="categorias" class="form-control">
							<option value="0">Seleccione un &aacute;rea de empleo</option>
							<?php
							foreach ($arrarea as $key => $v) {
								echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
							}
							?>                    
						</select>
					</div>
					<div class="form-group">
						<select id="provincia" class="form-control">
							<option value="0">Seleccione una provincia</option>
							<?php
							foreach ($arrprovincia as $key => $v) {
								echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
							}
							?>                    
						</select>
					</div>
					<div class="form-group">
						<select id="jornada" class="form-control">
							<option value="0">Seleccione un jornada</option>
							<?php
							foreach ($jornadas as $key => $v) {
								echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
							}
							?>                    
						</select>
					</div>
					<div class="form-group">
						<select id="salario" class="form-control">
							<option value="0">Seleccione un salario</option>
							<?php
							foreach (SALARIO as $key => $v) {
								echo '<option value="'.$key.'">'.utf8_encode(ucfirst(strtolower($v))).'</option>';
							}
							?>  
						</select>
					</div>
					<div class="form-group">
						<a class="btn btn-md btn-info" onclick="obtenerFiltro('<?php echo $ruta; ?>','1')">
							Buscar
						</a>
					</div>	  
				</div>
			</div>
		</form>
	</div>
	<div class="col-md-9">
		
		<div class="container-fluid ordenamientos">
			<div class="col-md-12">
				<?php 
					$sinOffSet = false;
					if (trim($vista) == 'oferta' && isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'autopostulacion')) { 
						$sinOffSet = true; ?> 
					<div class="col-md-4"> 
						<div align="left"> 
							<h4><b class="black-text">Autopostulaciones restantes: 
								<span class="parpadea" style="color:red">
									<?php echo $autopostulaciones_restantes['p_restantes']; ?>					
								</span>
							</b></h4>
						</div>
					</div> 

				<?php } 
				  else{?>
				  	<div class="col-md-4"> 
						<div align="left"> 
							<h4 class="black-text"><b><i class="fa fa-sliders" style="font-size: 18pt;"></i>&nbsp; Ordenar por </b></h4>
						</div>
					</div>
				 <?php } 
                
                if( trim($vista) == 'oferta' && isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'autopostulacion') ){?>

		        <div class="col-md-2 black-text">
		        	<h4 class="black-text"><b><i class="fa fa-sliders" style="font-size: 18pt;"></i>&nbsp; Ordenar por </b></h4>
		        </div>
		        <div class="col-md-2 black-text">
			        <select id="tipo_orden" name="tipo_orden" class="form-control black-text">
			          <option value="1" <?php if($tipo_ordenamiento == 1){ echo 'selected'; } ?>>Salario</option>
			          <option value="2" <?php if($tipo_ordenamiento == 2){ echo 'selected'; } ?>>Fecha</option>
			        </select>
		        </div>
		        <?php } 
		        else{?>
		        	<div class="col-md-4 black-text">
			        <select id="tipo_orden" name="tipo_orden" class="form-control black-text">
			          <option value="1" <?php if($tipo_ordenamiento == 1){ echo 'selected'; } ?>>Salario</option>
			          <option value="2" <?php if($tipo_ordenamiento == 2){ echo 'selected'; } ?>>Fecha</option>
			        </select>
		        </div>
		        <?php }?>

		        <div class="<?php if( trim($vista) == 'oferta' && isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'autopostulacion') ){
		        	echo 'col-md-4';
		        }else{
		        	echo 'col-md-4';
		        }?>
		         black-text">
		          	<label class="radio-inline">
		                <input type="radio" name="orden" value="1" title="Ordena de menor a mayor" <?php if($_SESSION['mfo_datos']['Filtrar_ofertas']['O'] == 2 && !empty($tipo_ordenamiento)){ echo 'checked'; } ?>>
		                <b>Ascendente</b>
		            </label>
		            <label class="radio-inline">
		               <input type="radio" name="orden" value="2" title="Ordena de mayor a menor" <?php if($_SESSION['mfo_datos']['Filtrar_ofertas']['O'] == 1 && !empty($tipo_ordenamiento)){ echo 'checked'; } ?>>
		               <b>Descendente</b>
		            </label>
		        </div>


		        <?php $enlace_ordenamiento = PUERTO.'://'.HOST.'/'.$vista.'/1/O'; ?>
				<input type="hidden" id="enlace_ordenamiento" name="enlace_ordenamiento" value="<?php echo $enlace_ordenamiento; ?>">
	      	</div>
		</div>

		<div class="col-sm-12">
			<img class="auto-width" src="<?php echo PUERTO.'://'.HOST.'/imagenes/publicidad-micamello.png'; ?>">
		</div>

		<div id="busquedas" class="container-fluid">
			<?php if (isset($link)) { 
				echo $link; 
			} ?>
		</div>


		<div id="result">
			<?php 
			$caracteres = 55; 
			$desc = 150;
            
            if ($detect->isMobile()==true) {
            	$caracteres = 15;
            }

			if(!empty($ofertas) && $ofertas[0]['id_ofertas'] != ''){
				foreach($ofertas as $key => $o){  ?>
					<div class="caja-postulaciones">
						<?php 
						if($vista == 'postulacion' && $o['estado'] != Modelo_Oferta::ACTIVA){
							$o['puedeEliminar'] = 0; 
						}
						if($o['estado'] == Modelo_Oferta::PORAPROBAR && $vista != 'postulacion'){ 
							$t = 'Aviso Pendiente de Aprobaci&oacute;n'; 
						    $clase = 'titulo-postulaciones-pendiente'; 
						    $sueldo = 'sueldo-post-pendiente';}
						else{ $t = ''; } 

						if($o['tipo_oferta'] == 1 && $t == ''){ 
							$clase = 'titulo-postulaciones';
							$sueldo = 'sueldo-post'; 
							$t = 'Aviso Urgente';
						}else if($o['tipo_oferta'] == 0 && $t == ''){
							$clase = 'titulo-postulaciones-normal';
							$sueldo = 'sueldo-post-normal';
							$t = 'Aviso Normal';
						}
						if( strlen(utf8_encode($o['titulo'])) > $caracteres ){
							echo '<div class="col-md-10 col-sm-10 '.$clase.'" ><p class="titulo-post"><i class="fa fa-briefcase"></i> &nbsp; '  .substr(utf8_encode($o['titulo']), 0, $caracteres).'...</p></div>';
						}
						else{
							echo '<div class="col-md-10 col-sm-10 '.$clase.'" ><p class="titulo-post"><i class="fa fa-briefcase"></i> &nbsp; '  .utf8_encode($o['titulo']).'</p></div>';
						}
						
						echo '<div class="col-md-2 col-sm-2 '.$sueldo.'"><p class="paga-post">'.SUCURSAL_MONEDA.number_format($o['salario'],2).'</p></div>' 
						
						?>
						
					<div class='panel-body ofertaUrgente' id='caracteristica_oferta'>
					  
					  <div class="row">
					    
					    <div class="col-md-2 col-sm-3 col-xs-12 imagen-perfil"> 
				    	<?php

					  		if( $o["foto"] == 1 ){
								$logo = PUERTO.'://'.HOST.'/imagenes/usuarios/profile/'.$o['username'].'.jpg';
							}
							else{
								$logo = PUERTO.'://'.HOST.'/imagenes/user.png';
							}
							$src_imagen = ($o['confidencial'] && $vista!='vacantes' && $vista!='cuentas') ? PUERTO.'://'.HOST.'/imagenes/logo_oferta.png' : $logo;

							//$src_imagen = ($o['confidencial'] && $vista!='vacantes' && $vista!='cuentas') ? PUERTO.'://'.HOST.'/imagenes/logo_oferta.png' : PUERTO.'://'.HOST.'/imagenes/usuarios/'.$o['username'].'/';
							?>

							<img id="imgPerfil" class="img-res2 img-responsive" src="<?php echo $src_imagen; ?>" alt="icono">

							<?php if($vista == 'vacantes'){ ?>
								<p id="tipo-plan"><?php echo utf8_encode($datos_plan[$o['id_ofertas']]['nombre_plan']); ?></p>
							<?php } ?>

							<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA) { 	?>
								<?php if (REQUISITO[$o['confidencial']] == 'No') {
									echo '<p id="tipo-empresa-pub">'.utf8_encode($o['empresa']).'</p>';
								}
								else
								{
									echo '<p id="tipo-empresa-conf">Confidencial</p>';
								} 
							}

							if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && $vista == 'cuentas'){
								echo '<p id="tipo-empresa">'.utf8_encode($o['empresa']).'</p>';
							}?>
					  	
					    </div>

					    <!--titulo de las ofertas-->
					    <div class="col-md-10 col-sm-9 col-xs-12">
				  	    
					  		<h4><?php echo utf8_encode($o['titulo']); ?></h4>
					  		<p class="texto-postulaciones cortar desc-post" align="justify"><?php echo strip_tags(html_entity_decode($o['descripcion']));?></p>

				  	    </div>
					  	
					  	
					  	<div class="col-md-2 col-sm-1 col-xs-12 ">
					  		<?php if( $vista == 'oferta' ){?>
					  			<i class="fa fa-calendar icons-blue text-center"></i><br>
                    			<p style="font-size: 12px; text-align: center;"><?php echo date("d-m-Y", strtotime($o['fecha_actualizado'])); ?></p>
				            <?php }
					        else if( $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA ){?>
					        	<i class="fa fa-calendar icons-blue text-center"></i><br>
                    			<p style="font-size: 12px; text-align: center;"><?php echo date("d-m-Y", strtotime($o['fecha_actualizado'])); ?></p>
				            <?php }?>
					  	</div>

					  	<div class="col-md-2 col-sm-1 col-xs-12">
					  	</div>

					  	<div class="col-md-2 col-sm-1 col-xs-12">
					  	</div>

                        
                        <!--eliminar postulaciones-->
					  	<div class="col-md-3 col-sm-2 col-xs-12 opc-ofertas">
				   <?php if($vista == 'postulacion' && $o['estado'] == Modelo_Oferta::ACTIVA){
                          if(isset($o['tipo']) && $o['tipo'] == 2){ ?>
					  		<a href="<?php echo PUERTO."://".HOST."/postulacion/eliminar/".Utils::encriptar($o['id_postulacion'])."/"; ?>" class=" btn btn-orange-eliminar">
										<i class="fa fa-trash"></i><br>
										<p style="font-size: 8pt;">&nbsp;eliminar&nbsp;</p>
							</a>
				     <?php }
				          else if(isset($o['puedeEliminar']) && $o['puedeEliminar'] == 1){ ?>
				          	<a title="Eliminar postulaci&oacute;n" onclick="abrirModal('<span style=\'font-size:14px;\'> Si presiona el botón de Aceptar no recibirá más postulaciones automáticas de esta empresa <?php if (REQUISITO[$o['confidencial']] == 'No') { echo '<b>('.utf8_encode($o['empresa']).')</b>'; } ?>, Desea eliminar la postulación? </span>','alert_descarga','<?php echo PUERTO."://".HOST."/postulacion/eliminar/".Utils::encriptar($o['id_postulacion'])."/".Utils::encriptar($o['id_empresa'])."/"; ?>','Ok','Confirmación');" class=" btn btn-orange-eliminar">
										<i class="fa fa-trash"></i><br>
										<p style="font-size: 8pt;">&nbsp;eliminar&nbsp;</p>
							</a>
				    <?php }
					    }
					    $tiempo = Modelo_Parametro::obtieneValor('tiempo_espera');
						$puedeEditar = Modelo_Oferta::puedeEditar($o["id_ofertas"],$tiempo);
						?>
					  	</div>
                        
                        <!--editar ofertas-->
					  	<div class="col-md-3 col-sm-2 col-xs-12 opc-ofertas">
					 <?php if($vista == 'vacantes'){ 
							 if($puedeEditar["editar"] == 1){?>
						  		<a onclick="abrirModalEditar('editar_Of','<?php echo Utils::encriptar($o["id_ofertas"]); ?>');" class=" btn btn-blue-ver">
									<i class="fa fa-pencil-square-o"></i><br>
									<p style="font-size: 8pt;">&nbsp;&nbsp;&nbsp;&nbsp;editar&nbsp;&nbsp;&nbsp;&nbsp;</p>
								</a>
					  <?php }
						}?>

					  	</div>

                        <!-- <div class="<?php if($vista == 'oferta'){ echo ' col-md-3 col-sm-6 col-xs-12'; }else if($vista == 'vacantes'){ echo 'col-sm-6 col-xs-12'; } ?> ">
										<?php if($vista == 'vacantes'){ 
											if($puedeEditar["editar"] == 1){
												?>
												<div class="col-md-6 col-xs-6">
													<a class="f-s-16px" onclick="abrirModalEditar('editar_Of','<?php echo Utils::encriptar($o["id_ofertas"]); ?>');"><i class="postulacion-icono-editar fa fa-pencil-square-o"></i><br>
													Editar la oferta</a>
												</div>
											<?php }
										} ?>

										<?php if($vista != 'oferta'){   ?>
											<div class="<?php if($vista == 'postulacion' && (isset($o['puedeEliminar']) && $o['puedeEliminar'] == 1 && $o['tipo'] == 1)){ echo 'col-md-2 col-sm-3 col-xs-6'; }else if(isset($o['puedeEliminar']) && $o['puedeEliminar'] == 0 && $vista == 'postulacion' && $o['tipo'] == 1){ echo 'col-md-4 col-sm-6 col-xs-12'; }else if(isset($o['puedeEliminar']) && $o['puedeEliminar'] == 0 && $vista == 'postulacion' && $o['tipo'] == 2){ echo 'col-md-2 col-sm-3 col-xs-6'; }  
											if($puedeEditar["editar"] == 0 && $vista == 'vacantes'){ echo 'col-md-8 col-md-offset-4 col-xs-12 '; }
											if($vista == 'cuentas'){ echo 'col-md-6 col-xs-12'; } ?> ">
											<?php } ?>
											<a class="f-s-16px" href="<?php echo PUERTO."://".HOST."/detalleOferta/".$vista."/".Utils::encriptar($o["id_ofertas"])."/"; ?>">
												<i class="postulacion-icono-ver fa fa-eye"></i><br>
											Ver detalles de la oferta</a>
											<?php if($vista != 'oferta'){ ?>
											</div>
										<?php } ?>
									</div> -->





					  	<!--editar ofertas-->

					  	<div class="col-md-3 col-sm-2 col-xs-12 opc-ofertas">
					  		<a href="<?php echo PUERTO."://".HOST."/detalleOferta/".$vista."/".Utils::encriptar($o["id_ofertas"])."/"; ?>" class=" btn btn-blue-ver">
								<i class="fa fa-eye"></i><br>
								<p style="font-size: 8pt;">ver oferta</p>
							</a>
							<?php if($vista != 'oferta'){ ?>
								<div >&nbsp;</div>
							<?php } ?>
					  	</div>


			      <?php if( $vista == 'oferta' ){?>
				  <?php }
					    else if( $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA ){?>
				  <?php }
                        else{?>
					  	<!--estado de las ofertas/postulaciones-->
					  	<div class="col-md-2 col-sm-1 col-xs-12">
					  	</div>

					  	<div class="col-md-2 col-sm-2 col-xs-6">
					  		<i class="fa fa-calendar icons-blue text-center"></i><br>
		                    <p style="font-size: 12px; text-align: center;"><?php echo date("d-m-Y", strtotime($o['fecha_actualizado'])); ?></p>
					  	</div>

					  	<div class="col-md-2 col-sm-2 col-xs-6">
					  		<?php if($vista == 'postulacion'){ ?>
							<?php $postulado = Modelo_Postulacion::obtienePostuladoxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario'],$o['id_ofertas']);
							$cv_descargado = Modelo_Descarga::obtieneDescargaCV($_SESSION['mfo_datos']['usuario']['infohv']['id_infohv'],$o['id_empresa'],$o['id_ofertas']);
							?>
					  	   <i class="fa fa-spinner text-center
					  	      <?php if(date("Y-m-d H:i:s", strtotime($datos_plan[$o['id_ofertas']]['fecha_caducidad'])) <= date('Y-m-d H:i:s')){ 
					  	      	    echo ' cancelada'; }
					  	      	  else{ 
					  	      	  	echo ' icons-blue'; } ?> "></i><br>
							<p style="font-size: 14px;"><?php if(isset($o['tipo']) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
							<?php echo ucfirst(strtolower(Modelo_Oferta::ESTATUS_OFERTA[$o['resultado']])); ?>
							<?php } ?></p>
						 <?php }?>
					  	</div>

					  	<div class="col-md-2 col-sm-2 col-xs-6">
					  		<?php if($vista == 'postulacion'){ ?>
							<?php $postulado = Modelo_Postulacion::obtienePostuladoxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario'],$o['id_ofertas']);
							$cv_descargado = Modelo_Descarga::obtieneDescargaCV($_SESSION['mfo_datos']['usuario']['infohv']['id_infohv'],$o['id_empresa'],$o['id_ofertas']);
							?>
				  			<i class="postulacion-icono <?php 
				  			  if(date("Y-m-d H:i:s", strtotime($datos_plan[$o['id_ofertas']]['fecha_caducidad'])) <= date('Y-m-d H:i:s')){ 
				  			  	echo 'cancelada'; 
				  			  }
				  			  else if(isset($cv_descargado) && $cv_descargado['cantd_descarga'] >= 1){ 
				  				echo 'icono-aprobado'; 
				  			  }
				  			  else{ 
				  			  	echo 'icono-por-aprobar'; 
				  			  } ?> fa fa-id-card-o"></i><br>
							<p style="font-size: 14px;">visto</p>
						  <?php } ?>
					  	</div>

					  	<div class="col-md-2 col-sm-2 col-xs-6">
					  		<?php if($vista == 'postulacion'){ ?>
							<?php $postulado = Modelo_Postulacion::obtienePostuladoxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario'],$o['id_ofertas']);
							$cv_descargado = Modelo_Descarga::obtieneDescargaCV($_SESSION['mfo_datos']['usuario']['infohv']['id_infohv'],$o['id_empresa'],$o['id_ofertas']);
							?>
					  		<i class="postulacion-icono <?php 
					  		  if(date("Y-m-d H:i:s", strtotime($datos_plan[$o['id_ofertas']]['fecha_caducidad'])) <= date('Y-m-d H:i:s')){ 
					  		  	echo 'cancelada'; }
					  		  else{ 
					  		  	echo 'icono-por-aprobar'; } ?> fa fa-check"></i><br>
							<p style="font-size: 14px;">Finalizado</p>
						 <?php } ?>
					  	</div>

			<?php   }?>

					  	<!--estado de las ofertas/postulaciones-->
					  	<div class="col-md-2 col-sm-2 col-xs-12" >
					  	</div>
					  	<div class="col-md-10 col-sm-8 col-xs-12">
					  		<br><br><br>
					  	</div>

				  	</div>
				  	<!--cierre del row-->

				</div>

                <div class="col-md-12 col-sm-12 col-xs-12"> 
					<div class="row ">
					  	  <div class="col-md-2 col-sm-3 col-xs-12">
					  		<?php /*if($vista == 'vacantes' || $vista == 'cuentas'){ ?>
								<p id="texto-postulaciones">Publicada:<br> <i class="fa fa-calendar"></i>&nbsp;<?php echo date("d-m-Y", strtotime($o['fecha_actualizado'])); ?></p>
							<?php }*/ ?>
					  	</div>
					  	

					  	<?php $char_province = 13;
					  	      if($vista == 'postulacion'){?>
					  	<div class="col-sm-3 col-md-2 col-xs-3 cuadro-oferta">
							<i class="empleo-icono fa fa-user-circle"></i><br>
							<p id="postulacion-2"><?php echo $o['vacantes'].' vacante'; ?></p>
					  	</div>
					  	<div class="col-sm-3 col-md-2 col-xs-3 cuadro-oferta">
							<i class="empleo-icono fa fa-clock-o"></i><br>
							<p id="postulacion-2"><?php echo $o['jornada']; ?></p>
					  	</div>
					  	<div class="col-sm-3 col-md-2 col-xs-3 cuadro-oferta">
							<i class="empleo-icono fa fa-map-marker"></i><br>
							<p id="postulacion-2"><?php if( strlen(utf8_encode($o['provincia'])) >= $char_province ){ echo substr(utf8_encode($o['provincia']), 0, $char_province).'...';
							      } else{ echo substr(utf8_encode($o['provincia']), 0, $char_province); } ?></p>
					  	</div>
					  	<div class="col-sm-3 col-md-2 col-xs-3 cuadro-oferta">
							<i class="empleo-icono fa fa-hand-pointer-o"></i><br>
							<p id="postulacion-2"><?php echo POSTULACIONES[$o['tipo']]; ?></p>
					  	</div>
					  <?php }else{?>
					  		<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) {?>
					  		    <div class="col-sm-3 col-md-2 col-xs-3 cuadro-oferta"><?php
								$cantd = 0;
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
						<?php } ?>
					  	<div class="col-sm-3 col-md-2 col-xs-3 cuadro-oferta">
							<i class="empleo-icono fa fa-user-circle"></i><br>
							<p id="postulacion-2"><?php echo $o['vacantes'].' vacante'; ?></p>
					  	</div>
					  	<div class="col-sm-3 col-md-2 col-xs-3 cuadro-oferta">
							<i class="empleo-icono fa fa-clock-o"></i><br>
							<p id="postulacion-2"><?php echo $o['jornada']; ?></p>
					  	</div>
					  	<div class="col-sm-3 col-md-2 col-xs-3 cuadro-oferta">
							<i class="empleo-icono fa fa-map-marker"></i><br>
							<p id="postulacion-2"><?php if( strlen(utf8_encode($o['provincia'])) >= $char_province ){ echo substr(utf8_encode($o['provincia']), 0, $char_province).'...';
							      } else{ echo substr(utf8_encode($o['provincia']), 0, $char_province); } ?></p>
					  	</div>
					  <?php }?>
			    </div>
		    </div>	
<br><br>
<br class="isTablet isMovil">

						<!-- <div class='panel-body ofertaUrgente' id='caracteristica_oferta'>
							<div class="row">
								<div class="col-md-2 col-sm-4 col-xs-12" style="padding-left: 0px;" align="center">
									<div class="col-md-12 col-sm-12 col-xs-12 imagen-perfil">
										<?php 										
										$src_imagen = ($o['confidencial'] && $vista!='vacantes' && $vista!='cuentas') ? PUERTO.'://'.HOST.'/imagenes/logo_oferta.png' : PUERTO.'://'.HOST.'/imagenes/usuarios/'.$o['username'].'/';
										?>
										<img id="imgPerfil" class="img-res2 img-responsive" src="<?php echo $src_imagen; ?>" alt="icono">
									</div>

									<div class="col-md-12 col-sm-12 col-xs-12">
										<?php if($vista == 'vacantes' || $vista == 'cuentas'){ ?>
											<p id="texto-postulaciones">Publicada:<br> <?php echo date("d-m-Y", strtotime($o['fecha_actualizado'])); ?></p>
										<?php } ?>
										<?php if($vista == 'vacantes'){ ?>
											<p id="tipo-plan"><?php echo utf8_encode($datos_plan[$o['id_ofertas']]['nombre_plan']); ?></p>
										<?php } ?>
									</div>

									<div class="col-md-12 col-sm-12 col-xs-12">
										<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA) { 	?>
											<?php if (REQUISITO[$o['confidencial']] == 'No') {
												echo '<p id="tipo-empresa">'.utf8_encode($o['empresa']).'</p>';
											}
											else
											{
												echo '<p id="tipo-empresa">Confidencial</p>';
											} 
										}

										if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && $vista == 'cuentas'){

											echo '<p id="tipo-empresa">'.utf8_encode($o['empresa']).'</p>';
										}
										?>
									</div>
								</div>
								<div class="col-md-10 col-sm-8 col-xs-12">
									<div class="col-md-<?php if($vista == 'oferta'){ echo '9'; }else{ echo '12'; } ?>">
										<h3 class="cargo-postulaciones"><?php echo utf8_encode($o['titulo']); ?></h3>
									</div>
									<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { ?>
										<div class="col-md-6 col-sm-6">
											<p class="texto-postulaciones cortar" align="justify"><?php echo strip_tags(html_entity_decode($o['descripcion'])); ?></p>
										</div>
									<?php }else{ ?>

										<?php if($vista == 'postulacion'){ ?>
											<div class="col-md-4 col-sm-3 col-xs-6">
												<p class="texto-postulaciones">Modo que aplic&oacute;:&nbsp;<b><?php echo POSTULACIONES[$o['tipo']]; ?></b><br>
													Fecha de la oferta: <?php echo date("d-m-Y", strtotime($o['fecha_actualizado'])); ?><br>
													Jornada: <?php echo $o['jornada']; ?></p>
											</div>
											<div class="col-md-4 col-sm-3 col-xs-6">
												<p class="texto-postulaciones">Salario: <?php echo SUCURSAL_MONEDA.number_format($o['salario'],2);?><br>
														Provincia: <?php echo utf8_encode($o['provincia']);?><br>
														Vacantes: <?php echo $o['vacantes']; ?></p>
											</div>
										<?php } ?>
									<?php } ?>

									<?php if($vista == 'postulacion' && $o['estado'] == Modelo_Oferta::ACTIVA){ ?>

										<?php if(isset($o['tipo']) && $o['tipo'] == 2){ ?>
											<div class="col-md-2 col-sm-3 col-xs-6">
												<a class="f-s-16px" style="cursor:pointer" title="Eliminar postulaci&oacute;n" href="<?php echo PUERTO."://".HOST."/postulacion/eliminar/".Utils::encriptar($o['id_postulacion'])."/"; ?>">
													<i class="postulacion-icono-basura fa fa-trash"></i><br>Eliminar postulaci&oacute;n
												</a>
											</div>
										<?php }else if(isset($o['puedeEliminar']) && $o['puedeEliminar'] == 1){ ?>
											<div class="col-md-2 col-sm-3 col-xs-6">
												<a class="f-s-16px" style="cursor:pointer" title="Eliminar postulaci&oacute;n" onclick="abrirModal('<span style=\'font-size:14px;\'> Si presiona el botón de Aceptar no recibirá más postulaciones automáticas de esta empresa <?php if (REQUISITO[$o['confidencial']] == 'No') { echo '<b>('.utf8_encode($o['empresa']).')</b>'; } ?>, Desea eliminar la postulación? </span>','alert_descarga','<?php echo PUERTO."://".HOST."/postulacion/eliminar/".Utils::encriptar($o['id_postulacion'])."/".Utils::encriptar($o['id_empresa'])."/"; ?>','Ok','Confirmación');">
													<i class="postulacion-icono-basura fa fa-trash"></i><br>Eliminar postulaci&oacute;n
												</a>
											</div>
										<?php } ?>

									<?php } ?> 

									<?php 
									$tiempo = Modelo_Parametro::obtieneValor('tiempo_espera');
									$puedeEditar = Modelo_Oferta::puedeEditar($o["id_ofertas"],$tiempo);
									
									?>

									<div class="<?php if($vista == 'oferta'){ echo ' col-md-3 col-sm-6 col-xs-12'; }else if($vista == 'vacantes'){ echo 'col-sm-6 col-xs-12'; } ?> ">
										<?php if($vista == 'vacantes'){ 
											if($puedeEditar["editar"] == 1){
												?>
												<div class="col-md-6 col-xs-6">
													<a class="f-s-16px" onclick="abrirModalEditar('editar_Of','<?php echo Utils::encriptar($o["id_ofertas"]); ?>');"><i class="postulacion-icono-editar fa fa-pencil-square-o"></i><br>
													Editar la oferta</a>
												</div>
											<?php }
										} ?>

										<?php if($vista != 'oferta'){   ?>
											<div class="<?php if($vista == 'postulacion' && (isset($o['puedeEliminar']) && $o['puedeEliminar'] == 1 && $o['tipo'] == 1)){ echo 'col-md-2 col-sm-3 col-xs-6'; }else if(isset($o['puedeEliminar']) && $o['puedeEliminar'] == 0 && $vista == 'postulacion' && $o['tipo'] == 1){ echo 'col-md-4 col-sm-6 col-xs-12'; }else if(isset($o['puedeEliminar']) && $o['puedeEliminar'] == 0 && $vista == 'postulacion' && $o['tipo'] == 2){ echo 'col-md-2 col-sm-3 col-xs-6'; }  
											if($puedeEditar["editar"] == 0 && $vista == 'vacantes'){ echo 'col-md-8 col-md-offset-4 col-xs-12 '; }
											if($vista == 'cuentas'){ echo 'col-md-6 col-xs-12'; } ?> ">
											<?php } ?>
											<a class="f-s-16px" href="<?php echo PUERTO."://".HOST."/detalleOferta/".$vista."/".Utils::encriptar($o["id_ofertas"])."/"; ?>">
												<i class="postulacion-icono-ver fa fa-eye"></i><br>
											Ver detalles de la oferta</a>
											<?php if($vista != 'oferta'){ ?>
											</div>
										<?php } ?>
									</div>
									<?php if($vista == 'oferta'){ ?>
										<div class="col-md-9 col-sm-6 col-xs-12">
											<p class="texto-empleo">
												Fecha de la oferta: <?php echo date("d-m-Y", strtotime($o['fecha_actualizado'])); ?></p>
										</div>
									<?php } ?>

									<?php if($vista != 'oferta'){ ?>
										<div class="col-md-12">
											<hr class="line-blue" style="margin: 10px 0px; background-color: blue;">
										</div>
									<?php } ?>

									<?php if($vista != 'postulacion'){ ?>
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="col-md-3 col-sm-3 col-xs-6">
												<p id="empleo-2">Salario:</p>
												<i class="empleo-icono fa fa-dollar"></i><br>
												<p id="postulacion-2"><?php echo SUCURSAL_MONEDA.number_format($o['salario'],2);?></p>
											</div>
											<div class="col-md-<?php if($vista == 'postulacion' || $vista == 'vacantes' || $vista == 'cuentas'){ echo '2'; }else{ echo '3'; } ?> col-sm-3 col-xs-6">
												<p id="empleo-2">Provincia:</p>
												<i class="empleo-icono fa fa-map-marker"></i><br>
												<p id="postulacion-2"><?php echo utf8_encode($o['provincia']);?></p>
											</div>
											<div class="col-md-<?php if($vista == 'postulacion' || $vista == 'vacantes' || $vista == 'cuentas'){ echo '2'; }else{ echo '3'; } ?> col-sm-3 col-xs-6">
												<p id="empleo-2">Jornada:</p>
												<i class="empleo-icono fa fa-clock-o"></i><br>
												<p id="postulacion-2"><?php echo $o['jornada']; ?></p>
											</div>
											<div class="col-md-<?php if($vista == 'postulacion' || $vista == 'vacantes' || $vista == 'cuentas'){ echo '2'; }else{ echo '3'; } ?> col-sm-3 col-xs-6">
												<p id="empleo-2">Vacantes:</p>
												<i class="empleo-icono fa fa-users"></i><br>
												<p id="postulacion-2"><?php echo $o['vacantes']; ?></p>
											</div>
											<?php if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA) { ?>
												<div class="col-md-2 col-xs-12">
													<p id="empleo-2">Postulados:</p>
													<?php 
													$cantd = 0;
													//echo '<br>id:'.$o['id_ofertas'];
													if(isset($aspirantesXoferta[$o['id_ofertas']])){ 
														/*echo '<br>cantd: '.*/$cantd = $aspirantesXoferta[$o['id_ofertas']]; ?>
														<a href="<?php echo PUERTO.'://'.HOST.'/verAspirantes/1/'.Utils::encriptar($o['id_ofertas']).'/1/'; ?>">
													<?php } ?>
													<i class="postulacion-icono-postulado fa fa-user"></i><br>
													<?php 
														/*if(isset($aspirantesXoferta[$o['id_ofertas']])){
															$cantd = $aspirantesXoferta[$o['id_ofertas']];
														}else{
															
														}*/

													if($cantd == 0){
														echo '<p id="postulacion-2">'.$cantd.'</p>';
													}else{

														echo '<p id="postulacion-2">'.$cantd.'</p></a>';
													}
													?>
												</div>
													<?php } ?>
										</div>
									<?php } ?>

									<?php if($vista == 'postulacion'){ ?>
										<?php $postulado = Modelo_Postulacion::obtienePostuladoxUsuario($_SESSION['mfo_datos']['usuario']['id_usuario'],$o['id_ofertas']);
										$cv_descargado = Modelo_Descarga::obtieneDescargaCV($_SESSION['mfo_datos']['usuario']['infohv']['id_infohv'],$o['id_empresa'],$o['id_ofertas']);
										?>
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="col-md-3 col-sm-3 col-xs-6">
												<i class="postulacion-icono <?php if(date("Y-m-d H:i:s", strtotime($datos_plan[$o['id_ofertas']]['fecha_caducidad'])) <= date('Y-m-d H:i:s')){ echo 'cancelada'; }else{ echo 'icono-aprobado'; } ?> fa fa-calendar"></i><br>
												<p id="postulacion-2"><?php if(isset($postulado)){ ?>
													<?php echo date("d-m-Y", strtotime($postulado[0]['fecha_postulado'])); ?>
													<?php } ?></p>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<i class="postulacion-icono <?php if(date("Y-m-d H:i:s", strtotime($datos_plan[$o['id_ofertas']]['fecha_caducidad'])) <= date('Y-m-d H:i:s')){ echo 'cancelada'; }else{ echo 'icono-aprobado'; } ?> fa fa-spinner"></i><br>
												<p id="postulacion-2"><?php if(isset($o['tipo']) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ ?>
												<?php echo ucfirst(strtolower(Modelo_Oferta::ESTATUS_OFERTA[$o['resultado']])); ?>
												<?php } ?></p>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<i class="postulacion-icono <?php if(date("Y-m-d H:i:s", strtotime($datos_plan[$o['id_ofertas']]['fecha_caducidad'])) <= date('Y-m-d H:i:s')){ echo 'cancelada'; }else if(isset($cv_descargado) && $cv_descargado['cantd_descarga'] >= 1){ echo 'icono-aprobado'; }else{ echo 'icono-por-aprobar'; } ?> fa fa-file"></i><br>
												<p id="postulacion-2">CV Visto</p>
											</div>
											<div class="col-md-3 col-sm-3 col-xs-6">
												<i class="postulacion-icono <?php if(date("Y-m-d H:i:s", strtotime($datos_plan[$o['id_ofertas']]['fecha_caducidad'])) <= date('Y-m-d H:i:s')){ echo 'cancelada'; }else{ echo 'icono-por-aprobar'; } ?> fa fa-check"></i><br>
												<p id="postulacion-2">Finalizado</p>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div> --> 
					</div>
					<br>
	  		<?php }
			}else{ echo '<br><div class="breadcrumb">No hay resultados</div>'; } ?>
		</div>
		<div class="col-md-12">
			<?php echo $paginas; ?>
		</div>

		<div class="col-sm-12">
			<img class="auto-width" src="<?php echo PUERTO.'://'.HOST.'/imagenes/publicidad-micamello.png'; ?>">
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

<div class="modal fade" id="editar_Of" tabindex="-1" role="dialog" aria-labelledby="editar_Of" aria-hidden="true" data-backdrop="static">
	<div class="modal-dialog" role="document">    
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="black-text text-center"><b>Editar Ofertas</b></h3>                  
			</div>
			<form action = "<?php echo PUERTO."://".HOST;?>/vacantes/" method = "post" id="form_editar_Of" name="form_editar_Of">
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div id="des_of_error" class="form-group">
								<label class="">Descripci&oacute;n oferta: </label>&nbsp;<i>*</i><div id="descripcion_error" class="help-block with-errors"></div>
								<textarea id="des_of" rows="7" required name="des_of" class="form-control" style="resize: none;" onkeyup="validarDescripcion()"></textarea>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" name="guardarEdicion" id="guardarEdicion" value="1">
				<input type="hidden" name="idOferta" id="idOferta" value="<?php echo Utils::encriptar($o['id_ofertas']); ?>">
				<div class="modal-footer" style="text-align: center !important;">
					<button type="button" style="line-height: normal;" class="btn-red" id="btn-rojo" data-dismiss="modal">Cancelar</button>
					<input type="button" id="boton" name="boton" class="btn-light-blue" value="Guardar" onclick="enviarEdicion()"> 
				</div>
			</form>
		</div>    
	</div>
</div>