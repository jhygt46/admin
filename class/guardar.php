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
        if($_POST['accion'] == "order"){
            return $this->order();
        }
        if($_POST['accion'] == "configuracion"){
            return $this->configuracion();
        }
        // ASIGNAR //
        if($_POST['accion'] == "asignartareascia"){
            return $this->asignartareascia();
        }
        // ELIMINAR //
        if($_POST['accion'] == "eliminarusuarios"){
            return $this->eliminarusuarios();
        }
        
        if($_POST['accion'] == "_jardinva_crearalumnos"){
            return $this->_jardinva_crearalumnos();
        }
        if($_POST['accion'] == "_jardinva_crearcurso"){
            return $this->_jardinva_crearcurso();
        }
        if($_POST['accion'] == "_jardinva_eliminarcurso"){
            return $this->_jardinva_eliminarcurso();
        }
        if($_POST['accion'] == "_jardinva_eliminaralumnos"){
            return $this->_jardinva_eliminaralumnos();
        }
        
        
        
    }
    private function order(){
        /*
        if($this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        */
        $id = $_POST["id"];
        if($_POST["tabla"] == "_cursos_md01")
            $tabla = "_jardinva_cursos";
        if($_POST["tabla"] == "_cursos_md02")
            $tabla = "_jardinva_alumnos";

        $values = $_POST['values'];
        for($i=0; $i<count($values); $i++){
            $this->con->sql("UPDATE ".$tabla." SET orders='".$i."' WHERE ".$id."='".$values[$i]."' AND id_page='".$this->id_page."'");
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
            $this->con->sql("INSERT INTO usuarios (nombre, correo, fecha_creado, id_page) VALUES ('".$nombre."', '".$correo."', now(), '".$this->id_page."')");
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
    private function _jardinva_crearalumnos(){
        
        /*
        if($this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        */
        
        $id = $_POST['id'];
        $nombres = $_POST['nombres'];
        $apellidos = $_POST['apellidos'];
        $rut = $_POST['rut'];
        $direccion = $_POST['direccion'];
        $curso = $_POST['curso'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        
        $nombre_01 = $_POST['nombre_01'];
        $celular_01 = $_POST['celular_01'];
        $casa_01 = $_POST['casa_01'];
        $oficina_01 = $_POST['oficina_01'];
        $email_01 = $_POST['email_01'];
        
        $nombre_02 = $_POST['nombre_02'];
        $celular_02 = $_POST['celular_02'];
        $casa_02 = $_POST['casa_02'];
        $oficina_02 = $_POST['oficina_02'];
        $email_02 = $_POST['email_02'];
        
        
        if($id == 0){
            $a = $this->con->sql("INSERT INTO _jardinva_alumnos (nombres, apellidos, fecha_creado, fecha_nacimiento, rut, direccion, id_cur, id_page, nombre_01, celular_01, casa_01, oficina_01, email_01, nombre_02, celular_02, casa_02, oficina_02, email_02) VALUES ('".$nombres."', '".$apellidos."', now(), '".$fecha_nacimiento."', '".$rut."', '".$direccion."', '".$curso."', '".$this->id_page."', '".$nombre_01."', '".$celular_01."', '".$casa_01."', '".$oficina_01."', '".$email_01."', '".$nombre_02."', '".$celular_02."', '".$casa_02."', '".$oficina_02."', '".$email_02."')");
            $info['db'] = $a;
            $info['op'] = 1;
            $info['mensaje'] = "Alumno ingresado exitosamente";
        }
        if($id > 0){
            $this->con->sql("UPDATE _jardinva_alumnos SET nombres='".$nombres."', apellidos='".$apellidos."', fecha_nacimiento='".$fecha_nacimiento."', rut='".$rut."', direccion='".$direccion."', id_cur='".$curso."', nombre_01='".$nombre_01."', casa_01='".$casa_01."', celular_01='".$celular_01."', oficina_01='".$oficina_01."', email_01='".$email_01."', nombre_02='".$nombre_02."', casa_02='".$casa_02."', celular_02='".$celular_02."', oficina_02='".$oficina_02."', email_02='".$email_02."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $info['op'] = 1;
            $info['mensaje'] = "Alumno modificado exitosamente";
        }
                
        $info['reload'] = 1;
        $info['page'] = "_jardinva_info_alumnos.php";
        return $info;
        
    }
    private function _jardinva_crearcurso(){
        
        /*
        if($this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        */
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        
        if($id == 0){
            $a = $this->con->sql("INSERT INTO _jardinva_cursos (nombre, id_page) VALUES ('".$nombre."', '".$this->id_page."')");
            $info['db'] = $a;
            $info['op'] = 1;
            $info['mensaje'] = "Curso ingresado exitosamente";
        }
        if($id > 0){
            $this->con->sql("UPDATE _jardinva_cursos SET nombre='".$nombre."' WHERE id_cur='".$id."' AND id_page='".$this->id_page."'");
            $info['op'] = 1;
            $info['mensaje'] = "Curso modificado exitosamente";
        }
                
        $info['reload'] = 1;
        $info['page'] = "_jardinva_crear_cursos.php";
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
    public function eliminarusuarios(){
        
        /*
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        */
        
        $id = $_POST['id'];
        $this->con->sql("DELETE FROM usuarios WHERE id_user='".$id."' AND id_page='".$this->id_page."' AND admin='0'");
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Usuario ".$_POST["nombre"]." Eliminado";
        $info['reload'] = 1;
        $info['page'] = "crear_usuario.php";

        return $info;
        
    }
    public function _jardinva_eliminaralumnos(){
        
        /*
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        */
        
        $id = $_POST['id'];
        $this->con->sql("UPDATE _jardinva_alumnos SET eliminado='1' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Alumno ".$_POST["nombre"]." Eliminado";
        $info['reload'] = 1;
        $info['page'] = "_jardinva_info_alumnos.php";

        return $info;
        
    }

    public function _jardinva_eliminarcurso(){
        
        /*
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        */
        
        $id = $_POST['id'];
        $this->con->sql("UPDATE _jardinva_cursos SET eliminado='1' WHERE id_cur='".$id."' AND id_page='".$this->id_page."'");
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Curso ".$_POST["nombre"]." Eliminado";
        $info['reload'] = 1;
        $info['page'] = "_jardinva_crear_cursos.php";

        return $info;
        
    }

}
