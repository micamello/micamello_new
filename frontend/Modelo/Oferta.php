<?php 
class Modelo_Oferta{

  const ESTATUS_OFERTA = array('1'=>'CONTRATADO','2'=>'NO CONTRATADO','3'=>'EN PROCESO');
  const ACTIVA = 1;
  const INACTIVA = 0;
  const PORAPROBAR = 2;
  const DENTRODELTIEMPO = 3;
  //const SOLOVER = 4;
  
  public static function obtieneNumero($pais){
    if (empty($pais)){ return false; }
    $sql = "SELECT COUNT(1) AS cont FROM mfo_oferta o
            INNER JOIN mfo_ciudad c ON c.id_ciudad = o.id_ciudad
            INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
            WHERE o.estado = 1 AND p.id_pais = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($pais));
    return (!empty($rs['cont'])) ? $rs['cont'] : 0;
  }
  
  public static function obtieneNroArea($area){
    $sql = "SELECT COUNT(id_ofertas) AS cont FROM mfo_oferta where id_area = ?";
    $rs = $GLOBALS['db']->auto_array($sql,array($area));
    return (!empty($rs['cont'])) ? $rs['cont'] : 0;
  }

  // copy of function down
  public static function obtieneOfertas1($idempresa,$sucursal, $tipo_usuario){
    $sql1 = "";
    if($tipo_usuario == 2){$sql1 = " AND e.id_empresa = ".$idempresa." ";}
    $sql = "SELECT o.titulo, c.nombre, p.nombre, o.estado, o.descripcion, e.nombres, e.id_empresa FROM mfo_empresa e left join mfo_oferta o ON e.id_empresa = o.id_empresa left join mfo_ciudad c ON o.id_ciudad = c.id_ciudad  left join mfo_provincia p ON c.id_provincia = p.id_provincia AND o.estado = 1 ".$sql." AND p.id_pais = ".$sucursal.";";
    $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    return $rs;
  }

  public static function obtieneOfertas($id=false,$page=false,$vista=false,$idusuario=false,$obtCantdRegistros=false,$pais_empresa,$areasInteres=false,$cambioRes=false,&$filtros=false){

    $sql = "SELECT ";
    if($obtCantdRegistros == false){
        $sql .= "o.id_ofertas, o.estado, o.fecha_actualizado, o.titulo, o.descripcion, o.salario, o.primer_empleo, o.a_convenir,o.fecha_contratacion,o.vacantes,o.anosexp, o.tipo AS tipo_oferta, j.nombre AS jornada, p.nombre AS provincia, c.nombre AS ciudad, e.descripcion AS escolaridad, r.confidencial,r.discapacidad,r.residencia, r.edad_maxima,
      r.edad_minima, IF(o.id_tipolicencia IS NULL,0,o.id_tipolicencia) AS licencia, r.viajar,ul.username, GROUP_CONCAT(DISTINCT(os.id_areas_subareas)) AS subareas";
      if (!empty($vista) && ($vista == 'postulacion')){ 
        $tiempo = Modelo_Parametro::obtieneValor('eliminar_postulacion');
         $sql .= ", pos.tipo, pos.id_auto as id_postulacion, pos.resultado, u.id_usuario, emp.nombres AS empresa, emp.id_empresa AS id_empresa, emp.foto, IF(TIMESTAMPDIFF(MINUTE, pos.fecha_postulado,now()) <= ".($tiempo*60).",1,0) as puedeEliminar";
      }else{
        $sql .= ", emp.nombres AS empresa, emp.id_empresa AS id_usuario, emp.foto";
      }
      if(!empty($id)){
         $sql .= ", GROUP_CONCAT(DISTINCT(ni.id_nivelIdioma_idioma)) AS idiomas";
      }
    }else{
      $sql .= "emp.id_empresa AS id_usuario, emp.nombres, emp.foto";
    }

    $tiempo_ofertaUrgente = Modelo_Parametro::obtieneValor('tiempo_ofertaUrgente');
    $sql .= ", IF(TIMESTAMPDIFF(MINUTE, o.fecha_actualizado,now()) <= ".($tiempo_ofertaUrgente*60)." && o.tipo = 1,1,0) as orden_urgente";

    $sql .= " FROM mfo_oferta o, mfo_requisitooferta r, mfo_escolaridad e, mfo_jornada j, mfo_ciudad c, mfo_provincia p, mfo_usuario_login ul, mfo_empresa emp, mfo_oferta_subareas os";
    if(!empty($vista) && ($vista == 'postulacion')){
      $sql .= ", mfo_postulacion pos, mfo_usuario u";
    }
    if(!empty($id)){
      $sql .= ", mfo_oferta_nivelidioma ofn, mfo_nivelidioma_idioma ni";
    }
    $sql .= " WHERE r.id_requisitoOferta = o.id_requisitoOferta
    AND e.id_escolaridad = o.id_escolaridad
    AND c.id_ciudad = o.id_ciudad
    AND p.id_provincia = c.id_provincia
    AND os.id_ofertas = o.id_ofertas
    AND j.id_jornada = o.id_jornada
    AND p.id_pais = ".$pais_empresa;
    if(!empty($vista) && ($vista == 'vacantes' || $vista == 'cuentas')){
      $sql .= " AND (o.estado = 1 OR o.estado = 2 OR o.estado = 3) AND o.id_empresa IN(".$idusuario.")";
    }else if(!empty($vista) && $vista == 'postulacion'){
      //$sql .= " AND (o.estado <> 2) ";
    }else{
      $sql .= " AND o.estado = 1 ";
    }
    
    $sql .= " AND o.id_empresa = emp.id_empresa AND ul.id_usuario_login = emp.id_usuario_login";
    if(!empty($id)){
       $sql .= " AND ni.id_nivelIdioma_idioma = ofn.id_nivelIdioma_idioma
      AND ofn.id_ofertas = o.id_ofertas AND o.id_ofertas = ".$id;
    }
    if(!empty($vista) && ($vista == 'postulacion')){
      $sql .= " AND pos.id_usuario = u.id_usuario AND pos.id_ofertas = o.id_ofertas AND pos.id_usuario = ".$idusuario;
    }
    
    if (!empty($vista) && ($vista != 'postulacion')){ 
      if($areasInteres != false){
        $sql .= " AND os.id_areas_subareas IN(".$areasInteres.")"; 
      }

      if($cambioRes != false){
        $sql .= " AND c.id_ciudad = ".$cambioRes; 
      }
    }

    $sql .= ' GROUP BY o.id_ofertas';
    if($obtCantdRegistros == false){

      if($filtros != false){
        
        $tipo = substr($filtros['O'],0,1);
        $t = substr($filtros['O'],1,2);
        if($tipo == 1){
          if($t == 1){
            $filtros['O'] = 2;
            $sql .= " ORDER BY o.salario ASC";
          }
          if($t == 2){
            $filtros['O'] = 1;
            $sql .= " ORDER BY o.salario DESC";
          }
          
        }else if($tipo == 2){
          if($t == 1){
            $filtros['O'] = 2;
            $sql .= " ORDER BY o.fecha_actualizado ASC";
          }
          if($t == 2){
            $filtros['O'] = 1;
            $sql .= " ORDER BY o.fecha_actualizado DESC";
          }
        }
        
      }else{

        if(!empty($vista) && ($vista == 'postulacion')){ 
          $sql .= " ORDER BY pos.tipo ASC";
        }else{
          $sql .= " ORDER BY orden_urgente DESC,o.fecha_actualizado DESC";
        }
      }

      $page = ($page - 1) * REGISTRO_PAGINA;
      $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA; 

    }else{
      if(!empty($vista) && ($vista == 'postulacion')){ 
        $sql .= " ORDER BY pos.tipo ASC";
      }else{
        $sql .= " ORDER BY orden_urgente DESC,o.fecha_actualizado DESC";
      }
    }
    
    $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    return $rs;
  }

  public static function filtrarOfertas(&$filtros,$page,$vista=false,$idusuario=false,$obtCantdRegistros=false,$pais_empresa){
    
    $sql = "SELECT ";
    if($obtCantdRegistros == false){
      $sql .= "o.id_ofertas, o.fecha_actualizado, o.titulo, o.descripcion, o.salario,o.a_convenir,o.primer_empleo, o.fecha_contratacion,o.vacantes,o.anosexp, o.tipo AS tipo_oferta, j.nombre AS jornada, p.nombre AS provincia, c.nombre AS ciudad, e.descripcion AS escolaridad, r.confidencial,r.discapacidad,r.residencia, r.edad_maxima,r.edad_minima, IF(o.id_tipolicencia IS NULL,0,o.id_tipolicencia) AS licencia, r.viajar, ul.username";
      if (!empty($vista) && ($vista == 'postulacion')){ 
        $tiempo = Modelo_Parametro::obtieneValor('eliminar_postulacion');
        $sql .= ", pos.tipo, pos.id_auto AS id_postulacion, pos.resultado, u.id_usuario, emp.nombres AS empresa, emp.id_empresa AS id_empresa, , emp.foto, IF(TIMESTAMPDIFF(MINUTE, pos.fecha_postulado,now()) <= ".($tiempo*60).",1,0) as puedeEliminar";
      }else{
        $sql .= ", emp.nombres AS empresa, emp.id_empresa AS id_usuario, emp.foto";
      }
    }else{
      $sql .= "emp.id_empresa AS id_usuario, emp.nombres, emp.foto";
    }

    $tiempo_ofertaUrgente = Modelo_Parametro::obtieneValor('tiempo_ofertaUrgente');
    $sql .= ", IF(TIMESTAMPDIFF(MINUTE, o.fecha_actualizado,now()) <= ".($tiempo_ofertaUrgente*60)." && o.tipo = 1,1,0) as orden_urgente";

    $sql .= " FROM mfo_oferta o, mfo_requisitooferta r, mfo_escolaridad e, mfo_jornada j, mfo_ciudad c, mfo_provincia p, mfo_usuario_login ul, mfo_empresa emp";
    if(!empty($vista) && ($vista == 'postulacion')){
      $sql .= ", mfo_postulacion pos, mfo_usuario u";
    }
    $sql .= " WHERE r.id_requisitoOferta = o.id_requisitoOferta
    AND e.id_escolaridad = o.id_escolaridad
    AND c.id_ciudad = o.id_ciudad
    AND p.id_provincia = c.id_provincia
    AND j.id_jornada = o.id_jornada 
    AND p.id_pais = ".$pais_empresa;
    if(!empty($filtros['P']) && $filtros['P'] != 0){
       $sql .= " AND p.id_provincia = ".$filtros['P'];
    }
    
    if(!empty($filtros['A']) && $filtros['A'] != 0){

      $sql2 = "SELECT GROUP_CONCAT(DISTINCT(o.id_ofertas)) AS ids FROM mfo_oferta_subareas o
          INNER JOIN mfo_area_subareas a on o.id_areas_subareas = a.id_areas_subareas
          WHERE a.id_area = ".$filtros['A'];
      $ofertas = $GLOBALS['db']->auto_array($sql2,array(),false);

      if(!empty($ofertas)){
        $sql .= ' AND o.id_ofertas IN('.$ofertas['ids'].')';
      }
    }
    if(!empty($filtros['J']) && $filtros['J'] != 0){
      $sql .= " AND j.id_jornada = ".$filtros['J'];
    }
    if(!empty($filtros['K']) && $filtros['K'] != 0){
      if($filtros['K'] == 1){
        $sql .= " AND o.salario < 394";
      }

      if($filtros['K'] == 2){
        $sql .= " AND o.salario between '394' and '700'";
      }

      if($filtros['K'] == 3){
        $sql .= " AND o.salario between '700' and '1200'";
      }

      if($filtros['K'] == 4){
        $sql .= " AND o.salario >= 1200";
      }
    }
    if(!empty($filtros['S']) && $filtros['S'] != 0){
      $sql .= " AND emp.id_empresa = ".$filtros['S'];
    }
    if(!empty($filtros['Q']) && $filtros['Q'] != 0 || $filtros['Q'] != ''){
      $pos = strpos($filtros['Q'], "-");
      if ($pos != false) {
        $datos_fecha = explode("-",$filtros['Q']);
        if(count($datos_fecha) == 3 && checkdate($datos_fecha[1], $datos_fecha[2], $datos_fecha[0])){
            $pclave = $datos_fecha[0].'-'.$datos_fecha[1].'-'.$datos_fecha[2];
        }else if(count($datos_fecha) == 3 && checkdate($datos_fecha[1], $datos_fecha[0], $datos_fecha[2])){
            $pclave = $datos_fecha[2].'-'.$datos_fecha[1].'-'.$datos_fecha[0];
        }
      }else{
        $pclave = $filtros['Q'];
      }

      $sql .= " AND (emp.nombres LIKE '%".htmlentities($pclave,ENT_QUOTES,'UTF-8')."%' OR o.titulo LIKE '%".htmlentities($pclave,ENT_QUOTES,'UTF-8')."%' OR o.descripcion LIKE '%".htmlentities($pclave,ENT_QUOTES,'UTF-8')."%' OR o.fecha_contratacion LIKE '%".$pclave."%')";
    }
    if(!empty($vista) && ($vista == 'postulacion')){
      $sql .= " AND pos.id_usuario = u.id_usuario AND pos.id_ofertas = o.id_ofertas AND pos.id_usuario = ".$idusuario;
    }else if(!empty($vista) && ($vista == 'vacantes' || $vista == 'cuentas')){
      $sql .= " AND (o.estado = 1 OR o.estado = 2 OR o.estado = 3) AND o.id_empresa IN(".$idusuario.")";
    }else{
      $sql .= " AND o.estado = 1";
    }
    $sql .= " AND o.id_empresa = emp.id_empresa AND ul.id_usuario_login = emp.id_usuario_login";

    $sql .= ' GROUP BY o.id_ofertas';

    if(!empty($filtros['O']) && $filtros['O'] != 0){
      $tipo = substr($filtros['O'],0,1);
      $t = substr($filtros['O'],1,2);
      if($tipo == 1){
        if($t == 1){
          $filtros['O'] = 2;
          $sql .= " ORDER BY o.salario ASC";
        }
        if($t == 2){
          $filtros['O'] = 1;
          $sql .= " ORDER BY o.salario DESC";
        }
        
      }else if($tipo == 2){
        if($t == 1){
          $filtros['O'] = 2;
          $sql .= " ORDER BY o.fecha_actualizado ASC";
        }
        if($t == 2){
          $filtros['O'] = 1;
          $sql .= " ORDER BY o.fecha_actualizado DESC";
        }
      }
    }else{

      if(!empty($vista) && ($vista == 'postulacion')){ 
        $sql .= " ORDER BY pos.tipo ASC";
      }else{
        $sql .= " ORDER BY orden_urgente DESC,o.fecha_actualizado DESC";
      }
    }

    if($obtCantdRegistros == false){
      $page = ($page - 1) * REGISTRO_PAGINA;
      $sql .= " LIMIT ".$page.",".REGISTRO_PAGINA; 
    }

    $rs = $GLOBALS['db']->auto_array($sql,array(),true);
    return $rs;
  }

