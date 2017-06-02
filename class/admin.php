<?php
session_start();
date_default_timezone_set('America/Santiago');

require_once($path_."/mysql_class.php");

class Admin{
    
    public $con = null;
    
    public function __construct(){
        $this->con = new Conexion();
    }
    public function seguridad($id_tar){
        
        if(!in_array($id_tar, $_SESSION['user']['permisos'])){
            $this->riesgoseguridad();
            return false;
        }
        return true;
        
    }
    public function riesgoseguridad(){
        // GUARDAR RIESGOS
    }
    public function get_categorias($id){
        
        $cats = $this->con->sql("SELECT * FROM categorias WHERE id_page='1' AND parent_id='".$id."'");
        for($i=0; $i<$cats['count']; $i++){
            $prods = $this->con->sql("SELECT * FROM cat_pro WHERE id_cat='".$cats['resultado'][$i]['id_cat']."'");
            if($prods['count'] > 0){
                $cats['resultado'][$i]['prods'] = 1;
            }else{
                $cats['resultado'][$i]['prods'] = 0;
            }
        }
        return $cats['resultado'];
        
    }
    public function get_categoria($id){
        
        $cats = $this->con->sql("SELECT * FROM categorias WHERE id_page='1' AND id_cat='".$id."'");
        return $cats['resultado'][0];
        
    }

}
?>