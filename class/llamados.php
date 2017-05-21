<?php
session_start();

require_once 'mysql_class.php';

class llamados{
    
    public $con = null;
    public $id_cue = null;
    public $lat = null;
    public $lng = null;
    
    public function __construct(){
        
        $this->con = new Conexion();
        $this->id_cue = 1;
        
    }
    
    public function distancia($lat, $lng){
        
        $decimal = 2;
        $degrees = rad2deg(acos((sin(deg2rad($this->lat))*sin(deg2rad($lat))) + (cos(deg2rad($this->lat))*cos(deg2rad($lat))*cos(deg2rad($this->lng - $lng)))));
        $distance = $degrees * 111.13384 * 1000;
        return round($distance, $decimals);
        
    }
    
    public function crearllamado(){
        
        $id_cla = 1;
        $this->lat = -33.4397973;
        $this->lng = -70.6169393;
        
        $clave = $this->con->sql("SELECT * FROM claves WHERE id_cla='".$id_cla."' AND eliminado='0' AND id_cue='".$this->id_cue."'");
        $info['tipo'] = $clave['resultado'][0]['tipo'];
        
        // 1 ES LLAMADO
        // 2 ES INCENDIO
        
        if($info['tipo'] == 1 || $info['tipo'] == 2){
            
            // TIPOS DE CARROS PARA EL LLAMADO O INCENCIO
            $tdcs = $this->con->sql("SELECT * FROM claves_tipo WHERE id_cla='".$id_cla."'");
            
            // TODOS LOS CARROS DEL CUERPO
            $aux_carros = $this->con->sql("SELECT * FROM cuerpo_cias_despacho t1, carros t2, carros_tipo t3 WHERE t1.id_cue='".$this->id_cue."' AND t1.id_cia=t2.id_cia AND t2.id_car=t3.id_car");
            $carros = $aux_carros['resultado'];
            
            for($i=0; $i<$aux_carros['count']; $i++){
                
                $id = $carros[$i]['id_car'];
                $aux[$id]['nombre'] = $carros[$i]['nombre'];
                $aux[$id]['id_cia'] = $carros[$i]['id_cia'];
                $aux[$id]['enservicio'] = $carros[$i]['enservicio'];
                $aux[$id]['lat'] = $carros[$i]['lat'];
                $aux[$id]['lng'] = $carros[$i]['lng'];
                $aux[$id]['distancia'] = $this->distancia($carros[$i]['lat'], $carros[$i]['lng']);
                $aux[$id]['tdc'][] = $carros[$i]['id_tdc'];
                
            }
            /*
            echo "<pre>";
            print_r($aux);
            echo "</pre>";
            */
            usort($aux, function($a, $b){ return $a['distancia'] - $b['distancia']; });
            
            // CONFIGURACION
            $cant = 1; // CANTIDAD DE TIPOS DE CARROS ADICIONALES
            $mismacia = true;
            $cias = [];
            
            foreach($aux as $carro){
                foreach($carro['tdc'] as $carrotdc){
                    foreach($tdcs['resultado'] as $tdc){
                        if($tdc['id_tdc'] == $carrotdc){
                            
                            if(count($aux2[$tdc['id_tdc']]) <= $tdc['cantidad']){
                                if(!in_array($carro['id_cia'], $cias)){
                                    $aux_final[$tdc['id_tdc']][] = $carro;
                                    $cias[] = $carro['id_cia'];
                                }
                            }
                            
                        }
                    }
                }
            }
            
            
            
            echo "<pre>";
            print_r($aux_final);
            echo "</pre>";
            
            
        }
        
        
        
               
        
        
        
        
        
    }
    
}

$n = new llamados();
$n->crearllamado();