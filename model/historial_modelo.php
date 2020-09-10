<?php
class historial_modelo
{
    private $DB;
    private $hitorial;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->DB_QUERY   = new query_modelo;
        $this->DB_QUERY1   = new query_modelo;
        $this->DB_QUERY2   = new query_modelo;
        $this->DB_QUERY3   = new query_modelo;
        $this->hitorial = array();
    }

    /*////////////////////////////////consulta//////////////////////////////////////////////////*/

    public function obtener_filtro_cliente(){
        $query="CALL obtenerCliente(".$_SESSION["id_usu_credit"].")";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    public function ver($params){

        $query="SELECT 
                CONCAT_WS (' ',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,
                press.valor_cuotas_pres as couta,
                logPrestamo.valor_pres_logp as pago,
                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,
                press.valor_pres as debe,
                logPrestamo.id_logp as idPres,
                rh.cumplimineto_rutaH as cumplimiento,
                diasvTable.diasV
                FROM tbl_ruta_historial as rh
                INNER JOIN tbl_cliente AS clien ON (clien.id_clie=rh.id_clien)
                INNER JOIN tbl_prestamo AS press ON (rh.id_pres=press.id_pres)
                LEFT JOIN tbl_log_prestamo as logPrestamo  ON (logPrestamo.id_logp=rh.id_log_pres_rutaH)
                LEFT JOIN (
                    SELECT count(tbl_ruta_historial.id_rutaH) AS diasV,tbl_ruta_historial.id_clien,tbl_ruta_historial.cumplimineto_rutaH 
                    FROM tbl_ruta_historial
                    WHERE tbl_ruta_historial.cumplimineto_rutaH=0 
                    GROUP BY tbl_ruta_historial.id_clien) as diasvTable ON (diasvTable.id_clien=clien.id_clie)
                WHERE clien.id_usu=".$_SESSION["id_usu_credit"];

        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND clien.id_clie = ".$params['Nombre'];
        }
        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND clien.documento_clie = ".$params['Cedula'];
        }

        $query.=" ORDER BY clien.orden_ruta_clie ASC";

        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }
}