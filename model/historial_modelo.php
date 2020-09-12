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

    /*/////////////////////////////////////////////guardar///////////////////////////////////*/
    public function log_abono($movimiento="",$id="",$id_clie,$nota="",$valor,$tipo,$latitud,$longitud){

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

        $query="INSERT INTO `tbl_log_prestamo` (`id_logp`, `movimiento_logp`, `fecha_logp`, `id_pres`, `controller_logp`, `id_autor_usu`, `accion_func_logp`,id_clie,nota_logp,valor_pres_logp,forma_pago_logp,latitud_logp,longitud_logp,ip_logp) VALUES (NULL, '$movimiento', now(), '$id', '$controller', ".$_SESSION["id_usu_credit"].",'$accion_func','$id_clie','$nota','$valor','$tipo','$latitud','$longitud','$ip');";

        $id=$this->DB_QUERY->save($query);
        return $id;
    }


    /*////////////////////////////////consulta//////////////////////////////////////////////////*/

    public function obtener_filtro_cliente(){
        $query="CALL obtenerCliente(".$_SESSION["id_usu_credit"].")";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    function getRealIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
    }

    public function ver($params){

        $query="SELECT 
                CONCAT_WS (' ',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,
                press.valor_cuotas_pres as couta,
                logPrestamo.valor_pres_logp as pago,
                (SELECT SUM(tbl_prestamo.valor_pres) FROM tbl_prestamo WHERE tbl_prestamo.id_clie=clien.id_clie) as tVenta,
                press.valor_pres as debe,
                logPrestamo.id_logp as idPres,
                press.id_pres as idPrestamos,
                rh.cumplimineto_rutaH as cumplimiento,
                if(diasvTable.diasV IS null,0,diasvTable.diasV) AS diasV,
                clien.id_clie as idClie,
                rh.id_rutaH AS idRuta
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

        $query.=" ORDER BY rh.fecha_rutaH ASC";

        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }

    public function DataCliente ($params){
        $query="SELECT 
                cliente.id_clie AS nPrestamo,
                CONCAT('$','R ',sum(prestamos.valor_pres)) AS totalVenta,
                IF(logPresCliente.valor_pres_logp IS NULL,CONCAT('$','R ',0), CONCAT('$','R  ',sum(logPresCliente.valor_pres_logp))) AS totalPagado,
                CONCAT('$','R ',pres.valor_pres) AS debe,
                COUNT(logPresCliente.id_logp)+1 AS nCouta,
                CONCAT('$','R ',pres.valor_cuotas_pres) AS valorPagar,
                CONCAT_WS (' ',cliente.primer_nombre_clie,cliente.segundo_nombre_clie,cliente.primer_apellido_clie,cliente.segundo_apellido_clie) as nombre,
                cliente.foto_clie as foto
                FROM tbl_cliente as cliente
                INNER JOIN tbl_prestamo as prestamos ON (cliente.id_clie=prestamos.id_clie)
                LEFT JOIN tbl_log_prestamo AS logPresCliente ON (logPresCliente.id_clie=cliente.id_clie AND logPresCliente.movimiento_logp=1)
                INNER JOIN tbl_prestamo as pres ON (cliente.id_clie=pres.id_clie AND pres.valor_pres>0)
                WHERE prestamos.valor_pres>0 AND cliente.id_clie=".$params['id'];
        $data=$this->DB_QUERY->query($query);
        return array('error' => 0,'data'=>$data);
    }

    public function abonarRegistrar($idPres,$nota,$valor,$latitud,$longitud,$his){

        $data = array();
        $valorAtualizar="";
        $query="";
        $query1="";

        $query="SELECT pres.valor_pres,pres.valor_cuotas_pres,pres.id_clie,client.cumplimineto_client
                      FROM tbl_prestamo as pres
                      INNER JOIN tbl_cliente as client ON (client.id_clie=pres.id_clie) 
                      WHERE pres.id_pres=".$idPres;
        $data=$this->DB_QUERY->query($query);

        if(count($data)>0){
            if($data[0]['valor_pres']<=0){
                return array('error' => 1,"mensaje"=>"Este prestamo ya no esta vigente." ); 
            }
            $valorAtualizar=$data[0]['valor_pres']-$valor;
            if($valorAtualizar<0){
                return array('error' => 1,"mensaje"=>"El valor sobrepasa la deuda" );
            }
            $query = "UPDATE tbl_prestamo SET valor_pres='$valorAtualizar' WHERE id_pres =".$idPres;
        }

        $id=$this->log_abono(1,$idPres,$data[0]['id_clie'],$nota,$valor,3,$latitud,$longitud);

        $query2 = "UPDATE tbl_log_prestamo SET apuntadaor_prestamo_logp = '$id',movimiento_logp=3 WHERE id_logp =".$idPres;
        $query3 = "UPDATE tbl_ruta_historial SET cumplimineto_rutaH = '$id', id_log_pres_rutaH='$id'  WHERE id_rutaH =".$his;

        $this->DB_QUERY2->save($query2,'Editar abono.');
        $this->DB_QUERY->save($query,'Abonar.');
        $this->DB_QUERY1->save($query3,'editar historial.');
        return array('error' => 0); 
    }

    public function abonar ($idPres,$nota,$valor,$latitud,$longitud,$his){

        $data = array();
        $valorAtualizar="";
        $query="";
        $query1="";
        $total="";

        $query="SELECT pres.valor_pres,pres.valor_cuotas_pres,pres.id_clie,presLog.valor_pres_logp,pres.id_pres
                      FROM tbl_prestamo as pres
                      INNER JOIN tbl_log_prestamo as presLog ON (presLog.id_pres=pres.id_pres) 
                      WHERE presLog.id_logp=".$idPres;
        $data=$this->DB_QUERY->query($query);

        if(count($data)>0){
            if($data[0]['valor_pres']<=0){
                return array('error' => 1,"mensaje"=>"Este prestamo ya no esta vigente." ); 
            }
            $total=$data[0]['valor_pres']+$data[0]['valor_pres_logp'];
            $valorAtualizar=$total-$valor;
            if($valorAtualizar<0){
                return array('error' => 1,"mensaje"=>"El valor sobrepasa la deuda" );
            }
            $query = "UPDATE tbl_prestamo SET valor_pres='$valorAtualizar' WHERE id_pres =".$data[0]['id_pres'];
           
        }else{
           return array('error' => 1,"mensaje"=>"Error a tratar abonar al cliente." ); 
        }
        
        $id=$this->log_abono(1,$data[0]['id_pres'],$data[0]['id_clie'],$nota,$valor,3,$latitud,$longitud);

        $query2 = "UPDATE tbl_log_prestamo SET apuntadaor_prestamo_logp = '$id',movimiento_logp=3 WHERE id_logp =".$idPres;
        $query3 = "UPDATE tbl_ruta_historial SET cumplimineto_rutaH = '$id', id_log_pres_rutaH='$id' WHERE id_rutaH =".$his;
        $this->DB_QUERY2->save($query2,'Editar abono.');
        $this->DB_QUERY->save($query,'Abonar.');
        $this->DB_QUERY1->save($query3,'editar historial.');
        return array('error' => 0); 
        
    }
}