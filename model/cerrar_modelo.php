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
    public function log_cerrar($tipo,$latitud=0,$longitud=0){

        /*movimineto 0-crear,1-editar,3-cambiar estado,2-orden*/
        /*parametro de errores{*/
        $controller="";
        $accion_func="";
        if(isset($_REQUEST['c'])){
            $controller=$_REQUEST['c'];
        }
        if(isset($_REQUEST['a'])){
            $accion_func=$_REQUEST['a'];
        }
        $ip=$this->getRealIP();

        //$query = "CALL logPrestamo('$movimiento','$id','$controller',".$_SESSION["id_usu_credit"].",'$accion_func','$id_clie','$nota','$valor','$tipo','$latitud','$longitud','$ip')";

        $query="INSERT INTO tbl_log_cierre (id_cierre, fecha_cierre, id_usu, tipo_cierre, longitud_cierre, latitud_cierre, ip_cierre) VALUES (NULL, now(),'".$_SESSION["rol"]."', '$tipo', '$longitud', '$latitud', '$ip');";

        $id=$this->DB_QUERY->save($query);
        return $id;
    }

    /*////////////////////////////////consulta//////////////////////////////////////////////////*/

    function getRealIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
    }

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

        if(isset($param['codigo']) && $param['codigo']!=0){
            $WHERE.=" AND usu.id_usu = '".$param['codigo']."' ";
        }

        $query1="SELECT CONCAT_WS (' ',usu.primer_nombre_usu,
                          usu.segundo_nombre_usu,
                          usu.primer_apellido_usu,
                          usu.segundo_apellido_usu) as nombre,
                        usu.codigo_ruta AS codigo,
                        now() AS fecha,
                        usu.cerrar_usu AS cerrado,
                        CONCAT('00',usu.id_usu) AS id,
                        usu.id_usu AS usu,
                        usu.validar_usu AS validar,
                        0 as tipo
                FROM tbl_usuarios AS usu
                LEFT JOIN tbl_caja AS caja ON (caja.id_usu=usu.id_usu)
                WHERE usu.rol_usu = 2 $WHERE";

        if(isset($param['Estado']) && $param['Estado']!=111){
            $query1.=" AND usu.cerrar_usu = '".$param['Estado']."'";
        }

        $query1.=" GROUP BY usu.id_usu";

        $query2="SELECT CONCAT_WS (' ',usu.primer_nombre_usu,
                    usu.segundo_nombre_usu,
                    usu.primer_apellido_usu,
                    usu.segundo_apellido_usu) as nombre,
                    usu.codigo_ruta AS codigo,
                    rh.fecha_histV AS fecha,
                    rh.cerrado_histV AS cerrado,
                    rh.id_histV AS id,
                    usu.id_usu AS usu,
                    rh.validar_histV AS validar,
                    1 as tipo
                FROM tbl_historial_vendedor AS rh
                INNER JOIN tbl_usuarios AS usu ON (usu.id_usu=rh.id_usu)
                WHERE usu.rol_usu = 2 $WHERE";

        if(isset($param['Estado']) && $param['Estado']!=111){
            $query2.=" AND rh.cerrado_histV = '".$param['Estado']."'";
        }

        if(isset($param['Fecha_fin']) && $param['Fecha_fin']!=""){
            $query2.=" AND rh.fecha_histV <= '".$param['Fecha_fin']."'";
        }
        if(isset($param['Fecha_ini']) && $param['Fecha_ini']!=""){
            $query2.=" AND rh.fecha_histV >= '".$param['Fecha_ini']."'";
        }

        if(isset($param['Fecha_fin']) && $param['Fecha_fin']!="" && isset($param['Fecha_ini']) && $param['Fecha_ini']!=""){
            if(date("Y-m-d") >= $param['Fecha_ini'] && date("Y-m-d") <= $param['Fecha_fin']){
                $query=$query1." UNION ALL ".$query2;
            }else{
                $query=$query2;
            }
        }else if(isset($param['Fecha_ini']) && $param['Fecha_ini']!=""){
            if (date("Y-m-d") >= $param['Fecha_ini']){
                $query=$query1." UNION ALL ".$query2;
            }else{
                $query=$query2;
            }
        }else if(isset($param['Fecha_fin']) && $param['Fecha_fin']!=""){
            if (date("Y-m-d") <= $param['Fecha_fin']){
                $query=$query1." UNION ALL ".$query2;
            }else{
                $query=$query2;
            }
        }else{
            $query=$query1." UNION ALL ".$query2;
        }

        $data=$this->DB_QUERY->queryDatatable($param,$query);
        return $data;
    }

    public function obtenerDetalle($param){
        $this->data = array();
        $fecha=$param["fecha"];
        $usu=$param["usu"];
        $query="SELECT SUM(if(logPres.movimiento_logp=1,1,0)) AS cobros,
                       ROUND(SUM(if(logPres.movimiento_logp=1,logPres.valor_pres_logp,0)),2) AS Pagado,
                       ROUND(ValorPres.ValorArecuado, 2) AS ValorArecuado,
                       ValorPres.totalRuta,
                       SUM(if(gas.valor_gas is null,0,gas.valor_gas)) AS gasto,
                       if(hv.saldoInicial_histV is null,0,hv.saldoInicial_histV) AS saldoInicial,
                       SUM(if(logPres.movimiento_logp=1,logPres.valor_pres_logp,0)) as recaudo,
                       SUM(if(logPres.movimiento_logp=1,1,0)) as numRecaudo,
                       ValorPres.cartera AS cartera,
                       SUM(if(logPres.movimiento_logp=0,1,0)) as numnuevaVentas,
                       SUM(if(logPres.movimiento_logp=0,logPres.valor_pres_logp,0)) as nuevaVentas,
                       ValorPres.totalCarVen as carteravencidas,
                       retirosTabla.retiros as Retiros,
                       retirosTabla.numRetiros as numretiros,
                       
                       if(hv.validar_histV is null,'N/a',CONCAT_WS (' ',usuAdmin.primer_nombre_usu,
                          usuAdmin.segundo_nombre_usu,
                          usuAdmin.primer_apellido_usu,
                          usuAdmin.segundo_apellido_usu)) as vali,
                        if(caj.saldo_caja is null,0,caj.saldo_caja) as caja

                FROM tbl_log_prestamo AS logPres
                LEFT JOIN tbl_gasto AS gas ON (gas.id_usu=logPres.id_autor_usu)
                LEFT JOIN tbl_historial_vendedor AS hv ON (hv.id_usu=logPres.id_autor_usu AND hv.fecha_histV='$fecha')
                LEFT JOIN tbl_usuarios as usuAdmin ON (usuAdmin.id_usu=hv.validar_histV)
                LEFT JOIN tbl_caja as caj ON (caj.id_usu=logPres.id_autor_usu)
                LEFT JOIN (
                        SELECT SUM(if(ret.valor_ret is null,0,ret.valor_ret)) as retiros,
                                ret.id_ruta_usu AS usu,
                                SUM(if(ret.valor_ret is null,0,1)) as numRetiros
                        FROM tbl_retiro AS ret 
                        WHERE ret.id_ruta_usu='$usu' AND DATE_FORMAT(ret.fecha_ret, '%Y-%c-%d') = '$fecha'
                        ) as retirosTabla ON (retirosTabla.usu=logPres.id_autor_usu)
                LEFT JOIN (
                        SELECT clien.id_usu,
                               SUM(press.valor_cuotas_pres) AS ValorArecuado,
                               COUNT(clien.id_usu) AS totalRuta, 
                               SUM(press.valor_pres) AS cartera, 
                               SUM(IF(DATE_FORMAT(press.fecha_limite_pres, '%Y-%c-%d')>DATE_FORMAT(now(), '%Y-%c-%d'),press.valor_pres,0)) AS totalCarVen
                                FROM tbl_cliente AS clien
                                LEFT JOIN tbl_prestamo AS press ON (press.id_clie=clien.id_clie)
                                WHERE clien.id_usu='$usu'
                            ) AS ValorPres ON (ValorPres.id_usu=logPres.id_autor_usu)
                            
                WHERE logPres.apuntadaor_prestamo_logp = 0 AND logPres.id_autor_usu = '$usu' AND DATE_FORMAT(logPres.fecha_logp, '%Y-%c-%d') = '$fecha'
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

     public function rechazar($param){
        $this->DB_QUERY1->begin();
        $query="UPDATE tbl_usuarios SET cerrar_usu = 0 WHERE tbl_usuarios.id_usu =".$param["usu"];
        $id=$this->DB_QUERY1->save($query,'Rechazar cerrar.');
        $this->log_cerrar(2,$param["latitud"],$param["logitud"]);
        $this->DB_QUERY1->commit();
        return array('control' =>0 ,'error' => 0);
     }

     public function cerrarTodo($param){
        
        $this->DB_QUERY1->begin();
        $query="UPDATE tbl_usuarios SET cerrar_usu = 2 WHERE tbl_usuarios.rol_usu = 2";
        $id=$this->DB_QUERY1->save($query,'Cerrar todo.');
        $this->log_cerrar(1,$param["latitud"],$param["logitud"]);
        $this->DB_QUERY1->commit();
        return array('control' =>0 ,'error' => 0);
    }
}