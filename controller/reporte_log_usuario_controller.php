<?php
require_once 'model/reporte_log_usuario_modelo.php';

class reporte_log_usuario_controller
{
    private $reporte;

    public function __construct()
    {
        $this->reporte  = new reporte_log_usuario_modelo();
        $this->validacion  = new validaciones_controller();
    }

    public function index()
    {
        $this->validacion->validarRol(1);
       
        //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $c='reporte_log_usuario'; //carpeta;
        $p='reporte_log_usuario';//nombre del archivo js

        $data_filtro=$this->reporte->query_usuario($_REQUEST);
        $data_filtro_autor=$this->reporte->query_usuario_autor();

        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'overall/topNav.php';
        require_once HTML_DIR . 'reporte_log_usuario/reporte_log_usuario.php';
        require_once HTML_DIR . 'overall/footer.php'; 
    }

    public function master_index()
    {
        $this->validacion->validarRol(1);
       
        //variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $carpeta='reporte_log_gasto'; //carpeta;
        $archivo='reporte_log_gasto';//nombre del archivo js
        $data_filtro=$this->reporte->query_usuario();
        if(isset($carpeta)){  
        ?>
            <link rel="stylesheet" type="text/css" href="./view/html/<?php echo $carpeta; ?>/style.css?v=<?php echo(rand()); ?>"/>
        <?php 

        require_once HTML_DIR . 'reporte_log_gasto/reporte_log_gasto.php';

        ?>
            <script src="./view/html/<?php echo $carpeta."/".$archivo.".js"; ?>?v=<?php echo(rand()); ?>"></script>
        <?php
        } 
    }

    public function cargar_reporte(){
        $this->validacion->validarRol(1);
        $data=$this->reporte->obtenerReporte($_REQUEST);
        echo json_encode($data);
    }

    public function csv(){
        $this->validacion->validarRol(1);
        $data=$this->reporte->csv($_REQUEST);
        if(count($data) > 0){
            $delimiter = ",";
            $filename = "reporte_usuario_" . date('Y-m-d') . ".csv";
            
            //create a file pointer
            $f = fopen('php://memory', 'w');

            //set column headers
            $fields = array('Movimiento', 'Fecha', 'Usuario', 'Documento del usuario', 'Autor', 'Documento del autor');
            fputcsv($f, $fields, $delimiter);

            foreach ($data as $key => $value) {
               $lineData = array($value['movimiento'], $value['fecha'], $value['usuario'], $value['documento_suario'], $value['autor'], $value['documento_autor']);
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
}