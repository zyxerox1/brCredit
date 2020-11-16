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

    public function valorMaximoMinimo($valor,$id){
        $resultado=false;
        $valores = $this->model_l->valorMaximoMinimo($id);
        if($valores[0]["prestamo_minimo_client"]<=$valor && $valores[0]["prestamo_maximo_client"]>=$valor){
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

    public function idMax(){
        $id = $this->model_l->idMax();
        return $id[0]['max'];
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
        if(is_array($rol)){
            if(!in_array($_SESSION["rol"],$rol)){
                require_once ACCESSO_DEGADO;
                exit();
            }
        }else{
            if($_SESSION["rol"]!=$rol){
                require_once ACCESSO_DEGADO;
                exit();
            }
        }

        $cierre = $this->model_l->validar_cierre();
        $_SESSION["cierre"]=$cierre[0]['cerrar'];
        if($cierre[0]['cerrar']!=0){
            $c='overall'; //carpeta;
            $p='script';//nombre del archivo js
            require_once HTML_DIR . 'overall/header.php';
            require_once HTML_DIR . 'overall/topNav.php';
            require_once HTML_DIR . 'overall/home.php';
            require_once HTML_DIR . 'overall/footer.php';
            echo "<script> ohSnap('El dia ya esta cerrado.',{color: 'red'}); </script>";
            exit();
        }
    }
}
