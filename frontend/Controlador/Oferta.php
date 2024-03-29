<?php
class Controlador_Oferta extends Controlador_Base{
          
    public function construirPagina(){
      if (!Modelo_Usuario::estaLogueado()) {
          Utils::doRedirect(PUERTO . '://' . HOST . '/login/');
      }  
      if($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){ 
        Modelo_Usuario::validaPermisos($_SESSION['mfo_datos']['usuario']['tipo_usuario'],
                                       $_SESSION['mfo_datos']['usuario']['id_usuario'],
                                       (isset($_SESSION['mfo_datos']['usuario']['infohv'])) ? $_SESSION['mfo_datos']['usuario']['infohv'] : array(),
                                       $_SESSION['mfo_datos']['planes']); 
      }



      $opcion = Utils::getParam('opcion', '', $this->data); 
      $page = Utils::getParam('page', '1', $this->data);
      $type = Utils::getParam('type', '', $this->data); 
      $vista = Utils::getParam('vista', '', $this->data); 
      $postulacionesUserLogueado = array();
      $breadcrumbs = array();
      $aspirantesXoferta = '';

      $planes = array();
      if(isset($_SESSION['mfo_datos']['planes'])){
        $planes = $_SESSION['mfo_datos']['planes'];
      }else{
       array_push($planes, array('fecha_caducidad'=>'','num_rest'=>''));
      }

      if($opcion == 'vacantes'){
     
        unset($_SESSION['mfo_datos']['accesos']);
        unset($_SESSION['mfo_datos']['planSeleccionado']);
        $_SESSION['mfo_datos']['usuarioSeleccionado'] = array();
        $_SESSION['mfo_datos']['ultimaVistaActiva'] = $vista;
        $_SESSION['mfo_datos']['usuariosHabilitados'] = array();

        if(!empty($_SESSION['mfo_datos']['usuario']['tipo_usuario']) && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA && (empty($_SESSION['mfo_datos']['usuario']['id_cargo']) || empty($_SESSION['mfo_datos']['usuario']['nro_trabajadores']))){ 
          $_SESSION['mostrar_error'] = "Debe completar el perfil para continuar";
          Utils::doRedirect(PUERTO.'://'.HOST.'/perfil/');
        } 
      
      }

      if($vista == 'oferta'){        

        Modelo_Usuario::validaPermisos($_SESSION['mfo_datos']['usuario']['tipo_usuario'],$_SESSION['mfo_datos']['usuario']['id_usuario'],$_SESSION['mfo_datos']['usuario']['infohv'],$planes,$vista);
      }

      if(!isset($_SESSION['mfo_datos']['Filtrar_ofertas']) || $opcion == '' || $opcion == 'vacantes' || $opcion == 'cuentas'){
          $_SESSION['mfo_datos']['Filtrar_ofertas'] = array('A'=>0,'P'=>0,'J'=>0,'O'=>1,'S'=>0,'Q'=>0,'K'=>0);
      }
      
      $idUsuario = $_SESSION['mfo_datos']['usuario']['id_usuario'];
      $autopostulaciones_restantes['p_restantes'] = 0;
      $postulado = array();
      $subempresas = '';
      $ofertasSubempresas = array();

      $areasInteres = $cambioRes = false;
      $areas_subareas = array();
      if(isset($_SESSION['mfo_datos']['usuario']['usuarioxarea'])){
        $areasInteres = $_SESSION['mfo_datos']['usuario']['subareas']; 
        $areas_subareas = Modelo_AreaSubarea::obtieneAreas_subareas_usuario($idUsuario);
      }

      if(isset($_SESSION['mfo_datos']['usuario']['residencia']) && $_SESSION['mfo_datos']['usuario']['residencia'] == 0){
        $cambioRes = $_SESSION['mfo_datos']['usuario']['id_ciudad']; 
      }

      $arrarea      = Modelo_Area::obtieneListadoAsociativo();
      $arrprovincia = Modelo_Provincia::obtieneListadoAsociativo(SUCURSAL_PAISID);
      $arrjornadas  = Modelo_Jornada::obtieneListadoAsociativo();
      $datos_plan = Modelo_Oferta::obtenerPlanOferta(false);

      $enlaceCompraPlan = Vista::display('btnComprarPlan',array('presentarBtnCompra'=>$planes));            

      switch ($opcion) {
        case 'convertir':
          $idOferta = Utils::getParam('idOferta', '', $this->data);
          $tipo = Utils::getParam('tipo', '', $this->data);
          
          if($tipo == 1){
            $_SESSION['mfo_datos']['usuario']['ofertaConvertir'] = $idOferta;
          }else{
            unset($_SESSION['mfo_datos']['usuario']['ofertaConvertir']);
          }

        break;
        case 'convertirOferta':

          $idOferta = Utils::desencriptar($_SESSION['mfo_datos']['usuario']['ofertaConvertir']);
          if (Utils::getParam('convertirOferta') == 1) {
            $id_empresa_plan = Utils::desencriptar(Utils::getParam('planUsuario_convertir', '', $this->data));
            $datosOferta = Modelo_oferta::consultarOferta($idOferta);
            $datosOferta[0]['id_empresa_plan'] = $id_empresa_plan;

            $datosRequisitos = array('viajar'=>$datosOferta[0]['viajar'],'residencia'=>$datosOferta[0]['residencia'],'discapacidad'=>$datosOferta[0]['discapacidad'],'confidencial'=>$datosOferta[0]['confidencial'],'edad_minima'=>$datosOferta[0]['edad_minima'],'edad_maxima'=>$datosOferta[0]['edad_maxima']);
            if (!empty($datosOferta[0]['id_tipolicencia'])) {
              $datosRequisitos["id_tipolicencia"] = $datosOferta[0]['id_tipolicencia'];
            }
            
            unset($datos[0]['viajar'],$datos[0]['residencia'],$datos[0]['discapacidad'],$datos[0]['confidencial'],$datos[0]['edad_minima'],$datos[0]['edad_maxima']);
            self::convertirOferta($datosOferta[0],$datosRequisitos);
          }

        break;
        case 'buscaDescripcion':
          $idOferta = Utils::desencriptar(Utils::getParam('idOferta', '', $this->data));
          $resultado = Modelo_Oferta::consultarDescripcionOferta($idOferta);
          Vista::renderJSON($resultado);
        break;
        case 'buscaTitulo':

          $idOferta = Utils::getParam('idOferta', '', $this->data);
          $tipo = Utils::getParam('tipo', '', $this->data);

          $idOferta = (!empty($idOferta)) ? Utils::desencriptar($idOferta) : $idOferta; 

          if($tipo == 1){
            $_SESSION['mfo_datos']['usuario']['ofertaConvertir'] = Utils::encriptar($idOferta);
          }
          $resultado = Modelo_Oferta::consultarTituloOferta($idOferta);
          Vista::renderJSON($resultado);
        break;
        case 'filtrar':

          $array_empresas = Modelo_Usuario::obtieneSubempresasYplanes($idUsuario,$page,false,true);
          $empresas = array();

          foreach ($array_empresas as $key => $value) {
            $empresas[$value['id_empresa']] = $value['nombres'];
          }

          unset($this->data['mostrar'],$this->data['opcion'],$this->data['page'],$this->data['type'],$this->data['vista']);
          
          if($vista == 'oferta'){
            $autopostulaciones_restantes = Modelo_UsuarioxPlan::publicacionesRestantes($idUsuario);
            $breadcrumbs['oferta'] = 'Ofertas de empleo';
          }else if($vista == 'vacantes'){
            $breadcrumbs['vacantes'] = 'Mis Ofertas';
          }else if($vista == 'cuentas'){
            $breadcrumbs['cuentas'] = 'Ofertas subempresas';
          }else{
              $breadcrumbs['postulacion'] = 'Mis postulaciones';
          }
          $id_area = '';
          $id_provincia = '';
          $id_jornada = '';
          $cadena = '';
          $array_datos = array();
          $tipo_ordenamiento = 0;
          foreach ($this->data as $param => $value) {
            $letra = substr($value,0,1);
            $id = substr($value,1);

            $cadena .= '/'.$value;
            
            if(isset($_SESSION['mfo_datos']['Filtrar_ofertas'][$letra])){
              if($letra == 'A' && $type == 1){
                if(isset($arrarea[$id])){
                  $_SESSION['mfo_datos']['Filtrar_ofertas'][$letra] = $id;
                }
              }
              else if($letra == 'P' && $type == 1){
                if(isset($arrprovincia[$id])){
                  $_SESSION['mfo_datos']['Filtrar_ofertas'][$letra] = $id;
                }
              }
              else if($letra == 'J' && $type == 1){
                if(isset($arrjornadas[$id])){
                  $_SESSION['mfo_datos']['Filtrar_ofertas'][$letra] = $id;
                }
              }else if($letra == 'O' && $type == 1){
                $tipo_ordenamiento = substr($value,1,1);
                $_SESSION['mfo_datos']['Filtrar_ofertas'][$letra] = $id; 
              }
              else if($letra == 'S' && $type == 1){
                if(isset($empresas[$id])){
                  $_SESSION['mfo_datos']['Filtrar_ofertas'][$letra] = $id;
                } 
              }
              else if($letra == 'K' && $type == 1){
                
                if(isset(SALARIO[$id])){
                  $_SESSION['mfo_datos']['Filtrar_ofertas'][$letra] = $id; 
                }
              }
              else if($letra == 'Q' && $type == 1){
                $_SESSION['mfo_datos']['Filtrar_ofertas'][$letra] = $id;
              }else if($type == 2){
                $_SESSION['mfo_datos']['Filtrar_ofertas'][$letra] = 0;
              }
            }
          }

          foreach ($_SESSION['mfo_datos']['Filtrar_ofertas'] as $letra => $value) {

            if($value!=0 || $value != ''){

              if($letra == 'A'){
                  if(isset($arrarea[$value])){
                      $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrarea[$value]);
                  }
              }
              else if($letra == 'P'){
                  if(isset($arrprovincia[$value])){
                      $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrprovincia[$value]);
                  }
              }
              else if($letra == 'J'){
                  if(isset($arrjornadas[$value])){
                      $array_datos[$letra] = array('id'=>$value,'nombre'=>$arrjornadas[$value]);
                  }
              }
              else if($letra == 'S'){
                  if(isset($empresas[$value])){
                      $array_datos[$letra] = array('id'=>$value,'nombre'=>$empresas[$value]);
                  }
              }
              else if($letra == 'O'){
                  $array_datos[$letra] = array('id'=>$value,'nombre'=>$value);
              }
              else if($letra == 'K'){
                      
                if(isset(SALARIO[$value])){
                    $array_datos[$letra] = array('id'=>$value,'nombre'=>SALARIO[$value]);
                }
              }
              else if($letra == 'Q'){ 
                $array_datos[$letra] = array('id'=>$value,'nombre'=>htmlentities($value,ENT_QUOTES,'UTF-8'));
              }
            }
          }

