<?php
session_start();

require_once 'mysql_class.php';
require_once 'core.php';

class Fireapp extends Core{
    
    public $con = null;
    public $id_cia = null;
    public $id_cue = null;
    
    public function __construct(){
        $this->id_cia = $this->getciaid();
        $this->id_cue = $this->getcueid();
        $this->con = new Conexion();
    }
    
    public function llamados(){
        
        $j['id_cla'] = 1;
        return $j;
        
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
                        
                        $_SESSION['user'] = $this->session($user['resultado'][0]);
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
    
    private function session($user){
        
        $aux['info']['id_user'] = $user['id_user'];
        $aux['info']['nombre'] = $user['nombre'];
             
        $now = @date("Y-m-d");
        $cia = $this->con->sql("SELECT * FROM usuario_cias t1, companias t2 WHERE t1.id_user='".$user['id_user']."' AND t1.fecha_ini<='".$now."' AND t1.fecha_fin>'".$now."' AND t1.id_cia=t2.id_cia");
        $cargos = $this->con->sql("SELECT * FROM usuarios_cargos t1, cargos t2 WHERE t1.id_user='".$user['id_user']."' AND t1.fecha_ini<='".$now."' AND t1.fecha_fin>'".$now."' AND t1.id_carg=t2.id_carg");
        
        $aux['permisos'] = $this->permisos_ususarios($user['id_user']);
        
        if($cargos['count'] > 0){
            for($i=0; $i<$cargos['count']; $i++){
                $id_carg = $cargos['resultado'][$i]['id_carg'];
                $per_carg = $this->permisos_cargos($id_carg);
                foreach($per_carg as $m){
                    $aux['permisos'][] = $m;
                }
            }
        }
        $aux['permisos'] = array_unique($aux['permisos']);
        if($cia['count'] == 0){
            $aux['info']['id_cia'] = 0;
        }else{
            $aux['info']['id_cia'] = $cia['resultado'][0]['id_cia'];
        }
        $aux['info']['id_cue'] = $user['id_cue'];
        return $aux;
        
    }
    
    
    
    public function datestring($date, $n){
        $time = @strtotime($date);
        $m = @date("m", $time);
        switch ($m){
            case 1:
                $mes = "Enero";
                break;
            case 2:
                $mes = "Febrero";
                break;
            case 3:
                $mes = "Marzo";
                break;
            case 4:
                $mes = "Abril";
                break;
            case 5:
                $mes = "Mayo";
                break;
            case 6:
                $mes = "Junio";
                break;
            case 7:
                $mes = "Julio";
                break;
            case 8:
                $mes = "Agosto";
                break;
            case 9:
                $mes = "Septiembre";
                break;
            case 10:
                $mes = "Octubre";
                break;
            case 11:
                $mes = "Noviembre";
                break;
            case 12:
                $mes = "Diciembre";
                break;
        }
        
        $fecha = @date("d", $time)." de ".$mes." de ".@date("Y", $time);
        if($n)
            $fecha .= " ".@date("H", $time).":".@date("i", $time);
        return $fecha;
    }
    
    
    public function diffdates($d1, $d2){
        
        $datetime1 = @date_create($d1);
        $datetime2 = @date_create($d2);
        $interval = @date_diff($datetime1, $datetime2);
        $format = "";
        if($interval->y > 0){
            $format .= $interval->y;
            if($interval->y == 1){
                $format .= " año";
            }
            if($interval->y > 1){
                $format .= " años";
            }
            $format .= ", ";
        }
        if($interval->m > 0){
            $format .= $interval->m;
            if($interval->m == 1){
                $format .= " mes";
            }
            if($interval->m > 1){
                $format .= " meses";
            }
            $format .= ", ";
        }
        if($interval->d > 0){
            $format .= $interval->d;
            if($interval->d == 1){
                $format .= " dia";
            }
            if($interval->d > 1){
                $format .= " dias";
            }
        }
        return $format;
        
    }
    
}

?>