// se esta utlizando 15-04-2019
  public static function guardarRequisitosOferta($data){
    if(empty($data)){return false;}
    $result = $GLOBALS['db']->insert('mfo_requisitooferta', array('viajar'=>$data['viajar'],
                                                                  'residencia'=>$data['residencia'],
                                                                  'discapacidad'=>$data['discapacidad'],
                                                                  'confidencial'=>$data['confidencial'],
                                                                  'edad_minima'=>$data['edad_minima'],
                                                                  'edad_maxima'=>$data['edad_maxima']));
    return $result;
  }



  public static function guardarOferta($data){
    $dataArray = array();
    $dataArray = array('id_empresa'=>$data['id_empresa'], 'titulo'=>$data['titulo'],'descripcion'=>$data['descripcion'],'salario'=>$data['salario'],'a_convenir'=>$data['a_convenir'],'fecha_contratacion'=>$data['fecha_contratacion'],'vacantes'=>$data['vacantes'],'anosexp'=>$data['anosexp'],'estado'=>2,'fecha_creado'=>$data['fecha_creado'],'fecha_actualizado'=>$data['fecha_actualizado'],'fecha_caducidad'=>$data['fecha_caducidad'],'tipo'=>$data['tipo'],'primer_empleo'=>$data['primer_empleo'],'id_tipolicencia'=>$data['id_tipolicencia'],'id_jornada'=>$data['id_jornada'],'id_ciudad'=>$data['id_ciudad'],'id_requisitoOferta'=>$data['id_requisitoOferta'],'id_escolaridad'=>$data['id_escolaridad'],'id_empresa_plan'=>$data['id_empresa_plan']);
    if($data['id_tipolicencia'] == 0){
      $dataArray = array('id_empresa'=>$data['id_empresa'], 'titulo'=>$data['titulo'],'descripcion'=>$data['descripcion'],'salario'=>$data['salario'],'a_convenir'=>$data['a_convenir'],'fecha_contratacion'=>$data['fecha_contratacion'],'vacantes'=>$data['vacantes'],'anosexp'=>$data['anosexp'],'estado'=>2,'fecha_creado'=>$data['fecha_creado'],'fecha_actualizado'=>$data['fecha_actualizado'],'fecha_caducidad'=>$data['fecha_caducidad'],'tipo'=>$data['tipo'],'primer_empleo'=>$data['primer_empleo'],'id_jornada'=>$data['id_jornada'],'id_ciudad'=>$data['id_ciudad'],'id_requisitoOferta'=>$data['id_requisitoOferta'],'id_escolaridad'=>$data['id_escolaridad'],'id_empresa_plan'=>$data['id_empresa_plan']);
    }
    $result = $GLOBALS['db']->insert('mfo_oferta', $dataArray);
    return $result;
  }

  public static function guardarOfertaConvertida($data){

    $datos = array('id_empresa'=>$data['id_empresa'], 
                'titulo'=>$data['titulo'],
                'descripcion'=>$data['descripcion'],
                'salario'=>$data['salario'],
                'a_convenir'=>$data['a_convenir'],
                'fecha_contratacion'=>$data['fecha_contratacion'],
                'vacantes'=>$data['vacantes'],
                'anosexp'=>$data['anosexp'],
                'estado'=>$data['estado'],
                'fecha_creado'=>$data['fecha_creado'],
                'fecha_actualizado'=>$data['fecha_actualizado'],
                'fecha_caducidad'=>$data['fecha_caducidad'],
                'tipo'=>$data['tipo'],
                'primer_empleo'=>$data['primer_empleo'],
                'id_jornada'=>$data['id_jornada'],
                'id_ciudad'=>$data['id_ciudad'],
                'id_requisitoOferta'=>$data['id_requisitoOferta'],
                'id_escolaridad'=>$data['id_escolaridad'],
                'id_empresa_plan'=>$data['id_empresa_plan'] 
                );

    if(!empty($data['id_tipolicencia'])){
      $datos['id_tipolicencia'] = $data['id_tipolicencia'];
    }
    
    $result = $GLOBALS['db']->insert('mfo_oferta', $datos);
    return $result;
  }

