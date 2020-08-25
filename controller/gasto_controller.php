<?php
require_once 'model/gasto_modelo.php';
require_once 'controller/tipo_gasto_controller.php';

class gasto_controller
{
    private $gasto;
    private $tipo;

    public function __construct()
    {
        $this->gasto  = new gasto_modelo();
        $this->tipo  = new tipo_gasto_controller();
    }

    public function index()
    {
        if($_SESSION["rol"]==2){
            //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
            $c='gasto'; //carpeta;
            $p='gasto';//nombre del archivo js
            require_once HTML_DIR . 'overall/header.php';
            require_once HTML_DIR . 'overall/topNav.php';
            require_once HTML_DIR . 'gasto/gasto.php';
            require_once HTML_DIR . 'overall/footer.php';
        }
      
    }

    public function registrar()
    {
        if($_SESSION["rol"]==2){
            $dataTipo=$this->tipo->obtener();
            //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
            $c='gasto'; //carpeta;
            $p='registrar';//nombre del archivo js
            require_once HTML_DIR . 'overall/header.php';
            require_once HTML_DIR . 'overall/topNav.php';
            require_once HTML_DIR . 'gasto/registrar.php';
            require_once HTML_DIR . 'gasto/modal_registrar.php';
            require_once HTML_DIR . 'overall/footer.php';
        }
      
    }

    public function save()
    {
        $errores=[];
        $img_name=0;

        if(!isset($_POST['Tipo']) && $_POST['Tipo']==0){
           $errores[] = array('control' =>"Tipo" ,'error' =>"Tiene que selecionar un tipo, si no lo encuentra el tipo de gasto puede crear uno"  );
        }
        if ($_POST['valor']=="") {
            $errores[] = array('control' =>"valor" ,'error' => "Tiene que ingresar un valor"  );
        }else{
            $_POST['valor']= trim($_POST['valor'], ",");
        }
        if($_POST['nota']==""){
           $errores[] = array('control' =>"nota" ,'error' =>"Tiene que ingresar un detalle"  );
        }

        if(isset($_FILES["img"])){
          $img_name=1;
        } 

        if(count($errores)==0){
            $result_editar_usuario=  $this->gasto->crear_gasto($_POST['Tipo'], $_POST['valor'], $_POST['nota'],$img_name);

            if (isset($result_editar_usuario["control"]) && $result_editar_usuario["control"] !=1) {
              move_uploaded_file($_FILES['img']['tmp_name'], "view/assets/imagenes_usuario/".$result_editar_usuario["control"]);
            }
          $errores=array('control' =>0 ,'error' => 0);
        }
        echo json_encode($errores);  
    }

    public function cerrar(){
        session_destroy();
        header('location:index.php?c=home');
    }
}