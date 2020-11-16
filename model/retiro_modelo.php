<?php
class retiro_modelo
{
    private $data;
    private $DB_QUERY;

    public function __construct()
    {
        $this->DB_QUERY   = new query_modelo;
        $this->DB_QUERY1   = new query_modelo;
        $this->data = array();
    }
    /*///////////////////////////////save///////////////////////////////*/
    public function Registrar($codigo,$valorRetiro,$descripcion,$latitud,$longitud){
        $this->DB_QUERY->begin();
        $saldoAtualizar=0;
        $query="SELECT id_usu,id_caja,saldo_caja FROM tbl_caja WHERE id_usu=".$codigo;
        $data=$this->DB_QUERY->query($query);
        if(count($data)<=0){
            return array('control' =>"valorRetiro",'error' =>"No se encontro la caja de la ruta.");
        }
        if($data[0]['saldo_caja']<$valorRetiro){
            return array('mensaje' =>"El valor supera el saldo actual de la caja de la ruta" ,'error' => 1);
        }

        $saldoAtualizar=$data[0]['saldo_caja']-$valorRetiro;
        $query="UPDATE tbl_caja SET saldo_caja = '$saldoAtualizar' WHERE id_usu =".$codigo;
        $id=$this->DB_QUERY->save($query,'Actualizar saldo de caja');

        $query="INSERT INTO tbl_retiro (id_ret, id_caja, id_usu, id_ruta_usu, descripcion_ret, valor_ret, latitud_ret, longitud_ret, fecha_ret) VALUES (NULL, '".$data[0]['id_caja']."', '".$_SESSION["id_usu_credit"]."', '$codigo', '$descripcion', '$valorRetiro', '$latitud', '$longitud', now());";
        $id=$this->DB_QUERY->save($query,'Registrar retiro');
        $this->DB_QUERY->commit();
        return array('control' =>0 ,'error' => 0);
    }

    /*///////////////////////////////consulta////////////////////////////*/

    public function obtenerReporte($params){
        $query="SELECT 
                LPAD(ret.id_ret,6,'0') as Retiro,
                ret.fecha_ret AS fecha,
                CONCAT_WS(' ',usu.primer_nombre_usu,usu.segundo_nombre_usu,usu.primer_apellido_usu,usu.segundo_apellido_usu) as Autor,
                ret.descripcion_ret as Descripcion,
                ret.valor_ret as Valor
            FROM tbl_retiro AS ret
            INNER JOIN tbl_usuarios AS usu ON (ret.id_usu=usu.id_usu)
            WHERE 1";

        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND usu.id_usu = ".$params['Nombre'];
        }
        if(isset($params['codigo']) && $params['codigo']!=0){
            $query.=" AND usu.id_ruta_usu = ".$params['codigo'];
        }
        if(isset($params['Fecha_fin']) && $params['Fecha_fin']!=""){
            $query.=" AND ret.fecha_ret  <= '".$params['Fecha_fin']."'";
        }
        if(isset($params['Fecha_ini']) && $params['Fecha_ini']!=""){
            $query.=" AND ret.fecha_ret  >= '".$params['Fecha_ini']."'";
        }
  
        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }

    public function query_usuario(){
        $query="CALL obtenerUsuario()";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    public function query_vendedor(){
        $query="CALL FiltroRuta()";
        $data=$this->DB_QUERY1->query($query);
        return $data;
    }
}