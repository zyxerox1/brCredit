<?php
require_once 'model/prestamo_modelo.php';

class prestamo_controller
{
    private $prestamo;
    private $validacion;

    public function __construct()
    {
        $this->prestamo  = new prestamo_modelo();
        $this->validacion  = new validaciones_controller();
    }

    public function save()
    {   
        $this->validacion->validarRol(2);
        $errores=[];
        $Valorc=0;
        $interes=0;
        $valorInteres=0;

        if(!isset($_POST['id']) || $_POST['id']=="" || $_POST['id']==0){
          return array('control' =>"1" ,'error' =>"Error desconocido, por favor comuniquese con el administrador.");
        }

        if($_POST['FechaLimit']==""){
          $errores[] = array('control' =>"FechaLimit" ,'error' =>"La fecha limita no puede esta vacia.");
        }

        //if($_POST['Formap']==""){
          //$errores[] = array('control' =>"Formap" ,'error' =>"Tiene que escoger una forma de pago.");
        //}

        if($_POST['Valor']==""){
          $errores[] = array('control' =>"Valor" ,'error' =>"El valor no puede esta vacio.");
        }else{
            $_POST['Valor']= preg_replace('/[.,]/', '', $_POST['Valor']);
            if($this->validacion->soloNumeros($_POST['Valor'])==false){
              $errores[] = array('control' =>"Valor" ,'error' =>"El campo valor solo debe contener numeros");
            }
            if($this->validacion->valorMaximoMinimo($_POST['Valor'],$_POST['id'])==false){
              $errores[] = array('control' =>"Valor" ,'error' =>"El campo esta fuera de rango");
            }
        }

        if($_POST['ncoutas']==""){
          $errores[] = array('control' =>"ncoutas" ,'error' =>"El numero de couta no puede esta vacio.");
        }else{
            if($this->validacion->soloNumeros($_POST['ncoutas'])==false){
              $errores[] = array('control' =>"ncoutas" ,'error' =>"El numero de couta solo debe contener numeros");
            }
        }

        /*if($_POST['Valorc']==""){
          $errores[] = array('control' =>"Valorc" ,'error' =>"El valor de couta no puede esta vacio.");
        }else{
            $_POST['Valorc']= preg_replace('/[.,]/', '', $_POST['Valorc']);
            if($this->validacion->soloNumeros($_POST['Valorc'])==false){
              $errores[] = array('control' =>"Valorc" ,'error' =>"El campo valor couta solo debe contener numeros");
            }
        }*/

        if(count($errores)==0){
            $interes=($_POST['inter']*$_POST['Valor'])/100;
            $valorInteres= $interes+$_POST['Valor'];
            $Valorc= $valorInteres/$_POST['ncoutas'];
            $errores = $this->prestamo->crear_prestamo($_POST['FechaLimit'],1, $_POST['Valor'], $_POST['ncoutas'], $Valorc, $_POST['inter'], $_POST['id'],$valorInteres);
        }
        echo json_encode($errores);  
    }
}