// se esta utlizando 15-04-2019
  public static function aspirantesXofertas(){
    $sql = "SELECT o.id_ofertas, COUNT(p.id_auto) AS cantd_aspirantes 
            FROM mfo_oferta o
            LEFT JOIN mfo_postulacion p ON o.id_ofertas = p.id_ofertas
            WHERE (o.estado = 1 OR o.estado = 3)
            AND p.id_usuario = (SELECT pt.id_usuario FROM mfo_porcentajexfaceta pt WHERE pt.id_usuario = p.id_usuario LIMIT 1)
            GROUP BY o.id_ofertas;";
    $arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
    $datos = array();
    if (!empty($arrdatos) && is_array($arrdatos)){
      foreach ($arrdatos as $key => $value) {
        $datos[$value['id_ofertas']] = $value['cantd_aspirantes'];
      }
    }
    return $datos;
  }
  //*******************************************ALEX***************************************/
  public static function ultimasOfertasHome(){
     $sql = "SELECT o.id_ofertas, o.titulo, o.salario, o.vacantes, c.nombre AS ciudad, p.nombre AS provincia 
            FROM mfo_oferta o, mfo_ciudad c, mfo_provincia p
            WHERE o.id_ciudad = c.id_ciudad
            AND c.id_provincia = p.id_provincia
            AND o.estado = 1
            ORDER BY o.id_ofertas DESC
            LIMIT 12";
      return $GLOBALS['db']->Query($sql,array());
  }

  public static function obtieneAutopostulaciones($pais,$fecha,$areas,$usuario,$provincia=0,$ciudad=0){
    if (empty($pais) || empty($fecha) || empty($areas) || empty($usuario)){ return false; }
    $sql = "SELECT o.id_ofertas, o.salario, o.titulo, o.id_empresa AS id_usuario, p.nombre AS provincia, 
                   c.nombre AS ciudad, r.confidencial
            FROM mfo_oferta o     
            INNER JOIN mfo_requisitooferta r ON r.id_requisitoOferta = o.id_requisitoOferta       
            INNER JOIN mfo_ciudad c ON c.id_ciudad = o.id_ciudad
            INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
            INNER JOIN mfo_empresa_plan e ON e.id_empresa_plan = o.id_empresa_plan
            INNER JOIN mfo_plan a ON a.id_plan = e.id_plan 
            WHERE o.estado = 1 AND p.id_pais = ? AND o.fecha_contratacion >= ? AND a.costo <> 0 AND                   
                  o.id_ofertas NOT IN (SELECT id_ofertas FROM mfo_postulacion WHERE id_usuario = ?) AND
                  o.id_ofertas IN (SELECT DISTINCT(id_ofertas) FROM mfo_oferta_subareas 
                                   WHERE id_areas_subareas IN (".$areas.")) AND
                  o.id_empresa NOT IN (SELECT id_empresa FROM mfo_empresa_bloq where id_usuario = ?)";               
    if (!empty($provincia)){
      $sql .= " AND p.id_provincia = ".$provincia;
    }
    if (!empty($ciudad)){
      $sql .= " AND c.id_ciudad = ".$ciudad;
    }
    $sql .= " ORDER BY o.fecha_creado";
    return $GLOBALS['db']->auto_array($sql,array($pais,$fecha,$usuario,$usuario),true);
  }
  
  public static function ofertasxUsuarioPlan($usuarioplan){
    if (empty($usuarioplan)){ return false; }
    $sql = "SELECT id_ofertas FROM mfo_oferta where estado = 1 AND id_empresa_plan = ?";
    return $GLOBALS['db']->auto_array($sql,array($usuarioplan),true);
  }

  public static function desactivarOferta($id_ofertas,$estado=self::INACTIVA){
    if (empty($id_ofertas)){ return false; }
    return $GLOBALS['db']->update('mfo_oferta',array('estado'=>$estado),'id_ofertas='.$id_ofertas);
  }

  public static function guardarDescripcion($idOferta,$descripcion){
    if (empty($idOferta)){ return false; }
    return $GLOBALS['db']->update('mfo_oferta',array('descripcion'=>$descripcion,'estado'=>2),'id_ofertas='.$idOferta);
  }

  public static function puedeEditar($idOferta,$tiempo){
    if (empty($idOferta)){ return false; }

    $sql = "SELECT IF(TIMESTAMPDIFF(MINUTE, fecha_creado,now()) <= ".($tiempo*60).", 1,0) AS editar FROM mfo_oferta WHERE id_ofertas = ? AND (estado = 1 OR estado = 2) LIMIT 1";    
    return $GLOBALS['db']->auto_array($sql,array($idOferta),false);
  }

  public static function ofertaPostuladoPor($idOferta){
    if (empty($idOferta)){ return false; }
    $sql = "SELECT o.id_ofertas, e.id_empresa, e.nombres, o.titulo,o.estado  FROM mfo_oferta o INNER JOIN mfo_empresa e WHERE o.id_ofertas = ? AND o.id_empresa = e.id_empresa LIMIT 1";
    return $GLOBALS['db']->auto_array($sql,array($idOferta),false);
  }

  public static function consultarOferta($idOferta){
    if (empty($idOferta)){ return false; }
    $sql = "SELECT o.*,r.*,GROUP_CONCAT(os.id_areas_subareas) AS id_areas_subareas, GROUP_CONCAT(ni.id_nivelIdioma_idioma) AS id_nivelIdioma_idioma FROM mfo_oferta o, mfo_requisitooferta r, mfo_oferta_subareas os, mfo_oferta_nivelidioma ni  WHERE o.id_requisitoOferta = r.id_requisitoOferta AND o.id_ofertas = os.id_ofertas AND o.id_ofertas = ni.id_ofertas AND o.id_ofertas = ?";
    return $GLOBALS['db']->auto_array($sql,array($idOferta),true);
  }

  public static function consultarDescripcionOferta($idOferta){
    if (empty($idOferta)){ return false; }
    $sql = "SELECT descripcion FROM mfo_oferta where id_ofertas = ?";
    return $GLOBALS['db']->auto_array($sql,array($idOferta));
  }

  public static function consultarTituloOferta($idOferta){
    if (empty($idOferta)){ return false; }
    $sql = "SELECT titulo FROM mfo_oferta where id_ofertas = ?";
    return $GLOBALS['db']->auto_array($sql,array($idOferta));
  }

  public static function ofertasDiarias($pais,$areas, $usuarioData){
    if (empty($pais) || empty($areas) || empty($usuarioData)){ return false; }  
    // Si puede viajar pero no puede cambiar de residencia (busca solo provincia);
    // si puede viajar y tambien cambiar de residencia (busca en todo el pais);
    // Si no puede viajar pero si puede cambiar de residencia (busca en todo el pais);
    // si no puede viajar y no puede cambiar de residencia (busca en la provincia y la ciudad);
    if($usuarioData['residencia'] == 1 && $usuarioData['viajar'] == 0){
      $add_sql = " AND p.id_provincia = ".$usuarioData['id_provincia']." ";
    }
    elseif(($usuarioData['residencia'] == 1 && $usuarioData['viajar'] == 1) || ($usuarioData['residencia'] == 0 && $usuarioData['viajar'] == 1)){
      $add_sql = "AND p.id_pais = ".$pais."";
    }
    elseif($usuarioData['residencia'] == 0 && $usuarioData['viajar'] == 0){
      $add_sql = " AND p.id_provincia = ".$usuarioData['id_provincia']." AND c.id_ciudad = ".$usuarioData['id_ciudad']." ";
    }  
    $fechaayer = date("Y-m-d",strtotime(date("Y-m-d")."- 1 day"));
    $fechadesde = $fechaayer." 00:00:00";
    $fechahasta = $fechaayer." 23:59:59";
    $sql = "SELECT o.id_ofertas, o.titulo, e.nombres AS empresa, c.nombre AS ciudad, p.nombre AS provincia, r.confidencial
            FROM mfo_oferta o
            INNER JOIN mfo_requisitooferta r ON r.id_requisitoOferta = o.id_requisitoOferta
            INNER JOIN mfo_ciudad c ON c.id_ciudad = o.id_ciudad
            INNER JOIN mfo_provincia p ON p.id_provincia = c.id_provincia
            INNER JOIN mfo_empresa e ON e.id_empresa = o.id_empresa
            WHERE o.estado = 1 ".$add_sql." AND 
                  o.id_ofertas IN (SELECT DISTINCT(id_ofertas) FROM mfo_oferta_subareas 
                                   WHERE id_areas_subareas IN (".$areas.")) AND
                  o.fecha_creado BETWEEN ' ".$fechadesde."'  AND ' ".$fechahasta."'   
            ORDER BY o.id_ofertas";  
            // echo $sql."<br>";  
    return $GLOBALS['db']->auto_array($sql,array(),true);        
  }

  /********************************************ALEX**************************************************/

  public static function ofertasDiariasSinFiltro($pais, $usuarioData){
    if (empty($pais) || empty($usuarioData)){ return false; }  
 
    $fechaayer = date("Y-m-d",strtotime(date("Y-m-d")."- 1 day"));
    $fechadesde = $fechaayer." 00:00:00";
    $fechahasta = $fechaayer." 23:59:59";
    $sql = "SELECT o.id_ofertas, o.titulo, e.nombres AS empresa, r.confidencial
            FROM mfo_oferta o
            INNER JOIN mfo_requisitooferta r ON r.id_requisitoOferta = o.id_requisitoOferta
            INNER JOIN mfo_empresa e ON e.id_empresa = o.id_empresa
            WHERE o.estado = 1 
              
            GROUP BY o.id_ofertas";  
            // echo $sql."<br>";  
    return $GLOBALS['db']->auto_array($sql,array(),true);        
  }

  public static function consultarOfertaId($idOferta){
    if (empty($idOferta)){ return false; }  

    $sql = "SELECT o.id_ofertas, o.titulo, o.descripcion, o.fecha_contratacion, o.vacantes, o.salario, o.tipo AS tipo_oferta, j.nombre AS jornada, c.nombre AS ciudad, p.nombre AS provincia, r.viajar, r.residencia, r.discapacidad, r.edad_minima, r.edad_maxima, ne.descripcion AS escolaridad, o.primer_empleo, o.anosexp, o.descripcion, e.nombres AS empresa, r.confidencial, IF(o.id_tipolicencia IS NULL,0,o.id_tipolicencia) AS licencia, GROUP_CONCAT(DISTINCT(os.id_areas_subareas)) AS subareas, GROUP_CONCAT(DISTINCT(ni.id_nivelIdioma_idioma)) AS idiomas
           FROM mfo_oferta o, mfo_requisitooferta r, mfo_empresa e, mfo_jornada j, mfo_ciudad c, mfo_provincia p, mfo_escolaridad ne, mfo_oferta_nivelidioma ofn, mfo_nivelidioma_idioma ni,
           mfo_oferta_subareas os        
           WHERE o.id_requisitoOferta = r.id_requisitoOferta 
           AND o.id_empresa = e.id_empresa 
           AND o.id_jornada = j.id_jornada 
           AND o.id_ciudad = c.id_ciudad 
           AND c.id_provincia = p.id_provincia 
           AND o.id_escolaridad = ne.id_escolaridad 
           AND ni.id_nivelIdioma_idioma = ofn.id_nivelIdioma_idioma
           AND ofn.id_ofertas = o.id_ofertas
           AND os.id_ofertas = o.id_ofertas
           AND o.id_ofertas =".$idOferta;  
      //echo $sql."<br>";  
    return $GLOBALS['db']->auto_array($sql,array(),true);        
  }

  public static function ofertasxEliminar(){
    $sql = "SELECT o.id_ofertas, NOW() AS fecha_actual, DATE_ADD(e.fecha_caducidad, INTERVAL 1 MONTH) AS fecha_tope
            FROM mfo_oferta o 
            INNER JOIN mfo_empresa_plan e ON e.id_empresa_plan = o.id_empresa_plan 
            WHERE o.estado = ?";  
    return $GLOBALS['db']->auto_array($sql,array(self::PORELIMINAR),true);          
  }

  public static function obtenerPlanOferta($id_ofertas=false){

    $sql = 'SELECT ep.num_limiteperfiles, p.id_plan, p.nombre AS nombre_plan, p.costo, ep.id_empresa_plan, ep.num_accesos_rest,
    o.id_ofertas, ep.fecha_caducidad FROM mfo_oferta o
          INNER JOIN mfo_empresa_plan ep ON ep.id_empresa_plan = o.id_empresa_plan
          INNER JOIN mfo_plan p ON p.id_plan = ep.id_plan';

    if($id_ofertas != false){
      $sql .= ' WHERE o.id_ofertas = '.$id_ofertas;
      return $GLOBALS['db']->auto_array($sql,array(),false);
    }else{

      $arrdatos = $GLOBALS['db']->auto_array($sql,array(),true);
      $datos = array();
      if (!empty($arrdatos) && is_array($arrdatos)){

        foreach ($arrdatos as $key => $value) {
          $datos[$value['id_ofertas']] = array('nombre_plan'=>$value['nombre_plan'],'fecha_caducidad'=>$value['fecha_caducidad']);
        }
      }
      return $datos;
    }
  }

  public static function consultarInfoOfertaEmpresa($id_oferta){
    $sql = 'SELECT nombres AS empresa, o.titulo, ul.correo, o.descripcion, o.estado FROM mfo_empresa e, mfo_oferta o, mfo_usuario_login ul
          WHERE e.id_empresa = o.id_empresa 
          AND ul.id_usuario_login = e.id_usuario_login
          AND o.id_ofertas = '.$id_oferta;
    return $GLOBALS['db']->auto_array($sql,array(),false);  
  }

/*  public static function activarOferta($id_ofertas,$estado=self::ACTIVA){
    if (empty($id_ofertas)){ return false; }
    return $GLOBALS['db']->update('mfo_oferta',array('estado'=>$estado),'id_ofertas='.$id_ofertas);
  }*/

  public static function obtenerOfertas(){

    $sql = "SELECT * FROM mfo_oferta where estado = 1 OR estado = 3";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }


}  
?>