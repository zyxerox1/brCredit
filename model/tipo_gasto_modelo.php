<?php
class tipo_gasto_modelo
{
    private $LOG;
    private $data;
    private $DB_QUERY;

    public function __construct()
    {
        $this->DB_QUERY   = new query_modelo;
        $this->LOG   = new log_controller();
        $this->data = array();
    }

    /*/////////////////////////////////////////////guardar///////////////////////////////////*/

    public function log_tipo_gasto($movimiento="",$id="",$nota=""){
        /*parametro de errores{*/
        $controller="";
        $accion_func="";
        if(isset($_REQUEST['c'])){
            $controller=$_REQUEST['c'];
        }
        if(isset($_REQUEST['a'])){
            $accion_func=$_REQUEST['a'];
        }

        $query = "CALL logTipoGasto('$movimiento','$id','$controller',".$_SESSION["id_usu_credit"].",'$accion_func')";
        $this->DB_QUERY->save($query);
    }

    public function crear_tipo($tipo){
        $query="SELECT id_tipog AS id FROM tbl_tipo_gasto WHERE tipo_tipog=".$_SESSION["rol"]." AND nombre_tipog = '$tipo'";
        $data=$this->DB_QUERY->query($query);
        if(count($data)>0){
            return 3;
        }
        $query = "INSERT INTO tbl_tipo_gasto (id_tipog, nombre_tipog, tipo_tipog, id_usu) VALUES (NULL, '$tipo', '".$_SESSION["rol"]."', '".$_SESSION["id_usu_credit"]."')";
        $id=$this->DB_QUERY->save($query,'Creaciòn de tipo de gasto.');
        $this->log_tipo_gasto(0,$id);
    }

    /*/////////////////////////////////////////////consulta///////////////////////////////////*/
    public function obtener(){
        
        $query="SELECT id_tipog AS id, nombre_tipog as tipo FROM tbl_tipo_gasto WHERE id_usu=".$_SESSION["id_usu_credit"]." AND tipo_tipog = 2";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }
}