<?php

$path = $_SERVER['DOCUMENT_ROOT'];
if($_SERVER['HTTP_HOST'] == "localhost"){
    $path .= "/";
}

require_once '../db_config.php';
require_once $path.'config/config.php';

class Conexion {
    
    public $conn = null;
    public $host = null;
    public $usuario = null;
    public $password = null;
    public $base_datos = null;

    public function __construct(){

        global $db_host;
        global $db_user;
        global $db_password;
        global $db_database;

        $this->host	= $db_host;
        $this->usuario = $db_user;
        $this->password = $db_password;
        $this->base_datos = $db_database;
        $this->conn = mysqli_connect($this->host[0], $this->usuario[0], $this->password[0], $this->base_datos[0]);

    }

    public function sql($sql) {
        
        $res = mysqli_query($this->conn, $sql);
        if(!mysqli_connect_errno()){
            $resultado['estado'] = true;
            $resultado['query'] = $sql;
            
            if (preg_match("/select/i", $sql)){
                $i=0;
                while($row = mysqli_fetch_assoc($res)){
                    $resultado['resultado'][] = $row;
                    $i++;
                }
                $resultado['count'] = $i;
            }
            if (preg_match("/insert/i", $sql)){
                $resultado['insert_id'] = mysqli_insert_id();
            }
            if (preg_match("/update/i", $sql)){
                $resultado['update_rows'] = mysqli_affected_rows();
            }
            mysqli_free_result($res);
            
        }else{
            $resultado['estado'] = false;
            $resultado['query'] = $sql;
            $resultado['error'] = "Failed: ".mysqli_connect_error();
        }
        
        return $resultado;
        /*
        
        if (preg_match("/update/i", $sql)){
                $resultado['update_rows'] = mysqli_affected_rows();
        }
        if (preg_match("/delete/i", $sql)){

        }
        if (preg_match("/select/i", $sql)){
            while($row = @mysqli_fetch_array($result, MYSQL_ASSOC)){
                $resultado['resultado'][] = $row;
            }
        }
        $resultado['count'] = count($resultado['resultado']);	
        @mysqli_free_result($result);
        */
        
        
    }

    public function __destruct(){
        mysqli_close($this->conn);
    }


}

?>