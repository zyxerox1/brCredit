<?php
class cliente_modelo
{
    private $DB;
    private $user;

    public function __construct()
    {
        $this->DB   = conexion::getConnection();
        $this->DB_QUERY   = new query_modelo;
        $this->user = array();
    }

    /*/////////////////////////////////////////////guardar///////////////////////////////////*/
    public function log_cliente($movimiento="",$id="",$nota=""){
        /*parametro de errores{*/
        $controller="";
        $accion_func="";
        if(isset($_REQUEST['c'])){
            $controller=$_REQUEST['c'];
        }
        if(isset($_REQUEST['a'])){
            $accion_func=$_REQUEST['a'];
        }

        $query = "CALL logCliente('$movimiento','$id',".$_SESSION["id_usu_credit"].",'$accion_func','$controller')";

        $this->DB_QUERY->save($query);
    }

    public function crear_usuario($primernombre, $segundonombre, $primerapellido, $segundoapellido, $Documento, $Genero, $Telefono_1, $Telefono_2, $Fecha, $Direcion, $Correo, $img_name,$estados,$ciudades,$ccr,$Direcionc){

        $user = array();

        if($img_name==1){
            $img_name=date("YmdHis")."_".rand(0, 9).$_SESSION["id_usu_credit"].".png";
            $user["text_img_perfil_usu"]=$img_name;
        }else{
            $img_name='usuario.jpg';
            $user["text_img_perfil_usu"]=1;
        }
    	$query = "INSERT INTO tbl_cliente (id_clie, documento_clie, documento_ref_clie, primer_nombre_clie, segundo_nombre_clie, primer_apellido_clie, segundo_apellido_clie, telefono_1_clie, telefono_2_clie, direcion_clie, direcion_cobro_clie, sexo_clie, correo_clie, fecha_nacimineto_clie, foto_clie, estado_localidad_clie, ciudad_localidad_clie, id_usu) VALUES (NULL, $Documento, $ccr,'$primernombre', '$segundonombre', '$primerapellido', '$segundoapellido', $Telefono_1, $Telefono_2, '$Direcion', '$Direcionc','$Genero', '$Correo', '$Fecha','$img_name',$estados,$ciudades,".$_SESSION["id_usu_credit"].");";
        $id=$this->DB_QUERY->save($query,'creacion de cliente.');
        $this->log_cliente(0,$id);
        return array('control' =>$user["text_img_perfil_usu"] ,'error' => 0,'resp'=>$id);
    }

    /*////////////////////////////////consulta//////////////////////////////////////////////////*/
    public function obtener_cliente($params){

        $query="SELECT clien.id_clie as id, 
                       clien.documento_clie as CC, 
                      CONCAT_WS (' ',clien.primer_nombre_clie,clien.segundo_nombre_clie,clien.primer_apellido_clie,clien.segundo_apellido_clie) as nombre,
                      clien.telefono_1_clie as t1, 
                      clien.telefono_2_clie as t2,
                      clien.correo_clie as Correo,
                      clien.documento_clie as Direcionr,
                      clien.documento_ref_clie as Direcionc, 
                      clien.fecha_nacimineto_clie as fecha_cobro, 
                      clien.id_clie as id_cobro  
                      FROM tbl_cliente as clien  
                      WHERE 1 ";

     
        if(isset($params['Nombre']) && $params['Nombre']!=0){
          $query.=" AND clien.id_clie = ".$params['Nombre'];
        }
        if(isset($params['Cedula']) && $params['Cedula']!=0){
            $query.=" AND clien.documento_clie = ".$params['Cedula'];
        }

        //$tablaSearch="AND int_documento_usu LIKE '%".$params['search']['value']."%'";

        $data=$this->DB_QUERY->queryDatatable($params,$query);
        return $data;
    }

    public function obtener_filtro_cliente(){
        $query="CALL obtenerCliente()";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }


    public function query_cliente($params){
        $query="CALL buscarCliente(".$params['i'].")";
        $data=$this->DB_QUERY->query($query);
        return $data;
    }

    /*////////////////////////////////atualizar//////////////////////////////////////////////////*/
    
    public function atualizar_cliente($primernombre, $segundonombre, $primerapellido, $segundoapellido,$Genero, $Telefono_1, $Telefono_2, $Fecha, $Direcion, $Correo, $img_name,$id,$estados,$ciudad,$ccr,$Direcioncobro){

        $user = array();

        $img="";
        $correo="";
        if($img_name==1){
            $query="SELECT foto_clie FROM tbl_cliente WHERE id_clie=".$id;
            $data=$this->DB_QUERY->query($query);
            if($data[0]['foto_clie']=='usuario.jpg'){
               $user["control"]=date("YmdHis")."_".$id.".png";
               $img=",foto_clie='".$user["control"]."'";
            }else{
                $user["control"]=$data[0]['foto_clie'];
            }
            
        }else{
            $img_name='usuario.jpg';
            $user["control"]=1;
        }

        $query = "UPDATE tbl_cliente 
                  SET 
                    primer_nombre_clie='$primernombre',
                    segundo_nombre_clie='$segundonombre',
                    primer_apellido_clie='$primerapellido',
                    segundo_apellido_clie='$segundoapellido',
                    telefono_1_clie=$Telefono_1,
                    telefono_2_clie=$Telefono_2,
                    direcion_clie='$Direcion',
                    sexo_clie='$Genero',
                    fecha_nacimineto_clie='$Fecha',
                    estado_localidad_clie='$estados',
                    ciudad_localidad_clie='$ciudad',
                    documento_ref_clie='$ccr',
                    direcion_cobro_clie='$Direcioncobro',
                    correo_clie='$Correo'
                    $img
                  WHERE tbl_cliente.id_clie =".$id;

        $this->DB_QUERY->save($query,'atualizar cliente.');
        $this->log_cliente(1,$id);
        return $user;
    }
}