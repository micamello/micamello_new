<?php
class Modelo_Plan{
   
  const CANDIDATO = 1;
  const EMPRESA = 2;
  const PAQUETE = 2;
  const AVISO = 1;
  /*costo=false => todos sin validar el costo
    costo=1 => los que tengan precio 0
    costo=2 => los que no tenga precio 0*/
  public static function busquedaPlanes($tipousuario,$sucursal,$costo=false,$tipoplan=false,$nivel=false){
  	if (empty($tipousuario)||empty($sucursal)){ return false; }
    $sql = "SELECT p.id_plan, p.nombre, p.promocional, p.num_cuenta, p.num_accesos, p.limite_perfiles,
                   p.prom_costo, p.prom_duracion, p.num_post, p.costo, p.duracion, p.porc_descarga, 
                   p.prom_limiteperfiles,                   
                   GROUP_CONCAT(a.descripcion ORDER BY e.orden) AS permisos,
                   GROUP_CONCAT(a.accion ORDER BY e.orden) AS acciones
            FROM mfo_plan p
            INNER JOIN mfo_permisoplan e ON p.id_plan = e.id_plan  
            INNER JOIN mfo_accionsist a ON e.id_accionSist = a.id_accionSist            
            WHERE p.tipo_usuario = ? AND p.estado = 1 AND p.id_sucursal = ? AND 
                  a.estado = 1 AND p.visibilidad = 1 AND e.visibilidad = 1 ";    
    if (!empty($costo)){        
      $sql .= ($costo == 1) ? " AND p.costo = 0 " : " AND p.costo <> 0 ";            
    }
    if (!empty($tipoplan)){
      $sql .= " AND p.tipo_plan = ".$tipoplan." ";
    }  
    if ($nivel > 1){
      $sql .= " AND p.num_cuenta = 0 ";
    }
    $sql .= "GROUP BY p.id_plan ORDER BY p.costo";
    return $GLOBALS['db']->auto_array($sql,array($tipousuario,$sucursal),true);
  }
  public static function listadoPlanesUsuario($idUsuario,$tipo,$idPlan=false){
    if (empty($idUsuario) || empty($tipo)){ return false; }
    if ($tipo == Modelo_Usuario::CANDIDATO){
      $sql = "SELECT p.id_plan, p.nombre, p.costo, u.id_comprobante, u.fecha_compra, 
                     IFNULL(u.num_post_rest, '-') AS num_post_rest, 
                     IFNULL(u.fecha_caducidad,'-') AS fecha_caducidad, 
                     u.id_usuario_plan, u.estado, f.id_factura
              FROM mfo_usuario_plan u 
              INNER JOIN mfo_plan p ON u.id_plan = p.id_plan
              LEFT JOIN mfo_factura f ON f.id_comprobante = u.id_comprobante AND 
                                         f.tipo_usuario = 1 AND f.estado = ".Modelo_Factura::AUTORIZADO."
              WHERE u.id_usuario = ? /*AND
                    (u.estado = 1 OR (u.estado = 0 AND u.id_comprobante <> ''))*/
              ORDER BY u.fecha_compra ASC";
    }
    else{
      $sql = "SELECT p.id_plan, p.nombre, p.costo, e.id_comprobante,e.id_empresa_plan_parent, e.fecha_compra,        
                     IFNULL(e.fecha_caducidad,'-') AS fecha_caducidad, 
                     CASE WHEN num_publicaciones_rest = -1 THEN 'ilimitado'
                          WHEN num_publicaciones_rest = 0 THEN '-'
                          ELSE num_publicaciones_rest
                     END AS num_post_rest, 
                     CASE WHEN num_descarga_rest = -1 THEN 'ilimitado'
                          WHEN num_descarga_rest = 0 THEN '-'
                          ELSE num_descarga_rest
                     END AS num_descarga_rest, 
                     CASE WHEN num_accesos_rest IS NULL THEN '-'
                          WHEN num_accesos_rest = 0 THEN '-'
                          ELSE num_accesos_rest
                     END AS num_accesos_rest,
                     e.id_empresa_plan AS id_usuario_plan, e.estado, f.id_factura
              FROM mfo_empresa_plan e
              INNER JOIN mfo_plan p ON e.id_plan = p.id_plan
              LEFT JOIN mfo_factura f ON f.id_comprobante = e.id_comprobante AND 
                                         f.tipo_usuario = 2 AND f.estado = ".Modelo_Factura::AUTORIZADO."
              WHERE e.id_empresa = ? /*AND
                    (e.estado = 1 OR (e.estado = 0 AND e.id_comprobante <> ''))*/";

              if($idPlan != false){
                $sql .= " AND e.id_empresa_plan = ".$idPlan;
              }
      $sql .= " ORDER BY e.fecha_compra ASC";
    }  
    //echo $sql;  
    return $GLOBALS['db']->auto_array($sql,array($idUsuario),true);
  }
   
