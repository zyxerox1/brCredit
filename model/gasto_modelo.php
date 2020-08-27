<?php
class gasto_modelo
{
    private $DB;
    private $LOG;
    private $data;
    private $DB_QUERY;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->DB_QUERY   = new query_modelo;
        $this->LOG   = new log_controller();
        $this->data = array();
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
        mysqli_query($this->DB, $query) or die('501' . $this->LOG->log_errores('Creacion de tipo vendedor /-/ consulta='.$query,mysqli_error($this->DB)));
        return array('control' =>$data["img"] ,'error' => 0);
    }
}