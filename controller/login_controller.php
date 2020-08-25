<?php
require_once 'model/login_modelo.php';

class login_controller
{
    private $model_l;
    private $segurity;
    private $LOG;

    //First step is to build a configuration array to pass to `Hybridauth\Hybridauth`
    
    public function __construct()
    {
        $this->segurity = new conexion();
        $this->model_l  = new login_modelo();
        $this->LOG   = new log_controller();
    }

    public function index()
    {   
        $c='login';//variable necesaria para encontrar la ruta del script js--se utiliza en le footer de la app
        $p='script';
        require_once HTML_DIR . 'overall/header.php';
        require_once HTML_DIR . 'login/login.php';
        require_once HTML_DIR . 'overall/footer.php';     
    }

    public function validacion()
    {   
        $usuario  = $this->segurity->protect($_POST['ema']);
        $password = $this->segurity->protect($_POST['pas']);
        $email=0;
        $error=0;
        if (is_numeric($usuario)) {
            $email=1;
        }
        if ($_POST['ema'] != '' && $_POST['pas'] != '') {
            $data = $this->model_l->login($usuario, $password,$email);
            if ($data[0] == 4) {
                //sessiones
                $_SESSION["ema"]    = $data[1];
                $_SESSION["id_usu_credit"] = $data[2];
                $_SESSION["nombre"] = $data[3];
                $_SESSION["documento"] = $data[4];
                $_SESSION["rol"] = $data[5];
                //$this->LOG->log_usuario(2);
                //validacion de error
                header('location: index.php?c=home');
            } elseif ($data[0] == 5) {
                $this->index();
                echo "<script> ohSnap('Usuario o contraseña incorrecta.',{color: 'red'}); </script>";
            } elseif ($data[0] == 6) {
                $this->index();
                echo "<script> ohSnap('La direccón de correo o nombre de usuario no es válida.',{color: 'red'}); </script>";
            }
        }
    }
}
