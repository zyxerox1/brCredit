<?php
require_once 'model/gasto_modelo.php';
require_once 'controller/tipo_gasto_controller.php';

class gasto_controller
{
    private $gasto;
    private $tipo;
    private $validacion;

    public function __construct()
    {
        $this->gasto  = new gasto_modelo();
        $this->tipo  = new tipo_gasto_controller();
        $this->validacion  = new validaciones_controller();
    }

    public function index()
    {
        $this->validacion->validarRol([2,1]);
       
        //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $c='gasto'; //carpeta;
        $p='';//nombre del archivo js
        $data_filtro="";
        if($_SESSION["rol"]==1){
            $p='gasto_coordinador';
            $data_filtro=$this->gasto->query_usuario($_REQUEST);
            $data_filtro_ruta=$this->gasto->obtenerFiltroRuta();
        }
         if($_SESSION["rol"]==2){
            $p='gasto_vendedor';
        }
        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'gasto/gasto.php';
        require_once HTML_DIR . 'gasto/gasto_modal.php';
        require_once HTML_DIR . 'gasto/modal_confirmacion.php';
        require_once HTML_DIR . 'gasto/modalAbono.php';
        require_once HTML_DIR . 'overall/footer.php';
      
    }

    public function registrar()
    {
        $this->validacion->validarRol(2);
        //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $c='gasto'; //carpeta;
        $p='registrar';//nombre del archivo js
        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'gasto/registrar.php';
        require_once HTML_DIR . 'gasto/modal_registrar.php';
        require_once HTML_DIR . 'overall/footer.php';
    }

    public function save()
    {   
        $this->validacion->validarRol(2);
        $errores=[];
        $img_name="";

        if(!isset($_POST['Tipo']) && $_POST['Tipo']==0){
           $errores[] = array('control' =>"Tipo" ,'error' =>"Tiene que selecionar un tipo, si no lo encuentra el tipo de gasto puede crear uno"  );
        }
        if ($_POST['valor']=="") {
            $errores[] = array('control' =>"valor" ,'error' => "Tiene que ingresar un valor"  );
        }else{
            $_POST['valor']= preg_replace('/[.,]/', '', $_POST['valor']);
        }
        /*if($_POST['nota']==""){
           $errores[] = array('control' =>"nota" ,'error' =>"Tiene que ingresar un detalle"  );
        }*/

        if(isset($_FILES["img"])){
            $str=$_FILES['img']['name'];
            $urlEx = explode(".",$str );
            $img_name = end($urlEx);
            if(!in_array($img_name,APP_EXTENCIONES_PERMITIDAS)){
                $errores[]=array('control' =>"input-b5" ,'error' =>"error de extension de archivo");
            }
        } 

        if(count($errores)==0){
              
            $result=  $this->gasto->crear_gasto($_POST['Tipo'], $_POST['valor'], $_POST['nota'],$img_name);
            if(isset($_FILES["img"])){
                if (isset($result["control"]) && $result["control"] !=1) {
                    move_uploaded_file($_FILES['img']['tmp_name'], "view/assets/evidenciasGastosPropios/".$result["control"]);
                    $errores=array('control' =>0 ,'error' => 0);
                }
            }else{
                $errores=array('control' =>0 ,'error' => 0);
            }
          
        }
        echo json_encode($errores);  
    }

    public function cambiarEstado(){
        $this->validacion->validarRol([2,1]);
        if($_SESSION["rol"]==1){
            $data=$this->gasto->cambiarEstado($_GET,1);
            $this->index();
        }
         if($_SESSION["rol"]==2){
            $data=$this->gasto->cambiarEstado($_POST,3);
        }
        echo json_encode($data);
    }
    

    public function cargar_gasto(){
        $this->validacion->validarRol([2,1]);
        $data=array();
        if($_SESSION["rol"]==1){
            $data=$this->gasto->cargarGastos($_REQUEST);
        }
         if($_SESSION["rol"]==2){
            $data=$this->gasto->cargarMiGastos($_REQUEST);
        }
        
        echo json_encode($data);
    }

    public function obtenerGasto(){
        $this->validacion->validarRol([2,1]);
        $data=$this->gasto->obtenerGasto($_REQUEST);
        echo json_encode($data);
    }

    public function abonarGasto(){
        $this->validacion->validarRol(1);

        $errores=array();
        if($_POST['idGasto']==""){
            $errores[] = array('error' => 1,"mensaje"=>"Error a completa el abono." );
        }

        if ($_POST['valorAbono']=="") {
          return array('control' =>"valorAbono" ,'error' => "Tiene que ingresar un valor"  );
        }else{
          $_POST['valorAbono'] = preg_replace('/[.,]/', '', $_POST['valorAbono']);
       }

      if(count($errores)==0){
        $errores=$this->gasto->abonar($_POST['idGasto'],$_POST['notaGasto'],$_POST['valorAbono'],$_POST['latitud'],$_POST['longitud']);
      }
      echo json_encode($errores);
    }
}