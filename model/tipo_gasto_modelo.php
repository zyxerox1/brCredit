<?php
class tipo_gasto_modelo
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

    public function crear_tipo($tipo){
        $query = "INSERT INTO tbl_tipo_gasto (id_tipog, nombre_tipog, tipo_tipog, id_usu) VALUES (NULL, '$tipo', '1', '".$_SESSION["id_usu_credit"]."')";
        mysqli_query($this->DB, $query) or die('501' . $this->LOG->log_errores('Creacion de tipo vendedor /-/ consulta='.$query,mysqli_error($this->DB)));
    }

    public function obtener(){
        
        $query="SELECT id_tipog AS id, nombre_tipog as tipo FROM tbl_tipo_gasto WHERE id_usu=".$_SESSION["id_usu_credit"]." AND tipo_tipog = 1";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }
}