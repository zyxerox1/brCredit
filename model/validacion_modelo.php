<?php
class validacion_modelo
{
    private $DB;
    private $user;
    private $valores;

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

    public function valorMaximoMinimo($id){
        $this->valores = array();
        $query = $this->DB->query("SELECT prestamo_minimo_client,prestamo_maximo_client FROM tbl_cliente WHERE id_clie  = '$id'");
        while ($fila = $query->fetch_assoc()) {
            $this->valores[] = $fila;
        }
        return $this->valores;
    }

    public function idMax(){
        $this->valores = array();
        $query = $this->DB->query("SELECT max(id_usu) as max FROM tbl_usuarios");
        while ($fila = $query->fetch_assoc()) {
            $this->valores[] = $fila;
        }
        return $this->valores;
    }
    
}