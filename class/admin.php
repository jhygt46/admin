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
    public function arbol_categoria(){
         
        $cats = $this->con->sql("SELECT id_cat as id, nombre, parent_id FROM categorias WHERE id_page='1' AND eliminado='0' ORDER BY parent_id, orders");
        return $this->mostrar_arbol($cats['resultado'], 0);
        
    }
    public function arbol_categoria_html(){
         
        $cats = $this->con->sql("SELECT id_cat as id, nombre, parent_id FROM categorias WHERE id_page='1' AND eliminado='0' ORDER BY parent_id, orders");
        return $this->mostrar_arbol_html($cats['resultado'], 0, 0);
        
    }
    private function mostrar_arbol($list, $parent_id){
        
        for($i=0; $i<count($list); $i++){
            
            $id = $list[$i]['id'];
            $nombre = $list[$i]['nombre'];
            $p_id = $list[$i]['parent_id'];
            
            if($parent_id == $p_id){
                
                $aux['id'] = $id;
                $aux['nombre'] = $nombre;
                $child = $this->mostrar_arbol($list, $id);
                
                if(is_array($child)){
                    $aux['child'] = $child;
                }
                
                $res[] = $aux;
                unset($aux);
                
            }
        }
        
        return $res;
    }
    private function mostrar_arbol_html($list, $parent_id, $nivel){
        
        $colores = ["#efefef", "#e6e6e6", "#e0e0e0", "#d9d9d9", "#d0d0d0", "#c9c9c9"];
        $output = "<div class='categoria' style='background: ".$colores[$nivel].";'>";
        
        $nivel++;
        for($i=0; $i<count($list); $i++){

            $id = $list[$i]['id'];
            $nombre = $list[$i]['nombre'];
            $p_id = $list[$i]['parent_id'];

            if($parent_id == $p_id){
                
                $child = $this->mostrar_arbol($list, $id);
                
                $dis = "";
                if(is_array($child)){
                    $dis = "disabled='true'";
                }
                
                $output .= "<div class='oplist clearfix'><div class='inp'><input id='tareas' ".$dis." type='checkbox' value='categoria-".$id."' /></div><div class='nom'><div class='nom_t'>".$nombre."</div>";
                
                if(is_array($child)){
                    $output .= $this->mostrar_arbol_html($list, $id, $nivel);
                }
                
                $output .= "</div></div>";
                
            }
            
            
        }
        $output .= "</div>";
        
        return $output;
    }
    public function get_config(){
        
        $config = $this->con->sql("SELECT * FROM configuracion WHERE id_page='1'");
        return $config['resultado'][0];
        
    }
    public function get_categorias($id){
        
        $cats = $this->con->sql("SELECT * FROM categorias WHERE id_page='1' AND parent_id='".$id."' AND eliminado='0' ORDER BY orders");
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
        $cats = $this->con->sql("SELECT * FROM categorias WHERE id_page='1' AND id_cat='".$id."' AND eliminado='0'");
        return $cats['resultado'][0];
    }
    public function get_productos($id_cat){
        
        if($id_cat == 0){
            $prods = $this->con->sql("SELECT * FROM productos WHERE id_page='1'");
        }else{
            $prods = $this->con->sql("SELECT * FROM productos t1, cat_pro t2 WHERE t1.id_page='1' AND t2.id_cat='".$id."' AND t2.id_pro=t1.pro");
        }
        return $prods['resultado'];
        
    }
    public function get_producto($id){
        
        $cats = $this->con->sql("SELECT * FROM productos WHERE id_page='1' AND id_pro='".$id."'");
        return $cats['resultado'][0];
        
    }
    public function get_usuarios(){
        
        $user = $this->con->sql("SELECT * FROM usuarios WHERE block='0' AND id_page='1'");
        return $user['resultado'];
        
    }
    public function get_usuario($id){
        
        $user = $this->con->sql("SELECT * FROM usuarios WHERE block='0' AND id_user='".$id."'");
        return $user['resultado'][0];
        
    }
    public function get_tareas(){
        
        $tareas = $this->con->sql("SELECT * FROM tareas t1, paginas t2, paginas_tareas t3 WHERE t1.eliminado='0'");
        return $tareas['resultado'];
        
    }
    public function get_perfiles(){
        
        $perfiles = $this->con->sql("SELECT * FROM perfiles WHERE eliminado='0' AND id_page='1'");
        return $perfiles['resultado'];
        
    }
    public function get_perfil($id){
        
        $perfiles = $this->con->sql("SELECT * FROM perfiles WHERE eliminado='0' AND id_page='1' AND id_per='".$id."'");
        return $perfiles['resultado'][0];
        
    }
}
?>