  public static function busquedaActivoxTipo($plan,$tipo,$sucursal){
    if (empty($plan) || empty($tipo) || empty($sucursal)){ return false; }
    $sql = "SELECT id_plan, nombre, tipo_usuario, tipo_plan, num_cuenta, prom_costo, 
                   prom_duracion, num_accesos, promocional, costo, num_post,                                      
                   duracion, porc_descarga, limite_perfiles, prom_limiteperfiles                   
            FROM mfo_plan 
            WHERE estado = 1 AND id_plan = ? AND tipo_usuario = ? AND id_sucursal = ? AND visibilidad = 1";
    return $GLOBALS['db']->auto_array($sql,array($plan,$tipo,$sucursal));    
  }
 
  public static function busquedaXId($id,$todos=false){   
    if (empty($id)){ return false; }
    if (!$todos){
      $sql = "SELECT * FROM mfo_plan WHERE id_plan = ?";
    }
    else{
      $sql = "SELECT p.tipo_plan, p.id_sucursal, p.num_post, p.duracion, p.nombre, 
                     s.id_pais, p.tipo_usuario, p.num_cuenta, p.porc_descarga, p.num_accesos 
              FROM mfo_plan p
              INNER JOIN mfo_sucursal s ON s.id_sucursal = p.id_sucursal 
              WHERE p.id_plan = ? AND p.estado = 1";
    }
    return $GLOBALS['db']->auto_array($sql,array($id));
  }
  public static function obtienePromocionales(){
    $sql = "SELECT * FROM mfo_plan WHERE estado = 1 AND promocional = 1";
    return $GLOBALS['db']->auto_array($sql,array(),true);
  }
  public static function modificarPromocion($idplan){
    if (empty($idplan)){ return false; }
    $data_update = array("fecha_inicio"=>"null",
                         "prom_costo"=>"null",
                         "prom_num_post"=>"null",
                         "prom_porc_descarga"=>"null",
                         "prom_duracion"=>"null",
                         "prom_codigo_paypal"=>"null",
                         "promocional"=>0);
    return $GLOBALS['db']->update("mfo_plan",$data_update,"id_plan=".$idplan);
  }

  public static function busquedaEmpresaPlanTipo(){
    $sql = "SELECT 
              ep1.id_empresa_plan , p1.id_sucursal, ep1.estado, datedata.*, ep1.id_empresa
            FROM
                (SELECT 
                    e.nombres,
                        ep.id_plan as plan,
                        MAX(ep.fecha_caducidad) AS maxdate
                FROM
                    mfo_empresa_plan ep, mfo_plan p, mfo_empresa e
                WHERE
                    ep.id_plan = p.id_plan
                        AND e.id_empresa = ep.id_empresa
                        AND p.costo = 0
                GROUP BY ep.id_plan , ep.id_empresa) as datedata
                inner join mfo_empresa_plan ep1 on ep1.id_plan = datedata.plan
                inner join mfo_plan p1 ON p1.id_plan = ep1.id_plan
                where datedata.maxdate = ep1.fecha_caducidad
                AND p1.estado = 1;";

      return $GLOBALS['db']->auto_array($sql, array(), true);
  }
}  
?>