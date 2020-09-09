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
        $query="CALL obtenerCliente()";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    public function ver($params){

        $query="SELECT
                     CONCAT_WS (' ',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,
                     press.valor_cuotas_pres as couta,
                    logPrestamo.valor_pres_logp as pago,
                    (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,
                    pressValor.pagado,
                    press.valor_pres as debe
                    FROM tbl_log_prestamo as logPrestamo 
                    INNER JOIN tbl_cliente AS clien ON (clien.id_clie=logPrestamo.id_clie)
                    INNER JOIN tbl_prestamo AS press ON (press.id_pres=logPrestamo.id_pres)
                    LEFT JOIN (SELECT SUM(tbl_log_prestamo.valor_pres_logp) AS pagado, tbl_log_prestamo.id_clie,tbl_log_prestamo.id_pres FROM tbl_log_prestamo GROUP BY tbl_log_prestamo.id_clie,tbl_log_prestamo.id_pres ) AS pressValor ON (pressValor.id_pres=logPrestamo.id_pres AND pressValor.id_clie=logPrestamo.id_clie) ";

        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND clien.id_clie = ".$params['Nombre'];
        }
        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND clien.documento_clie = ".$params['Cedula'];
        }

        $query.="ORDER BY clien.orden_ruta_clie ASC";

        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->query($query);
        return array('error' => 0,"data"=>$data );
    }
}