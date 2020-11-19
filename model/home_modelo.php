<?php
require_once 'model/cerrar_modelo.php';
class home_modelo
{
    private $DB;
    private $LOG;
    private $data;
    private $DB_QUERY;
    private $cerrar;
    public function __construct()
    {
        $this->cerrar  = new cerrar_modelo();
        $this->DB_QUERY_HOME   = new query_modelo;
        $this->notificaciones  = new notificacion_controller();
        $this->data = array();
    }

    public function cerrar_dia($param){ 
        $nombre=$_SESSION["nombre"];
        $this->DB_QUERY_HOME->begin();
         $query = "UPDATE tbl_usuarios SET cerrar_usu = 1 WHERE tbl_usuarios.id_usu =".$_SESSION['id_usu_credit'];
        
        $this->notificaciones->gnotifiacionesSave($_SESSION['id_usu_credit'],1,"El vendedor $nombre cerro dia.","Un vendedor cerro dia");

        $id=$this->DB_QUERY_HOME->save($query,'Cerrar dia.');
        $this->cerrar->log_cerrar(0,$param["latitud"],$param["logitud"]);
        
        $this->DB_QUERY_HOME->commit();
        return array('control' =>0 ,'error' => 0);

    }
}