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
                tipo.nombre_tipog as tipo,
                if(log.nota_logg='','N/A',log.nota_logg) as nota,
                CONCAT('https://www.google.com/maps/search/?api=1&query=',log.latitud_logg,',',log.longitud_logg) as mapa,
                if(log.latitud_logg=0 AND log.longitud_logg=0,1,0) AS coor,
                logNeto.valor_logg AS neto,
                if(log.movimiento_logg <> 0,log.valor_logg,0) AS pagado
                
            FROM tbl_log_gasto as log
            INNER JOIN tbl_usuarios AS usu ON (usu.id_usu=log.id_autor_gas)
            INNER JOIN tbl_gasto AS gas ON (gas.id_gas=log.id_gas)
            INNER JOIN tbl_tipo_gasto AS tipo ON (tipo.id_tipog=gas.id_tipo_tipog)
            INNER JOIN tbl_log_gasto AS logNeto ON (logNeto.id_gas=gas.id_gas AND logNeto.movimiento_logg=0)
            WHERE 1";

        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND usu.documento_usu = ".$params['Cedula'];
        }

        /*if(isset($params['Cedula_au']) && $params['Cedula_au']!=0){
            if(isset($params['Cedula']) && $params['Cedula']!=0){
                $query.=" OR Autor.documento_usu = ".$params['Cedula'];
            }else{
                $query.=" AND Autor.documento_usu = ".$params['Cedula'];
            }
        }*/

        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND usu.id_usu = ".$params['Nombre'];
        }

        /*if(isset($params['Nombre_au']) && $params['Nombre_au']!=0){
            if(isset($params['Nombre']) && $params['Nombre']!=0){
                $query.=" OR log.id_autor_usu = ".$params['Nombre_au'];
            }else{
                $query.=" AND log.id_autor_usu = ".$params['Nombre_au'];
            }
        }*/
        
        if(isset($params['Fecha_fin']) && $params['Fecha_fin']!=""){
            $query.=" AND log.fecha_logg <= '".$params['Fecha_fin']."'";
        }
        if(isset($params['Fecha_ini']) && $params['Fecha_ini']!=""){
            $query.=" AND log.fecha_logg >= '".$params['Fecha_ini']."'";
        }
        if(isset($params['Movimiento']) && $params['Movimiento']!=999){
            $query.=" AND log.movimiento_logg = '".$params['Movimiento']."'";
        }


        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }

    public function query_vendedores(){
        $query="CALL obtenerUsuario()";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    public function csv($params){
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
                tipo.nombre_tipog as tipo,
                if(log.nota_logg='','N/A',log.nota_logg) as nota,
                CONCAT('https://www.google.com/maps/search/?api=1&query=',log.latitud_logg,',',log.longitud_logg) as mapa,
                if(log.latitud_logg=0 AND log.longitud_logg=0,1,0) AS coor,
                logNeto.valor_logg AS neto,
                if(log.movimiento_logg <> 0,log.valor_logg,0) AS pagado
                
            FROM tbl_log_gasto as log
            INNER JOIN tbl_usuarios AS usu ON (usu.id_usu=log.id_autor_gas)
            INNER JOIN tbl_gasto AS gas ON (gas.id_gas=log.id_gas)
            INNER JOIN tbl_tipo_gasto AS tipo ON (tipo.id_tipog=gas.id_tipo_tipog)
            INNER JOIN tbl_log_gasto AS logNeto ON (logNeto.id_gas=gas.id_gas AND logNeto.movimiento_logg=0)
            WHERE 1";

        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND usu.documento_usu = ".$params['Cedula'];
        }

        /*if(isset($params['Cedula_au']) && $params['Cedula_au']!=0){
            if(isset($params['Cedula']) && $params['Cedula']!=0){
                $query.=" OR Autor.documento_usu = ".$params['Cedula'];
            }else{
                $query.=" AND Autor.documento_usu = ".$params['Cedula'];
            }
        }*/

        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND usu.id_usu = ".$params['Nombre'];
        }

        /*if(isset($params['Nombre_au']) && $params['Nombre_au']!=0){
            if(isset($params['Nombre']) && $params['Nombre']!=0){
                $query.=" OR log.id_autor_usu = ".$params['Nombre_au'];
            }else{
                $query.=" AND log.id_autor_usu = ".$params['Nombre_au'];
            }
        }*/
        
        if(isset($params['Fecha_fin']) && $params['Fecha_fin']!=""){
            $query.=" AND log.fecha_logg <= '".$params['Fecha_fin']."'";
        }
        if(isset($params['Fecha_ini']) && $params['Fecha_ini']!=""){
            $query.=" AND log.fecha_logg >= '".$params['Fecha_ini']."'";
        }
        if(isset($params['Movimiento']) && $params['Movimiento']!=999){
            $query.=" AND log.movimiento_logg = '".$params['Movimiento']."'";
        }

        $data=$this->DB_QUERY->query($query);

        return $data;
    }
}