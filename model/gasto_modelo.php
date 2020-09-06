<?php
class gasto_modelo
{
    private $DB;
    private $data;
    private $DB_QUERY;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->DB_QUERY   = new query_modelo;
        $this->DB_QUERY1   = new query_modelo;
        $this->data = array();
    }

    /*/////////////////////////////////////////////guardar///////////////////////////////////*/

      public function log_gasto($movimiento="",$id="",$nota=""){
        /*parametro de errores{*/
        $controller="";
        $accion_func="";
        if(isset($_REQUEST['c'])){
            $controller=$_REQUEST['c'];
        }
        if(isset($_REQUEST['a'])){
            $accion_func=$_REQUEST['a'];
        }

        $query = "CALL logGasto('$movimiento','$id','$controller',".$_SESSION["id_usu_credit"].",'$accion_func')";
        $this->DB_QUERY->save($query);
    }


    public function crear_gasto($Tipo, $valor, $nota,$img_name){
        $data = array();
        $img="";

        if($img_name!=""){
            $img=date("YmdHis")."_".$_SESSION["id_usu_credit"].'.'.$img_name;
            $data["img"]=$img;
        }else{
            $img='evidencia.png';
            $data["img"]=1;
        }
       
        $query = "INSERT INTO `tbl_gasto` (`id_gas`, `valor_gas`, `fecha_gas`, `evidencia_gas`, `nota_gas`, `id_usu`,id_tipo_tipog) VALUES (NULL, '$valor', now(), '$img', '$nota', '".$_SESSION["id_usu_credit"]."','$Tipo')";

        $id=$this->DB_QUERY->save($query,'Creaciòn de gasto propio del vendedor.');
        $this->log_gasto(0,$id);
        return array('control' =>$data["img"] ,'error' => 0);
    }

    /*///////////////////////////////consulta////////////////////////////*/


    public function query_usuario(){
        $query="CALL obtenerUsuarioCoordinador(".$_SESSION["rol"].")";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    public function obtenerGasto(){
        $suma="";
        $query="CALL obtenerGasto(".$_REQUEST["id"].")";
        $data=$this->DB_QUERY->query($query);
        if(isset($data[0]["id_usu"])){
            $query="CALL obtenerSumaGastosUsuario(".$data[0]["id_usu"].")";
            $suma=$this->DB_QUERY1->query($query);
        }
        return array('data' => $data,'suma' => $suma );
    }

    public function cargarGastos($params){
        $query='SELECT 
                usu.documento_usu as cc, 
                CONCAT_WS (" ",usu.primer_nombre_usu,usu.segundo_nombre_usu,usu.primer_apellido_usu,usu.segundo_apellido_usu) as nombre,
                CONCAT_WS(" - ",usu.telefono_1_usu,usu.telefono_2_usu) as telefono,
                usu.correo_usu as correo,
                gasto.valor_gas as valor,
                if(tg.nombre_tipog is not null,tg.nombre_tipog,"Este tipo fue borrado o huno un error.") as tipo,
                gasto.nota_gas as detalle,
                gasto.fecha_gas as fecha,
                gasto.evidencia_gas as evidencia,
                gasto.id_gas as id,
                gasto.estado_gas as estado
                FROM tbl_gasto as gasto
                INNER JOIN tbl_usuarios as usu on (usu.id_usu=gasto.id_usu)
                INNER JOIN tbl_log_gasto as log on (gasto.id_gas=log.id_gas)
                LEFT JOIN tbl_tipo_gasto as tg on (tg.id_tipog=gasto.id_tipo_tipog)
                WHERE 1';

     
        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND usu.id_usu = ".$params['Nombre'];
        }
        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND usu.documento_usu = ".$params['Cedula'];
        }
        if(isset($params['Fecha_fin']) && $params['Fecha_fin']!=""){
            $query.=" AND gasto.fecha_gas <= '".$params['Fecha_fin']."'";
        }
        if(isset($params['Fecha_ini']) && $params['Fecha_ini']!=""){
            $query.=" AND gasto.fecha_gas >= '".$params['Fecha_ini']."'";
        }
        if(isset($params['Valor_max']) && $params['Valor_max']!=""){
            $query.=" AND gasto.valor_gas <= '".$params['Fecha_fin']."'";
        }
        if(isset($params['Valor_mini']) && $params['Valor_mini']!=""){
            $query.=" AND gasto.valor_gas >= '".$params['Fecha_ini']."'";
        }


        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }

    public function cargarMiGastos($params){
        $query='SELECT 
                gasto.valor_gas as valor,
                if(tg.nombre_tipog is not null,tg.nombre_tipog,"Este tipo fue borrado o huno un error.") as tipo,
                gasto.nota_gas as detalle,
                gasto.fecha_gas as fecha,
                gasto.evidencia_gas as evidencia,
                gasto.id_gas as id,
                gasto.estado_gas as estado
                FROM tbl_gasto as gasto
                LEFT JOIN tbl_tipo_gasto as tg on (tg.id_tipog=gasto.id_tipo_tipog)
                WHERE gasto.id_usu='.$_SESSION["id_usu_credit"];

        if(isset($params['Fecha_fin']) && $params['Fecha_fin']!=""){
            $query.=" AND gasto.fecha_gas <= '".$params['Fecha_fin']."'";
        }
        if(isset($params['Fecha_ini']) && $params['Fecha_ini']!=""){
            $query.=" AND gasto.fecha_gas >= '".$params['Fecha_ini']."'";
        }

        if(isset($params['Valor_max']) && $params['Valor_max']!=""){
            $params['Valor_max']= preg_replace('/[.,]/', '', $params['Valor_max']);
            $query.=" AND gasto.valor_gas <= '".$params['Valor_max']."'";
        }
        if(isset($params['Valor_mini']) && $params['Valor_mini']!=""){
            $params['Valor_mini']= preg_replace('/[.,]/', '', $params['Valor_mini']);
            $query.=" AND gasto.valor_gas >= '".$params['Valor_mini']."'";
        }


        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";
      
        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }

    

    public function cambiarEstado($params,$tipo){
        if($tipo==3){
            $query="SELECT estado_gas FROM `tbl_gasto` WHERE id_gas=".$params['id'];
            $data=$this->DB_QUERY1->query($query);
            if($data[0]['estado_gas']!=0){
                return array('control' =>'Este gasto no se puede anular.' ,'error' =>1 );
            }
        }
        $query = "UPDATE `tbl_gasto` SET `estado_gas` = '$tipo' WHERE `tbl_gasto`.`id_gas` = ".$params['id'];
        $id=$this->DB_QUERY->save($query,'Cambio de estado a '.$tipo.".");
        $this->log_gasto($tipo,$params['id']);
        return array('control' =>0 ,'error' => 0);
    }
    
    
}