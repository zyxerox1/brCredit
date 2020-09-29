<?php
require_once 'model/reporte_errores_modelo.php';

class reporte_errores_controller
{
    private $reporte;

    public function __construct()
    {
        $this->reporte  = new reporte_errores_modelo();
        $this->validacion  = new validaciones_controller();
    }

    public function index()
    {
        $this->validacion->validarRol(1);
       
        //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $c='reporte_errores'; //carpeta;
        $p='reporte_errores';//nombre del archivo js
        $data_filtro=$this->reporte->query_usuario();
        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'reporte_errores/reporte_errores.php';
        require_once HTML_DIR . 'overall/footer.php'; 
    }

    public function master_index()
    {
        $this->validacion->validarRol(1);
       
        //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $carpeta='reporte_errores'; //carpeta;
        $archivo='reporte_errores';//nombre del archivo js
        $data_filtro=$this->reporte->query_usuario();
        if(isset($carpeta)){  
        ?>
            <link rel="stylesheet" type="text/css" href="./view/html/<?php echo $carpeta; ?>/style.css?v=<?php echo(rand()); ?>"/>
        <?php 

        require_once HTML_DIR . 'reporte_errores/reporte_errores.php';

        ?>
            <script src="./view/html/<?php echo $carpeta."/".$archivo.".js"; ?>?v=<?php echo(rand()); ?>"></script>
        <?php
        } 
    }

    public function csv(){
        $this->validacion->validarRol(1);
        $data=$this->reporte->csv($_REQUEST);
        if(count($data) > 0){
            $delimiter = ",";
            $filename = "reporte_errores_" . date('Y-m-d') . ".csv";
            
            //create a file pointer
            $f = fopen('php://memory', 'w');
    
            //set column headers
            $fields = array('Fecha', 'Documento', 'Usuario', 'accion', 'descripcion', 'controller', 'function');
            fputcsv($f, $fields, $delimiter);

            foreach ($data as $key => $value) {
               $lineData = array($value['fecha'], $value['documento_suario'], $value['usuario'], $value['accion'], $value['descripcion'], $value['controller'],$value['function']);
                fputcsv($f, $lineData, $delimiter);
            }
            
            
            //move back to beginning of file
            fseek($f, 0);
            
            //set headers to download file rather than displayed
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');
            
            //output all remaining data on a file pointer
            fpassthru($f);
        }
    }

    public function cargar_reporte(){
        $this->validacion->validarRol(1);
        $data=$this->reporte->obtenerReporte($_REQUEST);
        echo json_encode($data);
    }

     public function eliminar_reporte(){
        $this->validacion->validarRol(1);
        $errores=[];

        if($_POST['Fecha_ini']==''){
          $errores[] = array('control' =>"Fecha_ini" ,'error' =>"No puede dejar la fecha en blanco");
        }else{
            $Fecha_ini = explode("-", $_POST["Fecha_ini"]);
            //print_r($Fecha_ini);
            if (checkdate( $Fecha_ini[1], $Fecha_ini[2], $Fecha_ini[0]) == false) {
                $errores[] = array('control' =>"Fecha_ini" ,'error' =>"Debes selecionar una fecha valida");
            }
        }

        if($_POST['Fecha_fin']==''){
          $errores[] = array('control' =>"Fecha_fin" ,'error' =>"No puede dejar la fecha en blanco");
        }else{
            $Fecha_fin = explode("-", $_POST["Fecha_fin"]);
            //print_r($Fecha_fin);
            if (checkdate($Fecha_fin[1], $Fecha_fin[2], $Fecha_fin[0]) == false) {
                $errores[] = array('control' =>"Fecha_fin" ,'error' =>"Debes selecionar una fecha valida");
            }
        }

        if(count($errores)==0){
            $data=$this->reporte->eliminarLogErrores($_POST);
            $errores=array('control' =>0 ,'error' => 0);
        }
        echo json_encode($errores); 
    }
}