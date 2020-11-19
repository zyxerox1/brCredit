<?php

class notificacion_controller
{
    private $model;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->DB_QUERY   = new query_modelo;
    }

    public function index()
    {   
        $this->DB_QUERY->begin();
        $query="";
        if($_SESSION["rol"]==1){
            $query="SELECT * FROM `tbl_notificaciones` WHERE tipo_noti=1 and id_usu_destinatario_noti=".$_SESSION["id_usu_credit"];
            
        }else if($_SESSION["rol"]==2){
            $query="SELECT * FROM `tbl_notificaciones` WHERE tipo_noti=2 and id_usu_destinatario_noti=".$_SESSION["id_usu_credit"];
            
        }
        
        $data=$this->DB_QUERY->query($query);
        $query="UPDATE `tbl_notificaciones` SET `leido_noti` = '1' WHERE leido_noti=0 and id_usu_destinatario_noti=".$_SESSION["id_usu_credit"];
        $this->DB_QUERY->save($query);
        $this->DB_QUERY->commit();
        echo json_encode($data);
    }
}
