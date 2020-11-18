<?php

require_once 'model/cliente_modelo.php';

class cliente_controller
{
    private $validacion;
    private $cliente;
    public function __construct()
    {

        $this->validacion  = new validaciones_controller();
        $this->cliente  = new cliente_modelo();
    }

    public function index()
    {
        $this->validacion->validarRol([1,2]);
        $c='cliente';//variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        if($_SESSION["rol"]==1){
          $data_filtro_ruta=$this->cliente->obtenerFiltroRuta();
          $p='clienteAdministrador';
        }else{
          $p='cliente';
          $data_filtro=$this->cliente->obtener_filtro_cliente();
          require_once HTML_DIR . 'cliente/modal_prestamo.php';
        }
        require_once HTML_DIR . 'cliente/cliente.php';
        require_once HTML_DIR . 'overall/footer.php';
    }

    public function crear()
    {   
        $this->validacion->validarRol([1,2]);
        //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $c='cliente';
        $p='crear';
        if($_SESSION["rol"]==1){
          $data_filtro_ruta=$this->cliente->obtenerFiltroRuta();
        }
        ////////////////////////////////////////////////////////////////////////////////////////////
        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'cliente/crear.php';
        require_once HTML_DIR . 'overall/footer.php'; 
    }

    public function editar()
    {   
        $this->validacion->validarRol([1,2]);
        //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $c='cliente';
        $p='editar';
        ////////////////////////////////////////////////////////////////////////////////////////////
        $data=$this->cliente->query_cliente($_REQUEST);
        if($_SESSION["rol"]==1){
          $data_filtro_ruta=$this->cliente->obtenerFiltroRuta();
        }
        $_SESSION['id_update']=$_REQUEST['i'];
        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'cliente/editar.php';
        require_once HTML_DIR . 'overall/footer.php'; 
    }

    public function cargar()
    {
        $this->validacion->validarRol([1,2]);
        if($_SESSION["rol"]==1){
          $data=$this->cliente->obtener_cliente_todos($_REQUEST);
        }else{
          $data=$this->cliente->obtener_cliente($_REQUEST);
        }
        echo json_encode($data);
    }

    public function save()
    {   
        $this->validacion->validarRol([1,2]);
        $errores=[];
        $img_name=0;

        if($this->validacion->soloLetras($_POST['primernombre'])==false){
           $errores[] = array('control' =>"primernombre" ,'error' =>"El campo de primer nombre solo debe contener letras"  );
        }
        if ($_POST['segundonombre']!="") {
          if($this->validacion->soloLetras($_POST['segundonombre'])==false){
            $errores[] = array('control' =>"segundonombre" ,'error' =>"El campo de segundo nombre solo debe contener letras"  );
          }
        }
        
        if($this->validacion->soloLetras($_POST['primerapellido'])==false){
          $errores[] = array('control' =>"primerapellido" ,'error' =>"El campo de primer apellido solo debe contener letras"  );
        }

        if ($_POST['segundoapellido']!="") {
          if($this->validacion->soloLetras($_POST['segundoapellido'])==false){
            $errores[] = array('control' =>"segundoapellido" ,'error' =>"El campo de segundo apellido solo debe contener letras"  );
          }
        }

        if($this->validacion->soloNumeros($_POST['Documento'])==false){
          $errores[] = array('control' =>"Documento" ,'error' =>"El campo Documento solo debe contener numeros");
        }

        if(strlen($_POST['Documento'])<7){
          $errores[] = array('control' =>"Documento" ,'error' =>"El campo Documento es corto");
        }


        if($this->validacion->soloNumeros($_POST['ccr'])==false){
          $errores[] = array('control' =>"ccr" ,'error' =>"El campo Documento referencia solo debe contener numeros");
        }
        
        if(strlen($_POST['ccr'])<7){
          $errores[] = array('control' =>"ccr" ,'error' =>"El campo Documento referencia es corto");
        }

        if($_POST['Genero']==""){
          $errores[] = array('control' =>"Genero" ,'error' =>"Debes selecionar un genero");
        }
        if($this->validacion->soloLetras($_POST['Genero'])==false){
          $errores[] = array('control' =>"Genero" ,'error' =>"El campo de Genero solo debe contener letras");
        }
       
        if($_POST['estados']==0){
          $errores[] = array('control' =>"estados" ,'error' =>"Debes selecionar un estado");
        }

        if($_POST['ciudades']==0){
          $errores[] = array('control' =>"ciudades" ,'error' =>"Debes selecionar un ciudad");
        }
        
        if($this->validacion->soloNumeros($_POST['Telefono_1'])==false){
          $errores[] = array('control' =>"Telefono_1" ,'error' =>"El campo Telefono 1 solo debe contener numeros"  );
        }
        if(strlen($_POST['Telefono_1'])<8){
          $errores[] = array('control' =>"Telefono_1" ,'error' =>"El numero Telefono 1 es corto");
        }

        if(strlen($_POST['Telefono_2'])!=0){
           if(strlen($_POST['Telefono_2'])<8){
              $errores[] = array('control' =>"Telefono_2" ,'error' =>"El numero Telefono 2 es corto");
            } 

            if($this->validacion->soloNumeros($_POST['Telefono_2'])==false){
              $errores[] = array('control' =>"Telefono_2" ,'error' =>"El campo Telefono 2 solo debe contener numeros");
            }
        }else{
            $_POST['Telefono_2']=0;
        }

        // if($this->validacion->muyJoven($_POST['Fecha'])==false){
        //   $errores[] = array('control' =>"Fecha" ,'error' =>"La fecha es muy cercana a la actual.");
        //   $errores[] = array('control' =>"Edad" ,'error' =>"La edad es muy joven");
        // }
        if($_POST['Fecha']==""){
          $errores[] = array('control' =>"Fecha" ,'error' =>"La fecha esta vacia");
        }
        if($this->validacion->validar_correo($_POST['Correo'])==false){
          $errores[] = array('control' =>"Correo" ,'error' =>"El correo ya exite.");
        }
        if (!filter_var($_POST['Correo'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = array('control' =>"Correo" ,'error' =>"Debe ingresar un correo valido.");
        }

        if($_SESSION['rol']==1){
          if($_POST['valormax']==""){
            $errores[] = array('control' =>"valormax" ,'error' =>"Debe ingresar un valor maximo.");
          }

          if($_POST['valormin']==""){
            $errores[] = array('control' =>"valormin" ,'error' =>"Debe ingresar un valor minimo.");
          }

          if(isset($_POST['valormax']) && isset($_POST['valormin'])){
            $_POST['valormin']=str_replace( '.', '',$_POST['valormin'] );
            $_POST['valormax']=str_replace( '.', '',$_POST['valormax'] );
            if($_POST['valormax'] <= $_POST['valormin']){
               $errores[] = array('control' =>"valormin" ,'error' =>"El valor minimo no puede igualar o sobrepasar el valor maximo");
            }
          }

          if($_POST['ruta']==0){
            $errores[] = array('control' =>"ruta" ,'ruta' =>"Debe ingresar una ruta.");
          }
        }

        if(isset($_FILES["img"])){
          $img_name=1;
        } 
        
        if(count($errores)==0){
          if($_SESSION['rol']==1){
            $result_editar_usuario=  $this->cliente->crear_usuario($_POST['primernombre'], $_POST['segundonombre'], $_POST['primerapellido'], $_POST['segundoapellido'], $_POST['Documento'], $_POST['Genero'], $_POST['Telefono_1'], $_POST['Telefono_2'], $_POST['Fecha'], $_POST['Direcion'], $_POST['Correo'],$img_name,$_POST['estados'],$_POST['ciudades'],$_POST['ccr'],$_POST['Direcionc'],$_POST['valormin'],$_POST['valormax'],$_POST['ruta']);
          }else{
            $result_editar_usuario=  $this->cliente->crear_usuario($_POST['primernombre'], $_POST['segundonombre'], $_POST['primerapellido'], $_POST['segundoapellido'], $_POST['Documento'], $_POST['Genero'], $_POST['Telefono_1'], $_POST['Telefono_2'], $_POST['Fecha'], $_POST['Direcion'], $_POST['Correo'],$img_name,$_POST['estados'],$_POST['ciudades'],$_POST['ccr'],$_POST['Direcionc']);

          }
            
            if (isset($result_editar_usuario["control"]) && $result_editar_usuario["control"] !=1) {
              move_uploaded_file($_FILES['img']['tmp_name'], "view/assets/imagenes_cliente/".$result_editar_usuario["control"]);
            }
          $errores=array('control' =>0 ,'error' => 0);
        }
        echo json_encode($errores);  
    }

    public function update()
    {   
        $this->validacion->validarRol([1,2]);
        $errores=[];
        $img_name=0;

        if($this->validacion->soloLetras($_POST['primernombre'])==false){
           $errores[] = array('control' =>"primernombre" ,'error' =>"El campo de primer nombre solo debe contener letras"  );
        }
        if ($_POST['segundonombre']!="") {
          if($this->validacion->soloLetras($_POST['segundonombre'])==false){
            $errores[] = array('control' =>"segundonombre" ,'error' =>"El campo de segundo nombre solo debe contener letras"  );
          }
        }
        
        if($this->validacion->soloLetras($_POST['primerapellido'])==false){
          $errores[] = array('control' =>"primerapellido" ,'error' =>"El campo de primer apellido solo debe contener letras"  );
        }

        if ($_POST['segundoapellido']!="") {
          if($this->validacion->soloLetras($_POST['segundoapellido'])==false){
            $errores[] = array('control' =>"segundoapellido" ,'error' =>"El campo de segundo apellido solo debe contener letras"  );
          }
        }

        if($_POST['Genero']==""){
          $errores[] = array('control' =>"Genero" ,'error' =>"Debes selecionar un genero");
        }
        if($this->validacion->soloLetras($_POST['Genero'])==false){
          $errores[] = array('control' =>"Genero" ,'error' =>"El campo de Genero solo debe contener letras");
        }
        if($_POST['estados']==0){
          $errores[] = array('control' =>"estados" ,'error' =>"Debes selecionar un estado");
        }

        if($_POST['ciudades']==0){
          $errores[] = array('control' =>"ciudades" ,'error' =>"Debes selecionar un ciudad");
        }

        if($this->validacion->soloNumeros($_POST['Telefono_1'])==false){
          $errores[] = array('control' =>"Telefono_1" ,'error' =>"El campo Telefono 1 solo debe contener numeros"  );
        }
        if(strlen($_POST['Telefono_1'])<8){
          $errores[] = array('control' =>"Telefono_1" ,'error' =>"El numero Telefono 1 es corto");
        }
        
         if(strlen($_POST['Telefono_2'])!=0){
           if(strlen($_POST['Telefono_2'])<8){
              $errores[] = array('control' =>"Telefono_2" ,'error' =>"El numero Telefono 2 es corto");
            } 
            if($this->validacion->soloNumeros($_POST['Telefono_2'])==false){
              $errores[] = array('control' =>"Telefono_2" ,'error' =>"El campo Telefono 2 solo debe contener numeros");
            }
        }else{
            $_POST['Telefono_2']=0;
        }

        if($this->validacion->soloNumeros($_POST['ccr'])==false){
          $errores[] = array('control' =>"ccr" ,'error' =>"El campo Documento referencia solo debe contener numeros");
        }
        
        if(strlen($_POST['ccr'])<7){
          $errores[] = array('control' =>"ccr" ,'error' =>"El campo Documento referencia es corto");
        }

        if($this->validacion->muyJoven($_POST['Fecha'])==false){
          $errores[] = array('control' =>"Fecha" ,'error' =>"La fecha es muy cercana a la actual.");
          $errores[] = array('control' =>"Edad" ,'error' =>"La edad es muy joven");
        }
        if($_POST['Fecha']==""){
          $errores[] = array('control' =>"Fecha" ,'error' =>"La fecha esta vacia");
        }
        if($this->validacion->validar_correo_update($_POST['Correo'],$_SESSION['id_update'])==false){
          $errores[] = array('control' =>"Correo" ,'error' =>"El correo ya exite.");
        }
        if (!filter_var($_POST['Correo'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = array('control' =>"Correo" ,'error' =>"Debe ingresar un correo valido.");
        }
        if(isset($_FILES["img"])){
          $img_name=1;
        } 


        
          

          if(isset($_POST['valormax']) && isset($_POST['valormin'])){
            $_POST['valormin']=str_replace( '.', '',$_POST['valormin'] );
            $_POST['valormax']=str_replace( '.', '',$_POST['valormax'] );
            if($_POST['valormax'] <= $_POST['valormin']){
               $errores[] = array('control' =>"valormin" ,'error' =>"El valor minimo no puede igualar o sobrepasar el valor maximo");
            }
          }

        if($_SESSION['rol']==1){
          if($_POST['valormax']==""){
            $errores[] = array('control' =>"valormax" ,'error' =>"Debe ingresar un valor maximo.");
          }

          if($_POST['valormin']==""){
            $errores[] = array('control' =>"valormin" ,'error' =>"Debe ingresar un valor minimo.");
          }
          
          if($_POST['ruta']==0){
            $errores[] = array('control' =>"ruta" ,'ruta' =>"Debe ingresar una ruta.");
          }
        }

        if(count($errores)==0){
           
            if($_SESSION['rol']==1){
              $result_editar_usuario=  $this->cliente->atualizar_cliente($_POST['primernombre'], $_POST['segundonombre'], $_POST['primerapellido'], $_POST['segundoapellido'], $_POST['Genero'], $_POST['Telefono_1'], $_POST['Telefono_2'], $_POST['Fecha'], $_POST['Direcion'], $_POST['Correo'],$img_name,$_SESSION['id_update'],$_POST['estados'],$_POST['ciudades'],$_POST['ccr'],$_POST['Direcioncobro'],$_POST['valormin'],$_POST['valormax'],$_POST['ruta']);
            }else{
               $result_editar_usuario=  $this->cliente->atualizar_cliente($_POST['primernombre'], $_POST['segundonombre'], $_POST['primerapellido'], $_POST['segundoapellido'], $_POST['Genero'], $_POST['Telefono_1'], $_POST['Telefono_2'], $_POST['Fecha'], $_POST['Direcion'], $_POST['Correo'],$img_name,$_SESSION['id_update'],$_POST['estados'],$_POST['ciudades'],$_POST['ccr'],$_POST['Direcioncobro'],$_POST['valormin'],$_POST['valormax']);
            }



            if (isset($result_editar_usuario["control"]) && $result_editar_usuario["control"] !=1) {
              move_uploaded_file($_FILES['img']['tmp_name'], "view/assets/imagenes_cliente/".$result_editar_usuario["control"]);
            }
          $errores=array('control' =>0 ,'error' => 0);
        }
        echo json_encode($errores);  
    }

    public function cambiar_estado(){
        $this->validacion->validarRol([1,2]);
        $errores=[];
        if(!isset($_POST['id']) || !isset($_POST['estado'])){
            $errores[]=array('control' =>"1" ,'error' =>"Algo salio mal");
        }else{
            $_POST['estado'] = (1 == $_POST['estado']) ? 0 : 1;
            $errores=$this->cliente->cambiar_estado($_POST);
        }
        echo json_encode($errores);
    }

    public function autrizarCambioSaldo(){
      $this->validacion->validarRol(1);
      $errores=$this->cliente->autrizarCambioSaldo($_POST);
      echo json_encode($errores);
    }

    public function orden()
    {
      $this->validacion->validarRol(2);
      $data=$this->cliente->cambiarOrdenRutero($_POST);
      echo json_encode($data);
    }

    public function obtenerDataCliente()
    {
        $this->validacion->validarRol(2);
        $data=$this->cliente->DataCliente($_POST);
        echo json_encode($data);
    }

    public function obtenerClienteRuta()
    {
        $this->validacion->validarRol(1);
        $data=$this->cliente->obtener_filtro_cliente($_POST["ruta"]);
        echo json_encode($data);
    }
}
