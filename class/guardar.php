<?php
session_start();

require_once $path_.'/core.php';

class Guardar extends Core{
    
    public $con = null;
    public $id_page = null;
    
    public function __construct(){
        $this->con = new Conexion();
        $this->id_page = $this->get_idpage();
    }
    private function get_idpage(){
        return 1;
    }
    public function process(){

        // CRAER //
        if($_POST['accion'] == "crearcategoria"){
            return $this->crearcategoria();
        }
        if($_POST['accion'] == "crearusuarios"){
            return $this->crearusuarios();
        }
        
        // OTROS //
        if($_POST['accion'] == "ordercat"){
            return $this->ordercat();
        }
        if($_POST['accion'] == "configuracion"){
            return $this->configuracion();
        }
        
        // ASIGNAR //
        if($_POST['accion'] == "asignartareascia"){
            return $this->asignartareascia();
        }
        
        
        // ELIMINAR //
        if($_POST['accion'] == "eliminarperfilcia"){
            return $this->eliminarperfilcia();
        }
        
        
        
    }
    private function ordercat(){
        
        if($this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $values = $_POST['values'];
        for($i=0; $i<count($values); $i++){
            $this->con->sql("UPDATE categorias SET orders='".$i."' WHERE id_cat='".$values[$i]."'");
        }
        
    }
    private function configuracion(){
        
        if($this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $titulo = $_POST["titulo"];
        $subtitulo = $_POST["subtitulo"];
        $tema = $_POST["tema"];
        $perfiles = $_POST["perfiles"];
        
        $this->con->sql("UPDATE configuracion SET titulo='".$titulo."', subtitulo='".$subtitulo."' WHERE id_page='".$this->id_page."'");
        
        $info['op'] = 1;
        $info['mensaje'] = "Configuracion modificada exitosamente";
        
        return $info;
        
    }
    private function crearcategoria(){
        
        if($this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $parent_id = $_POST['parent_id'];

        if($id == 0){
            $this->con->sql("INSERT INTO categorias (nombre, fecha_creado, parent_id, id_page) VALUES ('".$nombre."', now(), '".$parent_id."', '".$this->id_page."')");
            $info['op'] = 1;
            $info['mensaje'] = "Categoria creada exitosamente";
        }
        if($id > 0){
            $this->con->sql("UPDATE categorias SET nombre='".$nombre."' WHERE id_cat='".$id."' AND id_page='".$this->id_page."'");
            $info['op'] = 1;
            $info['mensaje'] = "Categoria modificada exitosamente";
        }
                
        $info['reload'] = 1;
        $info['page'] = "crear_categoria.php?parent_id=".$parent_id;
        return $info;
        
    }
    private function crearusuarios(){
        
        /*
        if($this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        */
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];

        if($id == 0){
            $a = $this->con->sql("INSERT INTO usuarios (nombre, correo, fecha_creado, id_page) VALUES ('".$nombre."', '".$correo."', now(), '".$this->id_page."')");
            $info['db'] = $a;
            $info['op'] = 1;
            $info['mensaje'] = "Usuario ingresado exitosamente";
        }
        if($id > 0){
            $this->con->sql("UPDATE usuarios SET nombre='".$nombre."', correo='".$correo."' WHERE id_user='".$id."' AND id_page='".$this->id_page."'");
            $info['op'] = 1;
            $info['mensaje'] = "Usuario modificada exitosamente";
        }
                
        $info['reload'] = 1;
        $info['page'] = "crear_usuario.php";
        return $info;
        
    }
    private function crearproducto(){
        
        if($this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        if($id == 0){
            $this->con->sql("INSERT INTO productos (nombre, fecha_creado, parent_id, id_page) VALUES ('".$nombre."', now(), '".$parent_id."', '".$this->id_page."')");
            $info['op'] = 1;
            $info['mensaje'] = "Categoria creada exitosamente";
        }
        if($id > 0){
            $this->con->sql("UPDATE productos SET nombre='".$nombre."' WHERE id_pro='".$id."' AND id_page='".$this->id_page."'");
            $info['op'] = 1;
            $info['mensaje'] = "Categoria modificada exitosamente";
        }
                
        $info['reload'] = 1;
        $info['page'] = "crear_producto.php";
        return $info;
        
    }
    
    public function eliminarcategoria(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $this->con->sql("UPDATE categorias SET fecha_eliminado=now(), eliminado='1' WHERE id_cat='".$id."' AND id_page='".$this->id_page."'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Categoria ".$_POST["nombre"]." Eliminada";
        $info['reload'] = 1;
        $info['page'] = "crear_categoria.php";

        return $info;
        
    }
    public function eliminarproducto(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $this->con->sql("UPDATE producto SET fecha_eliminado=now(), eliminado='1' WHERE id_pro='".$id."' AND id_page='".$this->id_page."'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Producto ".$_POST["nombre"]." Eliminado";
        $info['reload'] = 1;
        $info['page'] = "crear_producto.php";

        return $info;
        
    }

}
