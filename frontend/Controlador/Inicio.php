<?php
class Controlador_Inicio extends Controlador_Base {
  
  public function construirPagina(){
    setcookie('preRegistro', null, -1, '/');    
    $arrarea = Modelo_Area::obtieneListado();  
    $divisible = round(count($arrarea)/12);
    $completar = ($divisible*12)-count($arrarea);
    $i = 1;
    foreach ($arrarea as $key => $a) {
      $arrarea[] = array('id_area'=>$a['id_area'],'nombre'=>$a['nombre'],'ico'=>$a['ico']);
      if($i == $completar){
        break;
      }
      $i++;
    }  
    $arrauspiciante = Modelo_Auspiciante::obtieneListado();        
    
    $tags = array('arrarea'=>$arrarea,                  
                  'arrauspiciante'=>$arrauspiciante,
                  'vista'=>'inicio');         
    $opcion = Utils::getParam('opcion','',$this->data);
    switch($opcion){
      case 'buscaCorreo':        
        $correo = Utils::getParam('correo', '', $this->data);
        $datocorreo = Modelo_Usuario::existeCorreo($correo);
        //Utils::log($datocorreo);
        Vista::renderJSON(array("respcorreo"=>$datocorreo));
      break;
      case 'buscaDni':
        $dni = Utils::getParam('dni', '', $this->data);
        $datodni = Modelo_Usuario::existeDni($dni);        
        Vista::renderJSON(array("respdni"=>$datodni));
      break;
      case 'quienesSomos':    
        Vista::render('quienesSomos', $tags);
      break;
      case 'preguntasfrecuentes':    
        $generales = Modelo_PreguntasFrecuentes::obtieneListado(0);   
        $candidatos = Modelo_PreguntasFrecuentes::obtieneListado(1);   
        $empresas = Modelo_PreguntasFrecuentes::obtieneListado(2);  
        
        $tags = array('generales'=>$generales,                  
                  'candidatos'=>$candidatos,
                  'empresas'=>$empresas, 'vista'=>'inicio'); 
        Vista::render('preguntasfrecuentes', $tags);
      break;
      case 'canea':    

        Vista::render('canea', $tags);
      break;
      case 'terminoscondiciones':
        $tags['vista'] = " ";
        $vista = 'documentos/terminos_condiciones_'.SUCURSAL_ID;
        Vista::render($vista, $tags);
      break;
      case 'politicaprivacidad':
        $tags['vista'] = " ";
        $vista = 'documentos/politica_privacidad_'.SUCURSAL_ID;
        Vista::render($vista, $tags);
      break;
      case 'politicacookie':
        $tags['vista'] = " ";
        $vista = 'documentos/politicacookie_'.SUCURSAL_ID;
        Vista::render($vista, $tags);
      break;
      case 'verificarCompra':  
        //$resultado = $this->verificaCompra();
        Vista::renderJSON(array("dato"=>$_SESSION['mfo_datos']['planActivar']));
      break;
      case 'searchKeyWord':
        $keyword = Utils::getParam('keywordInput', '', $this->data);
        $tipo = Utils::getParam('tipo', '', $this->data);
        $oferta = Utils::getParam('oferta', '', $this->data);
        $keyword = utf8_decode($keyword);
        $arrayWords = Utils::createListArrMul($keyword, $tipo, $oferta);
        Vista::renderJSON(array("returnWords"=>$arrayWords));
      break;
      case 'ofertaDetallada':
        $id_oferta = Utils::getParam('id', '', $this->data);

        $id_oferta = Utils::desencriptar($id_oferta);
        $arrayOferta = Modelo_Oferta::consultarOfertaId($id_oferta);

        $tags = array('arrayOferta'=>$arrayOferta);
         
        Vista::render('ofertaDetallada', $tags, '', '');
      break;
      default:            
        Vista::render('inicio', $tags);
      break;
    }
    
  }
}  
?>