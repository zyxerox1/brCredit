<?php
class home_modelo
{
    private $DB;
    private $LOG;
    private $data;
    private $DB_QUERY;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->DB_QUERY   = new conexion;
        $this->LOG   = new log_controller();
        $this->data = array();
    }
}