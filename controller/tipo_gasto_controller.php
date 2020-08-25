<?php
require_once 'model/tipo_gasto_modelo.php';

class tipo_gasto_controller
{
    private $tipo;

    public function __construct()
    {
        $this->tipo  = new tipo_gasto_modelo();
    }

    public function save()
    {   
        $errores=[];
        if(!isset($_POST['aceptar'])){
           $errores[] = array('control' =>"aceptar" ,'error' =>"Para crear un nuevo tipo tiene que aceptar la codiciones.<br>"  );
        }

        if(count($errores)==0){
            $result_editar_usuario=  $this->tipo->crear_tipo($_POST['tipo']);
            $errores=array('control' =>0 ,'error' => 0);
        }
        echo json_encode($errores);  
    }

    public function obtener()
    {   
        $data = $this->tipo->obtener();
        return $data;
    }


    public function cerrar(){
        session_destroy();
        header('location:index.php?c=home');
    }
}