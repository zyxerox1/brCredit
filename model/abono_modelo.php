<?php
require_once 'model/cliente_modelo.php';

class abono_modelo
{
    private $DB;
    private $abono;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->DB_QUERY   = new query_modelo;
        $this->DB_QUERY1   = new query_modelo;
        $this->DB_QUERY2   = new query_modelo;
        $this->cliente  = new cliente_modelo();
        $this->abono = array();
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


    public function obtener_cliente($params){

        $query="SELECT clien.id_clie as id, 
                       clien.documento_clie as CC, 
                      CONCAT_WS (' ',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,
                      clien.telefono_1_clie as t1, 
                      clien.telefono_2_clie as t2,
                      clien.correo_clie as Correo,
                      clien.documento_clie as Direcionr,
                      clien.documento_ref_clie as Direcionc, 
                      if(pres.valor_pres IS NOT NULL,pres.valor_pres,0) as valorDeuda,
                      if(pres.id_pres IS NOT NULL,pres.id_pres,0) as id_cobro,
                      pres.id_pres as idPres,
                      clien.cumplimineto_client as cumplimiento,
                      logPres.id_logp as codAtual
                      FROM tbl_cliente as clien 
                      LEFT JOIN tbl_prestamo as pres on (pres.id_clie=clien.id_clie AND (pres.valor_pres>0)) 
                      LEFT JOIN tbl_log_prestamo as logPres ON (DATE_FORMAT(logPres.fecha_logp, '%Y-%c-%d') =DATE_FORMAT(now(), '%Y-%c-%d') AND logPres.apuntadaor_prestamo_logp=0 AND pres.id_pres=logPres.id_pres)
                      WHERE pres.valor_pres>0 AND clien.id_usu = ".$_SESSION["id_usu_credit"];
        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND clien.id_clie = ".$params['Nombre'];
        }
        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND clien.documento_clie = ".$params['Cedula'];
        }

        $query.=" GROUP BY clien.id_clie ORDER BY clien.orden_ruta_clie ASC";

        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }
 
    function DataCliente ($params){
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

    /*////////////////////////////////atualizar//////////////////////////////////////////////////*/
    
    public function abonar($tipo,$idPres,$nota,$valor,$latitud,$longitud,$codAtual){

        $data = array();
        $valorAtualizar="";
        $query="";
        $query1="";

        $query="SELECT pres.valor_pres,pres.valor_cuotas_pres,pres.id_clie,client.cumplimineto_client, logPres.id_logp,logPres.valor_pres_logp
                      FROM tbl_prestamo as pres
                      INNER JOIN tbl_cliente as client ON (client.id_clie=pres.id_clie) 
                      LEFT JOIN tbl_log_prestamo as logPres ON (DATE_FORMAT(logPres.fecha_logp, '%Y-%c-%d') =DATE_FORMAT(now(), '%Y-%c-%d') AND logPres.apuntadaor_prestamo_logp=0 AND pres.id_pres=logPres.id_pres)
                      WHERE pres.id_pres=".$idPres;
        $data=$this->DB_QUERY->query($query);

        //actualizacion del abono
        if($data[0]['cumplimineto_client']!=0){
            if($data[0]['id_logp']==$codAtual){
                $data[0]['valor_pres']=$data[0]['valor_pres']+$data[0]['valor_pres_logp'];
                //validacion de tipo
                if($tipo==0){
                    $valorAtualizar=$data[0]['valor_pres']-$data[0]['valor_cuotas_pres'];
                    $valor=$data[0]['valor_cuotas_pres'];
                }else if($tipo==1){
                    $valorAtualizar=$data[0]['valor_pres']-$valor;
                }
                //fin validacion de tipo
                $query = "UPDATE tbl_prestamo SET valor_pres='$valorAtualizar' WHERE id_pres =".$idPres;                
            }else{
                //return array('error' => 1,"mensaje"=>"Ya hizo el abono de este vendedor hoy, puede editarlo en le historial" ); 
                return array('error' => 1,"mensaje"=>"Error desconocido" );  
            }

            $id=$this->log_abono(2,$idPres,$data[0]['id_clie'],$nota,$valor,$tipo,$latitud,$longitud);
            $query1 = "UPDATE tbl_cliente SET cumplimineto_client = '$id' WHERE id_clie =".$data[0]['id_clie'];

            $query2 = "UPDATE tbl_log_prestamo SET apuntadaor_prestamo_logp = '$id' WHERE id_logp =".$data[0]['id_logp'];

            $this->cliente->log_cliente(5,$data[0]['id_clie']);
            $this->DB_QUERY->save($query,'ACTUALIZAR ABONO.');
            $this->DB_QUERY1->save($query1,'ACTUALIZAR ABONO cliente.');
            $this->DB_QUERY2->save($query2,'ACTUALIZAR LOG ABONO.');
        }else{
            //REGISTRAR ABONO
            if(count($data)>0){
                if(isset($data[0]['valor_pres']) && $data[0]['valor_pres']!=0){
                    //validacion de tipo
                    if($tipo==0){
                        $valorAtualizar=$data[0]['valor_pres']-$data[0]['valor_cuotas_pres'];
                        $valor=$data[0]['valor_cuotas_pres'];
                    }else if($tipo==1){
                        $valorAtualizar=$data[0]['valor_pres']-$valor;
                    }
                    if($valorAtualizar<0){
                        return array('error' => 1,"mensaje"=>"El valor sobrepasa la deuda" );
                    }
                    //fin validacion de tipo
                    $query = "UPDATE tbl_prestamo SET valor_pres='$valorAtualizar' WHERE id_pres =".$idPres;
                    
                }else{
                    return array('error' => 1,"mensaje"=>"Error a tratar abonar al cliente" ); 
                }
            }else{
               return array('error' => 1,"mensaje"=>"Error a tratar abonar al cliente" ); 
            }

            $id=$this->log_abono(1,$idPres,$data[0]['id_clie'],$nota,$valor,$tipo,$latitud,$longitud);
            $query1 = "UPDATE tbl_cliente SET cumplimineto_client = '$id' WHERE id_clie =".$data[0]['id_clie'];
            $this->cliente->log_cliente(4,$data[0]['id_clie']);
            $this->DB_QUERY->save($query,'Abonar.');
            $this->DB_QUERY1->save($query1,'Abonar cliente.');
        }

        return array('error' => 0); 
    }
}