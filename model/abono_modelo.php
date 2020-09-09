<?php
class abono_modelo
{
    private $DB;
    private $abono;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->DB_QUERY   = new query_modelo;
        $this->abono = array();
    }

    /*/////////////////////////////////////////////guardar///////////////////////////////////*/
    public function log_abono($movimiento="",$id="",$id_clie,$nota="",$valor,$tipo){

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

        $query = "CALL logPrestamo('$movimiento','$id','$controller',".$_SESSION["id_usu_credit"].",'$accion_func','$id_clie','$nota','$valor','$tipo')";

        $this->DB_QUERY->save($query);
    }

    /*////////////////////////////////consulta//////////////////////////////////////////////////*/
    public function obtener_filtro_cliente(){
        $query="CALL obtenerCliente()";
        $data=$this->DB_QUERY->query($query);
        return $data;
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
                      pres.id_pres idPres
                      FROM tbl_cliente as clien 
                      LEFT JOIN tbl_prestamo as pres on (pres.id_clie=clien.id_clie AND (pres.valor_pres>0)) 
                      WHERE pres.valor_pres>0 ";
        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND clien.id_clie = ".$params['Nombre'];
        }
        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND clien.documento_clie = ".$params['Cedula'];
        }

        $query.="ORDER BY clien.orden_ruta_clie ASC";

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
                LEFT JOIN tbl_log_prestamo AS logPresCliente ON (logPresCliente.id_clie=cliente.id_clie)
                INNER JOIN tbl_prestamo as pres ON (cliente.id_clie=pres.id_clie AND pres.valor_pres>0)
                WHERE prestamos.valor_pres>0 AND cliente.id_clie=".$params['id'];
        $data=$this->DB_QUERY->query($query);
        return array('error' => 0,'data'=>$data);
    }

    /*////////////////////////////////atualizar//////////////////////////////////////////////////*/
    
    public function abonar($tipo,$idPres,$nota,$valor){

        $data = array();
        $valorAtualizar="";
        $query="";

        $query="SELECT pres.valor_pres,pres.valor_cuotas_pres,pres.id_clie
                      FROM tbl_prestamo as pres 
                      WHERE pres.id_pres=".$idPres;
        $data=$this->DB_QUERY->query($query);


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

        $this->log_abono(1,$idPres,$data[0]['id_clie'],$nota,$valor,$tipo);
        $this->DB_QUERY->save($query,'Abonar.');
        return array('error' => 0); 
    }
}