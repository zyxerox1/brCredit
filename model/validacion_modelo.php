<?php
class validacion_modelo
{
    private $DB;
    private $user;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->user = array();
    }

    public function validar_correo($cadena){
        $this->user = array();
        $query = $this->DB->query("SELECT id_usu FROM tbl_usuarios WHERE correo_usu = '$cadena'");
        while ($fila = $query->fetch_assoc()) {
            $this->user[] = $fila;
        }
        return $this->user;
    }

    public function validar_correo_update($cadena,$validar_correo_update){
        $this->user = array();
        $query = $this->DB->query("SELECT id_usu FROM tbl_usuarios WHERE correo_usu = '$cadena' AND id_usu!=$validar_correo_update");
        while ($fila = $query->fetch_assoc()) {
            $this->user[] = $fila;
        }
        return $this->user;
    }

    
}