<?php
class balance_modelo
{
    private $DB;
    private $balance;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->DB_QUERY   = new query_modelo;
        $this->balance = array();
    }

    /*/////////////////////////////////////////////guardar///////////////////////////////////*/

    /*////////////////////////////////consulta//////////////////////////////////////////////////*/

    public function cargar(){
        $id=$_SESSION["id_usu_credit"];
        $query="SELECT 
                      SUM(if(press.valor_pres>0,1,0)) AS numeroCobros, 
                      SUM(if(press.valor_pres>0,press.valor_cuotas_pres,0)) AS meta,
                      SUM(if(logpres.movimiento_logp=1,1,0)) AS numeroPagado, 
                      SUM(if(logpres.movimiento_logp=1,logpres.valor_pres_logp,0)) AS Pagado,                              
                      SUM(if(logpres.movimiento_logp=0,logpres.valor_pres_logp,0)) AS totalVendido,
                      if(hv.saldoInicial_histV IS NOT NULL,hv.saldoInicial_histV,0) as saldoInicial, 
                      logGloabal.numnuevaVentas as numVentas, 
                      logGloabal.nuevaVentas as Ventas,
                        
                      SUM(if(gas.valor_gas is null,0,gas.valor_gas)) AS gasto, 
                      SUM(if(gas.valor_gas is null,0,1)) AS numgasto, 
                      if(caj.saldo_caja is null,0,caj.saldo_caja) as caja, 
                      retirosTabla.retiros as Retiros, 
                      retirosTabla.numRetiros as numretiros

                  FROM tbl_prestamo as press 
                  INNER JOIN tbl_cliente as clien on (press.id_clie=clien.id_clie)
                  LEFT JOIN tbl_log_prestamo AS logpres ON (logpres.id_pres=press.id_pres AND DATE_FORMAT(logpres.fecha_logp, '%Y-%c-%d') = DATE_FORMAT(now(), '%Y-%c-%d'))
                  LEFT JOIN tbl_historial_vendedor AS hv ON (hv.id_usu=clien.id_usu AND DATE_FORMAT(hv.fecha_histV, '%Y-%c-%d') = DATE_FORMAT(now(), '%Y-%c-%d')) 
                  LEFT JOIN tbl_gasto AS gas ON (gas.id_usu=logpres.id_autor_usu) 
                  LEFT JOIN tbl_caja as caj ON (caj.id_usu=logpres.id_autor_usu)
                  LEFT JOIN ( 
                      SELECT 
                        SUM(if(ret.valor_ret is null,0,ret.valor_ret)) as retiros, 
                        ret.id_ruta_usu AS usu, SUM(if(ret.valor_ret is null,0,1)) as numRetiros 
                          FROM tbl_retiro AS ret 
                        WHERE ret.id_ruta_usu='$id' 
                    ) as retirosTabla ON (retirosTabla.usu=logpres.id_autor_usu)
                  LEFT JOIN ( 
                            SELECT 
                              SUM(if(log.movimiento_logp=0,1,0)) as numnuevaVentas,
                              SUM(if(log.movimiento_logp=0,log.valor_pres_logp,0)) as nuevaVentas, 
                              log.id_autor_usu AS id 
                            FROM tbl_log_prestamo as log 
                            WHERE log.id_autor_usu='$id' 
                      ) AS logGloabal ON (logGloabal.id=clien.id_usu) 
                  WHERE clien.id_usu=".$id;

        
        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    /*////////////////////////////////atualizar//////////////////////////////////////////////////*/
    
}