          if($vista == 'cuentas'){
            $array_subempresas = array();
            $sub = $_SESSION['mfo_datos']['subempresas'];
            foreach ($sub as $key => $id) {
                array_push($array_subempresas, $key);
            }
            $idUsuario = implode(",", $array_subempresas);
            $array_empresas_hijas = $_SESSION['mfo_datos']['array_empresas_hijas'];
          }else{
            $array_empresas_hijas = array();
          }

          $filtros = $_SESSION['mfo_datos']['Filtrar_ofertas'];

          if(empty($filtros['A']) && empty($filtros['P']) && empty($filtros['J']) && empty($filtros['K']) && empty($filtros['S']) && empty($filtros['Q'])){

            if(isset($_POST['filtro'])){
              $_SESSION['mfo_datos']['filtro'] = $_POST['filtro'];
              Utils::doRedirect(PUERTO.'://'.HOST.'/cuentas/');
            }

            if(isset($_SESSION['mfo_datos']['filtro']) && $_SESSION['mfo_datos']['filtro'] == 0){
              $filtro = 1;
              $_SESSION['mfo_datos']['filtro'] = 0;
              $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,false,SUCURSAL_PAISID,$areasInteres,$cambioRes,$filtros);     

              //Para obtener la cantidad de registros totales de la consulta
              $registros = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,true,SUCURSAL_PAISID,$areasInteres,$cambioRes,$filtros); 

            }else{
              $filtro = 0;
              $_SESSION['mfo_datos']['filtro'] = 1;
              $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,false,SUCURSAL_PAISID,false,false,$filtros);

              //Para obtener la cantidad de registros totales de la consulta
              $registros = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,true,SUCURSAL_PAISID,false,false,$filtros);               
            }

          }else{

            $filtro = 0;
            $ofertas = Modelo_Oferta::filtrarOfertas($filtros,$page,$vista,$idUsuario,false,SUCURSAL_PAISID);

            //Para obtener la cantidad de registros totales de la consulta
            $registros = Modelo_Oferta::filtrarOfertas($filtros,$page,$vista,$idUsuario,true,SUCURSAL_PAISID);
          }
          
          $_SESSION['mfo_datos']['Filtrar_ofertas'] = $filtros;

          if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){
            $aspirantesXoferta = Modelo_Oferta::aspirantesXofertas();
          }

          $link = Vista::display('filtrarOfertas',array('data'=>$array_datos,'page'=>$page,'vista'=>$vista));  

          $tags = array(
            'breadcrumbs'=>$breadcrumbs,
            'arrarea'       => $arrarea,
            'arrprovincia'  => $arrprovincia,
            'jornadas'      => $arrjornadas,
            'ofertas'       => $ofertas,
            'enlaceCompraPlan'=>$enlaceCompraPlan,
            'autopostulaciones_restantes'=>$autopostulaciones_restantes,
            'link'=>$link,
            'vista'=>$vista,
            'filtro'=>$filtro,
            'aspirantesXoferta'=>$aspirantesXoferta,
            'array_empresas_hijas'=>$array_empresas_hijas,
            'areas_subareas'=>$areas_subareas,
            'datos_plan'=>$datos_plan,
            'tipo_ordenamiento'=>$tipo_ordenamiento
          );

          if($vista != 'vacantes' && $vista != 'cuentas'){
              $tags["show_banner"] = 1;
          }
          
          $tags["template_js"][] = "tinymce/tinymce.min";
          $tags["template_js"][] = "oferta";
          $url = PUERTO.'://'.HOST.'/'.$vista.'/'.$type.$cadena;

          $pagination = new Pagination(count($registros),REGISTRO_PAGINA,$url);
          
          $pagination->setPage($page);
          $tags['paginas'] = $pagination->showPage();
          Vista::render('ofertas', $tags);
        break;
        case 'detalleOferta':
          //solo candidatos 
          if (($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) && (!isset($_SESSION['mfo_datos']['planes']) || !Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'verOfertaTrabajo'))){

            $_SESSION['mostrar_error'] = "Debe subscribirse a un plan para poder postularse a las ofertas.";
            Utils::doRedirect(PUERTO.'://'.HOST.'/planes/'); 
          }
          
          $idOferta = Utils::getParam('id', '', $this->data);
          $status = Utils::getParam('status', '', $this->data);
          $tipo = Utils::getParam('tipo', '', $this->data);
          
          $idOferta = Utils::desencriptar($idOferta);
          $aspiracion = Utils::getParam('aspiracion', '', $this->data);

          if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::EMPRESA){
            $subempresas = $_SESSION['mfo_datos']['subempresas']; 
            $array_subempresas = array();
            if (!empty($subempresas)){
              foreach ($subempresas as $key => $id) {
                array_push($array_subempresas, $key);
              }

              if(!empty($array_subempresas)){
                $idUsuario = $idUsuario.",".implode(",", $array_subempresas);
              }
            }
          }
 
          $licencias = Modelo_TipoLicencia::obtieneListadoAsociativo();
          $oferta = Modelo_Oferta::obtieneOfertas($idOferta,$page,$vista,$idUsuario,false,SUCURSAL_PAISID);         
          if (Utils::getParam('postulado') == 1) {          
            if(!empty($status) && $tipo == 2){
              self::guardarEstatus($idUsuario,$idOferta,$status);   
              Utils::doRedirect(PUERTO.'://'.HOST.'/postulacion/');                       
            }else if($tipo == 1){
              if(strlen($aspiracion) > 0 && strlen($aspiracion) <= 5){
                self::guardarPostulacion($idUsuario,$idOferta,$aspiracion,$vista);
                Utils::doRedirect(PUERTO.'://'.HOST.'/postulacion/'); 
              }else if(strlen($aspiracion) > 5){
                $_SESSION['mostrar_error'] = "La aspiraci\u00f3n salarial debe máximo de 5 dígitos";
              }else{
                $_SESSION['mostrar_error'] = "La aspiraci\u00f3n salarial debe ser mayor a 0";
              }
            }else{
              if($tipo == 1){
                $_SESSION['mostrar_error'] = "Debe colocar una aspiraci\u00f3n salarial";
              }
              if($tipo == 2){
                $_SESSION['mostrar_error'] = "Debe seleccionar un estatus";
                $postulado = Modelo_Postulacion::obtienePostuladoxUsuario($idUsuario,$idOferta);
              }
            }
          }else{
          
            if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO){
               $postulado = Modelo_Postulacion::obtienePostuladoxUsuario($idUsuario,$idOferta);
            }
          }
          
          $breadcrumbs[$vista] = 'Ofertas';
          $breadcrumbs['detalleOferta'] = 'Ver detalle';          
          $tags = array(
            'breadcrumbs'=>$breadcrumbs,
            'oferta'=> $oferta,
            'postulado'=>$postulado,
            'autopostulaciones_restantes'=>$autopostulaciones_restantes,
            'vista'=>$vista,
            'licencias'=>$licencias,
            'datos_plan'=>$datos_plan,
            'status'=>$status,
            'aspiracion'=>$aspiracion
          );
          
          $tags["show_banner"] = 1;
          $tags["template_js"][] = "oferta";
          
          Vista::render('detalle_oferta', $tags);
        break;
        case 'vacantes':          
          $vista = $opcion;

          //solo empresas
          if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::EMPRESA ){
            Utils::doRedirect(PUERTO.'://'.HOST.'/'); 
          }
          
          if (Utils::getParam('guardarEdicion') == 1) {
            $idOferta = Utils::desencriptar(Utils::getParam('idOferta', '', $this->data));
            self::guardarDescripcion($idOferta);
            Utils::doRedirect(PUERTO . '://' . HOST . '/vacantes/');
          }

          $aspirantesXoferta = Modelo_Oferta::aspirantesXofertas();

          $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,false,SUCURSAL_PAISID);     
          $registros = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,true,SUCURSAL_PAISID);

          $planes = array();
          if(isset($_SESSION['mfo_datos']['planes'])){
            $planes = $_SESSION['mfo_datos']['planes'];
          }else{
            array_push($planes, array('fecha_caducidad'=>'','num_rest'=>''));
          }

          $breadcrumbs['vacantes'] = 'Mis Ofertas';

          $tags = array(
            'breadcrumbs'=>$breadcrumbs,
            'arrarea'       => $arrarea,
            'arrprovincia'  => $arrprovincia,
            'jornadas'      => $arrjornadas,
            'ofertas'       => $ofertas,
            'page' => $page,
            'vista'=>$vista,
            'ofertasSubempresas' => $ofertasSubempresas,
            'aspirantesXoferta'=>$aspirantesXoferta,
            'enlaceCompraPlan'=>$enlaceCompraPlan,
            'datos_plan'=>$datos_plan
          );
          
          $tags["template_js"][] = "tinymce/tinymce.min";
          $tags["template_js"][] = "oferta";
          
          $url = PUERTO.'://'.HOST.'/'.$vista;
          $pagination = new Pagination(count($registros),REGISTRO_PAGINA,$url);
          $pagination->setPage($page);
          $tags['paginas'] = $pagination->showPage();
          
          Vista::render('ofertas', $tags);
        break;
        case 'cuentas':
          $vista = $opcion;

          //solo empresas
          $subempresas = $_SESSION['mfo_datos']['subempresas']; 
          $array_subempresas = array();
          foreach ($subempresas as $key => $id) {
            array_push($array_subempresas, $key);
          }

          if(!empty($array_subempresas)){
            $subempresas = implode(",", $array_subempresas);
          } 
          
          if ($subempresas == '') {
            Utils::doRedirect(PUERTO . '://' . HOST . '/vacantes/');
          }

          $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$subempresas,false,SUCURSAL_PAISID);

          //Para obtener la cantidad de registros totales de la consulta
          $cantidad_ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$subempresas,true,SUCURSAL_PAISID);

          $array_empresas_hijas = array();
          foreach ($cantidad_ofertas as $key => $value) {
            if (!isset($array_empresas_hijas[$value['id_usuario']])){
              $array_empresas_hijas[$value['id_usuario']] = $value['nombres'];
            }
          }

          $_SESSION['mfo_datos']['array_empresas_hijas'] = $array_empresas_hijas;

          $aspirantesXoferta = Modelo_Oferta::aspirantesXofertas();

          $breadcrumbs['cuentas'] = 'Ofertas subempresas';

          $tags = array(
            'breadcrumbs'=>$breadcrumbs,
            'arrarea'       => $arrarea,
            'arrprovincia'  => $arrprovincia,
            'jornadas'      => $arrjornadas,
            'ofertas'       => $ofertas,
            'page' => $page,
            'vista'=>$vista,
            'aspirantesXoferta'=>$aspirantesXoferta,
            'array_empresas_hijas'=>$array_empresas_hijas,
            'datos_plan'=>$datos_plan
          );
          
          $tags["template_js"][] = "tinymce/tinymce.min";
          $tags["template_js"][] = "oferta";
          
          $url = PUERTO.'://'.HOST.'/'.$vista;
          $pagination = new Pagination(count($cantidad_ofertas),REGISTRO_PAGINA,$url);
          $pagination->setPage($page);
          $tags['paginas'] = $pagination->showPage();
          
          Vista::render('ofertas', $tags);
        break;
        default:             
          //solo candidatos 
          if ($_SESSION['mfo_datos']['usuario']['tipo_usuario'] != Modelo_Usuario::CANDIDATO){
            Utils::doRedirect(PUERTO.'://'.HOST.'/');               
          }

          $eliminarPostulacion = Utils::desencriptar(Utils::getParam('eliminarPostulacion', '', $this->data));
          $empresa = Utils::desencriptar(Utils::getParam('empresa', '', $this->data));

          if(!empty($eliminarPostulacion)){
            $tiempo = Modelo_Parametro::obtieneValor('eliminar_postulacion');
            if(!empty($empresa)){
              $tipo_post = 1;
              $r = Modelo_Postulacion::postAutoxIdPostAeliminar($_SESSION['mfo_datos']['usuario']['id_usuario'],$empresa,$tiempo);
            }else{
              $tipo_post = 2;
              $r = array();
            }

            if(!empty($r['ids_postulaciones'])){
              $resultado = Modelo_Postulacion::eliminarPostulacion($r['ids_postulaciones'],$tipo_post);
              if(empty($resultado)){
                $_SESSION['mostrar_error'] = 'No se pudo eliminar la postulaci\u00f3n, intente de nuevo1';
              }else{
                Modelo_EmpresaBloq::insertEmpresa($_SESSION['mfo_datos']['usuario']['id_usuario'],$empresa);
                  self::devolverPostulaciones(explode(",",$r['ids_usuariosplanes']));
                  $_SESSION['mostrar_exito'] = 'Se ha eliminado la postulaci\u00f3n exitosamente';
                  Utils::doRedirect(PUERTO.'://'.HOST.'/'.$vista.'/');
              }
            }else{

              if($tipo_post == 1){
                 $_SESSION['mostrar_error'] = 'No se pudo eliminar la postulaci\u00f3n, Ya pasaron las '.$tiempo.' horas de postulado.';
              }else{
                $resultado = Modelo_Postulacion::eliminarPostulacion($eliminarPostulacion,$tipo_post);
                if(empty($resultado)){
                    $_SESSION['mostrar_error'] = 'No se pudo eliminar la postulaci\u00f3n, intente de nuevo';
                }else{                    
                  $_SESSION['mostrar_exito'] = 'Se ha eliminado la postulaci\u00f3n exitosamente';
                  Utils::doRedirect(PUERTO.'://'.HOST.'/'.$vista.'/');
                }
              }
            }
          }

          if($vista == 'oferta'){
            if(isset($_POST['filtro'])){
              $_SESSION['mfo_datos']['filtro'] = $_POST['filtro'];
              Utils::doRedirect(PUERTO.'://'.HOST.'/oferta/');
            }                     

            if(isset($_SESSION['mfo_datos']['filtro']) && $_SESSION['mfo_datos']['filtro'] == 0){
              $filtro = 1;
              $_SESSION['mfo_datos']['filtro'] = 0;
              $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,false,SUCURSAL_PAISID,$areasInteres,$cambioRes);     
              $arrayPermKeys = array("titulo","salario","a_convenir","empresa","jornada","ciuidad","provincia");
              //Para obtener la cantidad de registros totales de la consulta
              $registros = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,true,SUCURSAL_PAISID,$areasInteres,$cambioRes);                
            }else{
              $filtro = 0;
              $_SESSION['mfo_datos']['filtro'] = 1;
              $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,false,SUCURSAL_PAISID);

              //Para obtener la cantidad de registros totales de la consulta
              $registros = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,true,SUCURSAL_PAISID); 
            }
          }
          
          if($vista != 'postulacion'){             
            $autopostulaciones_restantes = Modelo_UsuarioxPlan::publicacionesRestantes($idUsuario);
            $breadcrumbs['oferta'] = 'Ofertas de empleo';
          }else{   
            $filtro = 0;        
            $ofertas = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,false,SUCURSAL_PAISID);         
            //Para obtener la cantidad de registros totales de la consulta
            $registros = Modelo_Oferta::obtieneOfertas(false,$page,$vista,$idUsuario,true,SUCURSAL_PAISID);             
            $breadcrumbs['postulacion'] = 'Mis postulaciones';
          }

          $tags = array(
            'breadcrumbs'=>$breadcrumbs,
            'arrarea'       => $arrarea,
            'arrprovincia'  => $arrprovincia,
            'jornadas'      => $arrjornadas,
            'ofertas'       => $ofertas,
            'enlaceCompraPlan'=>$enlaceCompraPlan,
            'autopostulaciones_restantes'=>$autopostulaciones_restantes,
            'page' => $page,
            'filtro'=>$filtro,
            'areas_subareas'=>$areas_subareas,
            'vista'=>$vista,
            'datos_plan'=>$datos_plan
          );
          $tags["template_js"][] = "tinymce/tinymce.min";
          $tags["template_js"][] = "oferta";
          $tags["show_banner"] = 1;
          
          $url = PUERTO.'://'.HOST.'/'.$vista; 

          $pagination = new Pagination(count($registros),REGISTRO_PAGINA,$url);
          $pagination->setPage($page);
          $tags['paginas'] = $pagination->showPage();
          Vista::render('ofertas', $tags);
        break;
      }
    }

    public function guardarDescripcion($idOferta){
      try{

        $GLOBALS['db']->beginTrans();
        if (!Modelo_Oferta::guardarDescripcion($idOferta,str_replace('"', "'", $_POST['des_of']))) {
            throw new Exception("Ha ocurrido un error al guardar la descripci\u00F3n, intente nuevamente");
        }
        $GLOBALS['db']->commit();
        $tiempo = Modelo_Parametro::obtieneValor('tiempo_espera');
        $_SESSION['mostrar_exito'] = 'La descripci\u00f3n fue editada exitosamente, debe esperar un m\u00E1ximo de '.$tiempo.' horas para que el administrador apruebe el nuevo contenido.';
      }catch (Exception $e) {
          $_SESSION['mostrar_error'] = $e->getMessage();
          $GLOBALS['db']->rollback();
      }
    }

    public function guardarPostulacion($id_usuario,$id_oferta,$aspiracion,$vista){
      try{
        $GLOBALS['db']->beginTrans();
        if (isset($_SESSION['mfo_datos']['planes']) && Modelo_PermisoPlan::tienePermiso($_SESSION['mfo_datos']['planes'], 'postulacion') && $_SESSION['mfo_datos']['usuario']['tipo_usuario'] == Modelo_Usuario::CANDIDATO) {

            if(!Utils::validarNumeros($aspiracion)){
              throw new Exception("No se admiten caracteres especiales, intente nuevamente");
            }
            
            if (!Modelo_Postulacion::postularse($id_usuario,$id_oferta,$aspiracion)) {
                throw new Exception("Ha ocurrido un error la postulaci\u00f3n, intente nuevamente");
            }
            $GLOBALS['db']->commit();
            $_SESSION['mostrar_exito'] = 'Se ha postulado a esta oferta exitosamente';
            $this->redirectToController('oferta');
        }else{
            $_SESSION['mostrar_error'] = "No tiene permiso para postularse, contrate un plan"; 
            $this->redirectToController('detalleOferta/'.$vista.'/'.Utils::encriptar($id_oferta));
        }
      }catch (Exception $e) {
          $_SESSION['mostrar_error'] = $e->getMessage();
          $GLOBALS['db']->rollback();
          $this->redirectToController('detalleOferta/'.$vista.'/'.Utils::encriptar($id_oferta)); 
      }
    }

    public function guardarEstatus($id_usuario,$id_oferta,$resultado){
      try{

        $GLOBALS['db']->beginTrans();
        if (!Modelo_Postulacion::cambiarEstatus($id_usuario,$id_oferta,$resultado)) {
            throw new Exception("Ha ocurrido un error en el cambio de estado, intente nuevamente");
        }
        $GLOBALS['db']->commit();
        $_SESSION['mostrar_exito'] = 'El estado de la oferta fue editado exitosamente';
      }catch (Exception $e) {
          $_SESSION['mostrar_error'] = $e->getMessage();
          $GLOBALS['db']->rollback();
      }
    }

    public static function devolverPostulaciones($ids_planes){
      foreach ($ids_planes as $key => $id_plan_usuario) {
        Modelo_UsuarioxPlan::sumarPublicaciones($id_plan_usuario);
      }
    }

    public static function convertirOferta($datos,$datos_requisitos){
      
      $oferta_ant = $datos['id_ofertas'];
      try{

        $GLOBALS['db']->beginTrans();
        $datos_area_subarea = explode(",",$datos['id_areas_subareas']);
        unset($datos['id_ofertas'],$datos['id_areas_subareas']);

        $datos_oferta_idiomas = explode(",",$datos['id_nivelIdioma_idioma']);
        unset($datos['id_ofertas'],$datos['id_nivelIdioma_idioma']);
        
        //desactivar oferta anterior
        if(!Modelo_Oferta::desactivarOferta($oferta_ant)){
          throw new Exception("Ha ocurrido un error. Intente nuevamente 1");
        }

        if(!Modelo_Oferta::guardarRequisitosOferta($datos_requisitos)){
          throw new Exception("Ha ocurrido un error al guardar los requisitos de la oferta");
        }

        $datos['estado'] = 1;

        $fecha_actual = date('Y-m-d H:m:s');
        $datos['fecha_creado'] = $fecha_actual;
        $datos['fecha_actualizado'] = $fecha_actual;
        $dias_totales = (int)OFERTA_ACTIVA_DESCARGA + (int)OFERTA_ACTIVA_VER;
        $fecha_caducidad = strtotime ( '+'.($dias_totales-1).' day' , strtotime ( $fecha_actual) ) ;
        $fecha_caducidad = date ( 'Y-m-d H:m:s' , $fecha_caducidad );
        $datos['fecha_caducidad'] = $fecha_caducidad;
        $datos['id_requisitoOferta'] = $GLOBALS['db']->insert_id();

        //Insertar el nuevo registro de la oferta con el id_empresa_plan actualizado
        if(!Modelo_Oferta::guardarOfertaConvertida($datos)){
          throw new Exception("Ha ocurrido un error. Intente nuevamente 2");
        }
        $id_oferta_nueva = $GLOBALS['db']->insert_id(); 
      
        if(!Modelo_OfertaxAreaSubarea::guardarOfertaAreasSubareas($id_oferta_nueva, $datos_area_subarea)){
          throw new Exception("Ha ocurrido un error al guardar las subareas de la oferta");
        }

        if(!Modelo_OfertaxNivelIdioma::guardarOfertaNivelIdioma($id_oferta_nueva, $datos_oferta_idiomas)){
          throw new Exception("Ha ocurrido un error al guardar los idiomas de la oferta");
        }

        //Restar el numero de publicaciones del plan seleccionado
        $plan_seleccionado = Modelo_UsuarioxPlan::consultarRecursosAretornar($datos['id_empresa_plan']);
        if(!Modelo_UsuarioxPlan::restarPublicaciones($datos['id_empresa_plan'], $plan_seleccionado['num_publicaciones_rest'], Modelo_Usuario::EMPRESA)){
          throw new Exception("Ha ocurrido un error. Intente nuevamente 3");
        } 

        //Mover a los postulados de la oferta anterior a la nueva
        if(!Modelo_Postulacion::transladarCandidatos($oferta_ant,$id_oferta_nueva)){
          throw new Exception("Ha ocurrido un error. Intente nuevamente 4");
        }

        $GLOBALS['db']->commit();
        $_SESSION['mostrar_exito'] = 'La oferta fue convertida exitosamente.';
        $datoOfertaNueva = Modelo_Oferta::ofertaPostuladoPor($id_oferta_nueva)['id_ofertas'];
        unset($_SESSION['mfo_datos']['usuario']['ofertaConvertir']);
        $enlace = PUERTO.'://'.HOST.'/verAspirantes/1/'.Utils::encriptar($datoOfertaNueva).'/1/';
      }catch (Exception $e) {
        $enlace = PUERTO.'://'.HOST.'/verAspirantes/1/'.Utils::encriptar($oferta_ant).'/1/';
        $_SESSION['mostrar_error'] = $e->getMessage();
        $GLOBALS['db']->rollback();
      }
      Utils::doRedirect($enlace);
    }
}
?>