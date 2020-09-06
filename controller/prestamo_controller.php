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

        if(!isset($_POST['id']) || $_POST['id']=="" || $_POST['id']==0){
          return array('control' =>"1" ,'error' =>"Error desconocido, por favor comuniquese con el administrador.");
        }

        if($_POST['FechaLimit']==""){
          $errores[] = array('control' =>"FechaLimit" ,'error' =>"La fecha limita no puede esta vacia.");
        }

        if($_POST['Formap']==""){
          $errores[] = array('control' =>"Formap" ,'error' =>"Tiene que escoger una forma de pago.");
        }

        if($_POST['Valor']==""){
          $errores[] = array('control' =>"Valor" ,'error' =>"El valor no puede esta vacio.");
        }else{
            $_POST['Valor']= preg_replace('/[.,]/', '', $_POST['Valor']);
            if($this->validacion->soloNumeros($_POST['Valor'])==false){
              $errores[] = array('control' =>"Valor" ,'error' =>"El campo valor solo debe contener numeros");
            }
        }

        if($_POST['ncoutas']==""){
          $errores[] = array('control' =>"ncoutas" ,'error' =>"El numero de couta no puede esta vacio.");
        }else{
            if($this->validacion->soloNumeros($_POST['ncoutas'])==false){
              $errores[] = array('control' =>"ncoutas" ,'error' =>"El numero de couta solo debe contener numeros");
            }
        }
        

        if($_POST['Valorc']==""){
          $errores[] = array('control' =>"Valorc" ,'error' =>"El valor de couta no puede esta vacio.");
        }else{
            $_POST['Valorc']= preg_replace('/[.,]/', '', $_POST['Valorc']);
            if($this->validacion->soloNumeros($_POST['Valorc'])==false){
              $errores[] = array('control' =>"Valorc" ,'error' =>"El campo valor couta solo debe contener numeros");
            }
        }

        if(count($errores)==0){
            $errores = $this->prestamo->crear_prestamo($_POST['FechaLimit'], $_POST['Formap'], $_POST['Valor'], $_POST['ncoutas'], $_POST['Valorc'], $_POST['inter'], $_POST['id']);
            
        }
        echo json_encode($errores);  
    }
}