<?php
class login_modelo
{
    private $DB;
    private $user;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->DB_QUERY = new conexion;
        $this->user = array();
    }

    public function login($data, $pas,$email)
    {
        $nombre="";
        if($email==0){
            $query = $this->DB->query("CALL loginCorreo('$data')");
        }else{
            $query = $this->DB->query("CALL loginDocumento('$data')");
        }
 
        if ($fila = $query->fetch_object()) {
            if (password_verify($pas,$fila->contrasena_usu)) {
                $user[] = 4;
                $user[] = $fila->correo_usu;
                $user[] = $fila->id_usu;
                $nombre=$fila->primer_nombre_usu;
                if($fila->segundo_nombre_usu!=""){
                    $nombre=$nombre." ".$fila->segundo_nombre_usu;
                }
                $nombre=$nombre." ".$fila->primer_apellido_usu;
                if($fila->segundo_apellido_usu!=""){
                    $nombre=$nombre." ".$fila->segundo_apellido_usu;
                }
                $user[] = $nombre;
                $user[] = $fila->documento_usu;
                $user[] = $fila->rol_usu;
            } else {
                $user[] = 5; //Usuario valido, contraseña incorrecta
                $user[] = "";
            }
        } else {
            $user[] = 6; //Usuario no existe
            $user[] = "";
        }
        return $user;
    }
}
