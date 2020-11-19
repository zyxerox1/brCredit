<?php
class notificaciones_modelo
{
    private $DB;
    private $notificaciones;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->DB_QUERY   = new query_modelo;
        $this->notificaciones = array();
    }

    /*/////////////////////////////////////////////guardar///////////////////////////////////*/
    public function gnotifiacionesSave($remitente,$tipo,$mensaje="",$title="")
    {
      $this->DB_QUERY->begin();
      //administrador
      if($tipo==1){
        $query="SELECT id_usu FROM `tbl_usuarios` WHERE rol_usu=1";
        $data=$this->DB_QUERY->query($query);
        if(count($data)>0){
          $query = "INSERT INTO tbl_notificaciones (id_noti, id_usu_remitente_noti, id_usu_destinatario_noti, tipo_noti, leido_noti, fecha_noti, mensaje_noti,tittle_noti) VALUES ";
            foreach ($data as $key => $value) {

              $query .="(null, $remitente,".$data[0]['id_usu'].",'$tipo','0', now(), '$mensaje'),";
            }
            $query=substr($query, 0, -1);
            $query.=";";
            $id=$this->DB_QUERY->save($query,'Registrar notificaciones');
        }
      }
      $this->DB_QUERY->commit();
      return false;
    }

      
    /*////////////////////////////////consulta//////////////////////////////////////////////////*/
     public function gnotifiacionObtane()
    {
        $query="SELECT * FROM `tbl_notificaciones` WHERE id_usu_destinatario_noti=".$_SESSION["id_usu_credit"];
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    /*////////////////////////////////atualizar//////////////////////////////////////////////////*/
    
}