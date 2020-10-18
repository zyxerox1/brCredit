<?php

class cerrar_modelo
{
    private $DB;
    private $cerrar;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->DB_QUERY   = new query_modelo;
        $this->DB_QUERY1   = new query_modelo;
        $this->cerrar = array();
        $this->data = array();
    }

    /*/////////////////////////////////////////////guardar///////////////////////////////////*/
   

    /*////////////////////////////////consulta//////////////////////////////////////////////////*/
    public function obtener_filtro_vendedor(){
        $this->data = array();
        $query="CALL FiltroRuta()";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    public function obtenerDatos($param){
        $this->data = array();
        $WHERE="";
        $GROUP="";
        if(isset($param['Fecha_fin']) && $param['Fecha_fin']!=""){
            $WHERE.=" AND log.date_fecha_loge <= '".$param['Fecha_fin']."'";
        }
        if(isset($param['Fecha_ini']) && $param['Fecha_ini']!=""){
            $WHERE.=" AND log.date_fecha_loge >= '".$param['Fecha_ini']."'";
        }

        $query="SELECT CONCAT_WS (' ',usu.primer_nombre_usu,
                    usu.segundo_nombre_usu,
                    usu.primer_apellido_usu,
                    usu.segundo_apellido_usu) as nombre,
                    usu.codigo_ruta AS codigo,
                    rh.fecha_rutaH AS fecha,
                    rh.cerrado_rutaH AS cerrado,
                    rh.id_rutaH AS id,
                    usu.id_usu AS usu
                    FROM tbl_ruta_historial AS rh
                    INNER JOIN tbl_cliente AS clien ON (rh.id_clien=clien.id_clie)
                    INNER JOIN tbl_usuarios AS usu ON (usu.id_usu=clien.id_usu)
                    WHERE usu.id_usu=".$param["codigo"]." $WHERE
                    GROUP BY usu.id_usu,rh.fecha_rutaH
                    UNION ALL
                    SELECT CONCAT_WS (' ',usu.primer_nombre_usu,
                          usu.segundo_nombre_usu,
                          usu.primer_apellido_usu,
                          usu.segundo_apellido_usu) as nombre,
                     usu.codigo_ruta AS codigo,
                     now() AS fecha,
                     clien.cumplimineto_client AS cerrado,
                     0 AS id,
                    usu.id_usu AS usu
                    FROM tbl_usuarios AS usu
                    LEFT JOIN tbl_cliente AS clien ON (usu.id_usu=clien.id_usu)
                    WHERE usu.rol_usu = 2 AND usu.id_usu=".$param["codigo"]." $WHERE";

                    $query.=" GROUP BY usu.id_usu";
            
        $data=$this->DB_QUERY->queryDatatable($param,$query);
        return $data;
    }

    public function obtenerDetalle($param){
        $this->data = array();
        $query="SELECT COUNT(logPres.id_logp) AS cobros,
                       ROUND(SUM(logPres.valor_pres_logp), 2) AS Pagado,
                       ROUND(ValorPres.ValorArecuado, 2) AS ValorArecuado,
                       ValorPres.totalRuta,
                       SUM(gas.valor_gas) AS gasto
                FROM tbl_log_prestamo AS logPres
                INNER JOIN tbl_gasto AS gas ON (gas.id_usu=logPres.id_autor_usu)
                INNER JOIN (
                                SELECT clien.id_usu,SUM(press.valor_cuotas_pres) AS ValorArecuado,COUNT(clien.id_usu) AS totalRuta
                                FROM tbl_cliente AS clien
                                LEFT JOIN tbl_prestamo AS press ON (press.id_clie=clien.id_clie)
                                WHERE clien.id_usu=".$param["usu"]."
                            ) AS ValorPres ON (ValorPres.id_usu=logPres.id_autor_usu)
                            
                WHERE logPres.movimiento_logp = 1 AND logPres.apuntadaor_prestamo_logp = 0 AND logPres.id_autor_usu = ".$param["usu"]."
                GROUP BY logPres.id_autor_usu";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    public function notaVentas($param){
        $this->data = array();
        $query="SELECT if(pres.nota_logp<>'',pres.nota_logp,'N/A') AS nota, CONCAT_WS (' ',client.primer_nombre_clie,
                    client.segundo_nombre_clie,
                    client.primer_apellido_clie,
                    client.segundo_apellido_clie) as nombre
