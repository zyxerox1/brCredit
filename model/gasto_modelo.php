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
        if($img_name==1){
            $img_name=date("YmdHis")."_".$_SESSION["id_usu_credit"].".png";
            $data["img"]=$img_name;
        }else{
            $img_name='usuario.jpg';
            $data["img"]=1;
        }
        $query = "INSERT INTO `tbl_gasto` (`id_gas`, `valor_gas`, `fecha_gas`, `evidencia_gas`, `nota_gas`, `id_usu`) VALUES (NULL, '$valor', now(), '$img_name', '$nota', '".$_SESSION["id_usu_credit"]."')";

        $id=$this->DB_QUERY->save($query,'Creaciòn de gasto propio del vendedor.');
        $this->log_gasto(0,$id);
        return array('control' =>$data["img"] ,'error' => 0);
    }
}