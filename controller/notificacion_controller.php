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
            $query="SELECT * FROM `tbl_notificaciones` WHERE tipo_noti=1 and id_usu_destinatario_noti=".$_SESSION["id_usu_credit"]."  order by id_noti desc limit 20";
            
        }else if($_SESSION["rol"]==2){
            $query="SELECT * FROM `tbl_notificaciones` WHERE tipo_noti=2 and id_usu_destinatario_noti=".$_SESSION["id_usu_credit"]."  order by id_noti desc limit 20";
            
        }
        
        $data=$this->DB_QUERY->query($query);
        $query="UPDATE `tbl_notificaciones` SET `leido_noti` = '1' WHERE leido_noti=0 and id_usu_destinatario_noti=".$_SESSION["id_usu_credit"];
        $this->DB_QUERY->save($query);
        $this->DB_QUERY->commit();
        echo json_encode($data);
    }

    public function obtenerNotif()
    {   
        $query="";
        if($_SESSION["rol"]==1){
            $query="SELECT * FROM `tbl_notificaciones` WHERE tipo_noti=1 and id_usu_destinatario_noti=".$_SESSION["id_usu_credit"]."  order by id_noti desc limit 20";
            
        }else if($_SESSION["rol"]==2){
            $query="SELECT * FROM `tbl_notificaciones` WHERE tipo_noti=2 and id_usu_destinatario_noti=".$_SESSION["id_usu_credit"]."  order by id_noti desc limit 20";
            
        }
        
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    public function gnotifiacionesSave($remitente,$tipo,$mensaje="",$title="",$id_usu_destinatario_noti=0)
    {
      $this->DB_QUERY->begin();
      //administrador
      if($tipo==1){
        $query="SELECT id_usu FROM `tbl_usuarios` WHERE rol_usu=1";
        $data=$this->DB_QUERY->query($query);
        if(count($data)>0){
          $query = "INSERT INTO tbl_notificaciones (id_noti, id_usu_remitente_noti, id_usu_destinatario_noti, tipo_noti, leido_noti, fecha_noti, mensaje_noti,tittle_noti) VALUES ";
            foreach ($data as $key => $value) {

              $query .="(null, $remitente,".$data[0]['id_usu'].",'$tipo','0', now(), '$mensaje','$title'),";
            }
            $query=substr($query, 0, -1);
            $query.=";";
            $id=$this->DB_QUERY->save($query,'Registrar notificaciones');
        }
      }else//vendedor
      if($tipo==2){
        $id_usu=0;
        $data=array();
        if($id_usu_destinatario_noti==0){
            $query="SELECT id_usu FROM `tbl_usuarios` WHERE rol_usu=2";
            $data=$this->DB_QUERY->query($query);
        }else{
            $id_usu=$id_usu_destinatario_noti;
            $data[0] = array('id_usu' => $id_usu_destinatario_noti);
        }
        
        if(count($data)>0 || $id_usu_destinatario_noti!=0){
          $query = "INSERT INTO tbl_notificaciones (id_noti, id_usu_remitente_noti, id_usu_destinatario_noti, tipo_noti, leido_noti, fecha_noti, mensaje_noti,tittle_noti) VALUES ";
            foreach ($data as $key => $value) {

              $query .="(null, $remitente,".$data[0]['id_usu'].",'$tipo','0', now(), '$mensaje','$title'),";
            }
            $query=substr($query, 0, -1);
            $query.=";";
            $id=$this->DB_QUERY->save($query,'Registrar notificaciones');
        }
      }
      $this->DB_QUERY->commit();
      return false;
    }
}