FROM tbl_log_prestamo AS pres
INNER JOIN tbl_cliente AS client ON (client.id_clie=pres.id_clie)
WHERE pres.movimiento_logp=1 AND pres.id_autor_usu=".$param["usu"];
            
        $data=$this->DB_QUERY->queryDatatable($param,$query);
        return $data;
    }   


    public function obtenerVenta($param){
        $this->data = array();
        $query="SELECT
                    press.id_pres AS id,
                    CONCAT_WS (' ',client.primer_nombre_clie, client.segundo_nombre_clie, client.primer_apellido_clie, client.segundo_apellido_clie) as Cliente,
                    press.valor_neto_clie AS ValorSin,
                    logPress.valor_pres_logp AS ValorCon,
                    press.intereses_press AS Interese,
                    'Prestamo' AS Producto
                    FROM tbl_prestamo AS press
                    INNER JOIN tbl_cliente AS client ON (client.id_clie=press.id_clie)
                    INNER JOIN tbl_log_prestamo AS logPress ON (logPress.id_pres=press.id_pres AND logPress.movimiento_logp=0)
                    INNER JOIN tbl_usuarios AS usu ON (usu.id_usu=client.id_usu)
                    WHERE usu.id_usu=".$param["usu"];
            
        $data=$this->DB_QUERY->queryDatatable($param,$query);
        return $data;
    }

    public function obtenerRecaudo($param){
        $this->data = array();
        $query="SELECT CONCAT_WS (' ',client.primer_nombre_clie, client.segundo_nombre_clie, client.primer_apellido_clie, client.segundo_apellido_clie) as Cliente,
        press.valor_cuotas_pres  AS Cuota,
        logPres.valor_pres_logp AS Pago,
        press.valor_pres AS faltante,
        dataRuta.vencidos,
        dataRuta.atrasada,
        press.id_pres AS Venta,
        IF(logPres.fecha_logp = ' ','Pagado','No pagado') AS Estado
        FROM tbl_cliente AS client 
        LEFT JOIN tbl_log_prestamo AS logPres ON (client.id_clie=logPres.id_clie AND logPres.movimiento_logp=1)
        INNER JOIN tbl_prestamo AS press ON (press.id_pres=logPres.id_pres)
        INNER JOIN tbl_usuarios AS usu ON (usu.id_usu=client.id_usu)
        LEFT JOIN (
                   SELECT COUNT(rt.id_rutaH) AS vencidos, SUM(presSub.valor_cuotas_pres) AS atrasada,            presSub.id_clie
                    FROM tbl_ruta_historial AS rt
                    INNER JOIN tbl_prestamo AS presSub ON (presSub.id_pres=rt.id_pres)
                   ) AS dataRuta ON (dataRuta.id_clie=client.id_clie)
        WHERE usu.id_usu=".$param["usu"];
            
        $data=$this->DB_QUERY->queryDatatable($param,$query);
        return $data;
    }

    public function obtenerGasto($param){
 
    
        $this->data = array();
        $query="SELECT 
            gas.id_gas AS id,
            gas.nota_gas AS Descripcion,
            gas.valor_total_gas AS Valor,
            tgas.nombre_tipog AS Tipo,
            CONCAT_WS (' ',usu.primer_nombre_usu, usu.segundo_nombre_usu, usu.primer_apellido_usu, usu.segundo_apellido_usu) AS Autor
            FROM tbl_gasto AS gas
            INNER JOIN tbl_tipo_gasto AS tgas ON (gas.id_tipo_tipog=tgas.id_tipog)
            INNER JOIN tbl_usuarios AS usu ON (usu.id_usu=gas.id_usu)
            WHERE usu.id_usu=".$param["usu"];
            
        $data=$this->DB_QUERY->queryDatatable($param,$query);
        return $data;
    }

    public function obtenerResumen(){

    }
    
    /*////////////////////////////////atualizar//////////////////////////////////////////////////*/
}