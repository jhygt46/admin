<?php
session_start();
date_default_timezone_set('America/Santiago');

require_once("config.php");
require_once("mysql_class.php");


class Admin{
    
    public $con = null;
    
    public function __construct(){
        $this->con = new Conexion();
    }

    public function ingreso(){
                
        if(filter_var($_POST['user'], FILTER_VALIDATE_EMAIL)){
            $user = $this->con->sql("SELECT * FROM usuarios WHERE correo='".$_POST['user']."'");
            
            if($user['count'] == 0){
                // CORREO NO SE ENCUENTERA EN LA BASE DE DATOS
                $info['op'] = 2;
                $info['message'] = "Error: Usuario no existe";
            }
            if($user['count'] == 1){
                
                $block = $user['resultado'][0]['block'];
                
                if($block == 1){
                    $fecha_block = $user['resultado'][0]['fecha_block'];
                    if(strtotime($fecha_block)+86400 < time()){
                        $block = 0;
                        $this->con->sql("UPDATE usuarios SET block='0', intentos='0', fecha_block='' WHERE id_user='".$user['resultado'][0]['id_user']."'");
                        $user['resultado'][0]['intentos'] = 0;
                    }else{
                        $time = strtotime($fecha_block) - time() + 86400;
                        $hrs = date("H:i:s", $time);
                        $info['op'] = 2;
                        $info['message'] = "Su cuenta esta Bloqueada, se desbloqueara autom&aacute;ticamente en ".$hrs;
                    }
                }
                
                if($block == 0){
                    $pass = $user['resultado'][0]['pass'];
                    if($pass == md5($_POST['pass'])){
                        
                        $id_user = $user['resultado'][0]['id_user'];
                        
                        $_SESSION['user']['id_user'] = $id_user;
                        $_SESSION['user']['nombre'] = "Diego Gomez B";
                        $_SESSION['user']['id_cia'] = $user['resultado'][0]['id_cia'];
                        $_SESSION['user']['id_cue'] = $user['resultado'][0]['id_cue'];
                        
                        // ATENCION ACA SE CREAN LOS PERMISOS //
                        
                        $info['op'] = 1;
                        $info['message'] = "Ingreso Exitoso";
                        
                    }else{
                        $intentos = $user['resultado'][0]['intentos'] + 1;
                        $this->con->sql("UPDATE usuarios SET intentos='".$intentos."' WHERE id_user='".$user['resultado'][0]['id_user']."'");
                        if($intentos > 5){
                            $this->con->sql("UPDATE usuarios SET block='1', fecha_block='".date('Y-m-d H:i:s')."' WHERE id_user='".$user['resultado'][0]['id_user']."'");
                        }
                        $int = 6 - $intentos;
                        $info['op'] = 2;
                        $info['message'] = "Contrase&ntilde;a Invalida, le quedan ".$int." intentos";
                    }
                }
                
            }
        
        }
        
        return $info;    
            
    }

    public function recuperar_password(){
        
        $id = $_POST['id'];
        $code = $_POST['code'];
        $pass1 = $_POST['pass1'];
        $pass2 = $_POST['pass2'];
        
        $user = $this->con->sql("SELECT * FROM ilusuarios WHERE id_user='".$id."'");
        if($user['resultado'][0]['mailcode'] == $code && $pass1 == $pass2 && strlen($pass1) >= 8){
            $this->con->sql("UPDATE ilusuarios SET password='".md5($pass1)."', mailcode='' WHERE id_user='".$id."'");
            $info['op'] = 1;
            $info['user'] = $user['resultado'][0]['correo'];
        }
        return $info;
        
    }
    

    
}
?>