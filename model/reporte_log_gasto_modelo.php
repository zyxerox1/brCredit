<?php
class reporte_log_gasto_modelo
{
    private $data;
    private $DB_QUERY;

    public function __construct()
    {
        $this->DB_QUERY   = new query_modelo;
        $this->DB_QUERY1   = new query_modelo;
        $this->data = array();
    }

    /*///////////////////////////////consulta////////////////////////////*/

    public function obtenerReporte($params){
        $query="SELECT CASE
               WHEN log.movimiento_logg = 0 THEN 'Gasto propio del vendedor'
               WHEN log.movimiento_logg = 1 THEN 'Cancelado por el coordinador'
               WHEN log.movimiento_logg = 2 THEN 'Abono del coordinador'
               WHEN log.movimiento_logg = 3 THEN 'Anulado por el vendedor'
               ELSE 'Movimiento descodocido por el sistema.'
               END as movimiento,
               log.fecha_logg as fecha,
               CONCAT_WS('', usu.primer_nombre_usu, usu.segundo_nombre_usu, usu.primer_apellido_usu, usu.segundo_apellido_usu ) as usuario,
                usu.documento_usu as documento_suario,
                gas.valor_gas as valor,
                tipo.nombre_tipog as tipo
            FROM tbl_log_gasto as log
            INNER JOIN tbl_usuarios AS usu ON (usu.id_usu=log.id_autor_gas)
            INNER JOIN tbl_gasto AS gas ON (gas.id_gas=log.id_gas)
            INNER JOIN tbl_tipo_gasto AS tipo ON (tipo.id_tipog=gas.id_tipo_tipog)
            WHERE 1";

        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND usu.documento_usu = ".$params['Cedula'];
        }

        if(isset($params['Cedula_au']) && $params['Cedula_au']!=0){
            if(isset($params['Cedula']) && $params['Cedula']!=0){
                $query.=" OR Autor.documento_usu = ".$params['Cedula'];
            }else{
                $query.=" AND Autor.documento_usu = ".$params['Cedula'];
            }
        }

        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND usu.id_usu = ".$params['Nombre'];
        }

        if(isset($params['Nombre_au']) && $params['Nombre_au']!=0){
            if(isset($params['Nombre']) && $params['Nombre']!=0){
                $query.=" OR log.id_autor_usu = ".$params['Nombre_au'];
            }else{
                $query.=" AND log.id_autor_usu = ".$params['Nombre_au'];
            }
        }
        
        if(isset($params['Fecha_fin']) && $params['Fecha_fin']!=""){
            $query.=" AND log.fecha_logg <= '".$params['Fecha_fin']."'";
        }
        if(isset($params['Fecha_ini']) && $params['Fecha_ini']!=""){
            $query.=" AND log.fecha_logg >= '".$params['Fecha_ini']."'";
        }
        if(isset($params['Movimiento']) && $params['Movimiento']!=999){
            $query.=" AND log.movimiento_logu = '".$params['Movimiento']."'";
        }

        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }

    public function query_coordinadores(){
        $query="CALL obtenerCoordinadores()";
        $data=$this->DB_QUERY1->query($query);
        return $data;
    }

    public function query_vendedores(){
        $query="CALL obtenerVendedores()";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    public function csv(){
        $query="SELECT CASE
               WHEN log.movimiento_logg = 0 THEN 'Gasto propio del vendedor'
               WHEN log.movimiento_logg = 1 THEN 'Cancelado por el coordinador'
               WHEN log.movimiento_logg = 2 THEN 'Abono del coordinador'
               WHEN log.movimiento_logg = 3 THEN 'Anulado por el vendedor'
               ELSE 'Movimiento descodocido por el sistema.'
               END as movimiento,
               log.fecha_logg as fecha,
               CONCAT_WS('', usu.primer_nombre_usu, usu.segundo_nombre_usu, usu.primer_apellido_usu, usu.segundo_apellido_usu ) as usuario,
                usu.documento_usu as documento_suario,
                gas.valor_gas as valor,
                tipo.nombre_tipog as tipo
            FROM tbl_log_gasto as log
            INNER JOIN tbl_usuarios AS usu ON (usu.id_usu=log.id_autor_gas)
            INNER JOIN tbl_gasto AS gas ON (gas.id_gas=log.id_gas)
            INNER JOIN tbl_tipo_gasto AS tipo ON (tipo.id_tipog=gas.id_tipo_tipog)
            WHERE 1";

        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND usu.documento_usu = ".$params['Cedula'];
        }

        if(isset($params['Cedula_au']) && $params['Cedula_au']!=0){
            if(isset($params['Cedula']) && $params['Cedula']!=0){
                $query.=" OR Autor.documento_usu = ".$params['Cedula'];
            }else{
                $query.=" AND Autor.documento_usu = ".$params['Cedula'];
            }
        }

        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND usu.id_usu = ".$params['Nombre'];
        }

        if(isset($params['Nombre_au']) && $params['Nombre_au']!=0){
            if(isset($params['Nombre']) && $params['Nombre']!=0){
                $query.=" OR log.id_autor_usu = ".$params['Nombre_au'];
            }else{
                $query.=" AND log.id_autor_usu = ".$params['Nombre_au'];
            }
        }
        
        if(isset($params['Fecha_fin']) && $params['Fecha_fin']!=""){
            $query.=" AND log.fecha_logg <= '".$params['Fecha_fin']."'";
        }
        if(isset($params['Fecha_ini']) && $params['Fecha_ini']!=""){
            $query.=" AND log.fecha_logg >= '".$params['Fecha_ini']."'";
        }
        if(isset($params['Movimiento']) && $params['Movimiento']!=999){
            $query.=" AND log.movimiento_logu = '".$params['Movimiento']."'";
        }
        $data=$this->DB_QUERY->query($query);

        return $data;
    }
}