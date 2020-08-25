<?php
require_once 'model/validacion_modelo.php';
class validaciones_controller
{
    private $sesion;
    public function __construct()
    {
         $this->model_l  = new validacion_modelo();
    }

    public function soloLetras($cadena){
        $resultado=false;
        if (preg_match("/^[A-Za-zñÑçÇáéóúíÁÉÓÚÍ]+$/", $cadena)>0){
            $resultado=true;
        } 
        return $resultado;
    }

     public function soloNumeros($cadena){
        $resultado=false;
        if (is_numeric($cadena)) {
            $resultado=true;
        } 
        return $resultado;
    }

    public function muyJovenDesarrollador($cadena){
        $resultado=false;
        $fecha_actual = date("d-m-Y");
        $fecha_actual = strtotime(date("d-m-Y",strtotime($fecha_actual."- 16 year")));

        if (strtotime($cadena)<$fecha_actual) {
            $resultado=true;
        } 
        return $resultado;
    }

     public function muyJoven($cadena){
        $resultado=false;
        $fecha_actual = date("d-m-Y");
        $fecha_actual = strtotime(date("d-m-Y",strtotime($fecha_actual."- 12 year")));

        if (strtotime($cadena)<$fecha_actual) {
            $resultado=true;
        } 
        return $resultado;
    }

    public function validar_nickname($cadena){
        $resultado=false;
        $nickname = $this->model_l->validar_nickname($cadena);
        if(count($nickname)<=0){
            $resultado=true;
        }
        return $resultado;
    }

    public function validar_correo($cadena){
        $resultado=false;
        $nickname = $this->model_l->validar_correo($cadena);
        if(count($nickname)<=0){
            $resultado=true;
        }
        return $resultado;
    }

    public function validar_correo_update($cadena,$validar_correo_update){
        $resultado=false;
        $nickname = $this->model_l->validar_correo_update($cadena,$validar_correo_update);
        if(count($nickname)==0){
            $resultado=true;
        }
        return $resultado;
    }

    public function validar_contraseña($p1,$p2){
        $resultado=false;
        if($p1==$p2){
            $resultado=true;
        }
        return $resultado;
    }

    public function validarRol($rol){
        if($_SESSION["rol"]!=$rol){
            require_once ACCESSO_DEGADO;
            exit();
        }
    }
}
