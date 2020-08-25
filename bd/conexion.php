<?php
require_once 'controller/log_controller.php';

class conexion
{   
    public function __construct()
    {
        $this->LOG   = new log_controller();
    }  

    public static function getConnection()
    {
        $conn = new mysqli(APP_HOST,APP_USER, APP_PASS,APP_DB);
        $conn->query("SET NAMES 'utf8'");
        if ($conn->connect_error) {
            die('no se pudo conectar a la base de dato' . $conn->connect_error);
        } else {
            return $conn;
        }
    }

    public function protect($v)
    {
        $conn = new mysqli(APP_HOST,APP_USER, APP_PASS,APP_DB);
        $v    = mysqli_real_escape_string($conn, $v);
        $v    = htmlentities($v, ENT_QUOTES);
        $V    = trim($v);
        return $v;
    }
}
