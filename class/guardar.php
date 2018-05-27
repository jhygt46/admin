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
        return $_SESSION['user']['info']['id_page'];
    }
    public function process(){
        
        // CRAER //
        if($_POST['accion'] == "crearcategoria"){
            return $this->crearcategoria();
        }
        if($_POST['accion'] == "crearproductos"){
            return $this->crearproductos();
        }
        if($_POST['accion'] == "crearusuarios"){
            return $this->crearusuarios();
        }
        // IMAGEN //
        if($_POST['accion'] == "ingresarimagen"){
            return $this->ingresarimagen();
        }
        // OTROS //
        if($_POST['accion'] == "order"){
            return $this->order();
        }
        if($_POST['accion'] == "configuracion"){
            return $this->configuracion();
        }
        // ASIGNAR //
        if($_POST['accion'] == "guardar_asociar"){
            return $this->guardar_asociar();
        }
        // ELIMINAR //
        if($_POST['accion'] == "eliminarusuarios"){
            return $this->eliminarusuarios();
        }
        if($_POST['accion'] == "eliminarimage"){
            return $this->eliminarimage();
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
        if($_POST['accion'] == "_jardinva_eliminarboleta"){
            return $this->_jardinva_eliminarboleta();
        }
        if($_POST['accion'] == "_jardinva_eliminaralumnos"){
            return $this->_jardinva_eliminaralumnos();
        }
        if($_POST['accion'] == "_jardinva_crearboleta"){
            return $this->_jardinva_crearboleta();
        }
        
        if($_POST['accion'] == "_javiermo_crear_propiedad"){
            return $this->_javiermo_crear_propiedad();
        }
        if($_POST['accion'] == "_javiermo_eliminar_propiedad"){
            return $this->_javiermo_eliminar_propiedad();
        }
        
        if($_POST['accion'] == "_mika_crear_categoria"){
            return $this->_mika_crear_categoria();
        }
        if($_POST['accion'] == "_mika_crear_promos"){
            return $this->_mika_crear_promos();
        }
        if($_POST['accion'] == "_mika_crear_ingredientes"){
            return $this->_mika_crear_ingredientes();
        }
        
        if($_POST['accion'] == "_mika_eliminar_categoria"){
            return $this->_mika_eliminar_categoria();
        }
        if($_POST['accion'] == "_mika_crear_envoltura"){
            return $this->_mika_crear_envoltura();
        }
        if($_POST['accion'] == "_mika_eliminar_envoltura"){
            return $this->_mika_eliminar_envoltura();
        }
        if($_POST['accion'] == "_mika_crear_producto"){
            return $this->_mika_crear_producto();
        }
        if($_POST['accion'] == "_mika_eliminar_producto"){
            return $this->_mika_eliminar_producto();
        }
        if($_POST['accion'] == "_mika_eliminar_promocion"){
            return $this->_mika_eliminar_promocion();
        }
        if($_POST['accion'] == "_mika_eliminar_ingrediente"){
            return $this->_mika_eliminar_ingrediente();
        }
        
        
    }
    private function order(){

        $id = $_POST["id"];
        if($_POST["tabla"] == "_cursos_md01")
            $tabla = "_jardinva_cursos";
        if($_POST["tabla"] == "_cursos_md02")
            $tabla = "_jardinva_alumnos";
        if($_POST["tabla"] == "_propiedades")
            $tabla = "_javiermo_propiedades";
        if($_POST["tabla"] == "_category_mika")
            $tabla = "_mika_categorias";
        if($_POST["tabla"] == "_promos_mika")
            $tabla = "_mika_promos";
        if($_POST["tabla"] == "_product_mika")
            $tabla = "_mika_productos";

        $values = $_POST['values'];
        for($i=0; $i<count($values); $i++){
            $a[] = $this->con->sql("UPDATE ".$tabla." SET orders='".$i."' WHERE ".$id."='".$values[$i]."' AND id_page='".$this->id_page."'");
        }
        return $a;
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
    private function crearproductos(){
        /*
        if($this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        */
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio = $_POST['precio'];

        if($id == 0){
            $a = $this->con->sql("INSERT INTO productos (nombre, descripcion, precio, fecha_creado, id_page) VALUES ('".$nombre."', '".$descripcion."', '".$precio."', now(), '".$this->id_page."')");
            $info['db'] = $a;
            $info['op'] = 1;
            $info['mensaje'] = "Producto creado exitosamente";
        }
        if($id > 0){
            $this->con->sql("UPDATE productos SET nombre='".$nombre."', descripcion='".$descripcion."', precio='".$precio."' WHERE id_pro='".$id."' AND id_page='".$this->id_page."'");
            $info['op'] = 1;
            $info['mensaje'] = "Producto modificada exitosamente";
        }
                
        $info['reload'] = 1;
        $info['page'] = "crear_producto.php";
        return $info;
        
    }
    private function crearcategoria(){
        /*
        if($this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        */
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
    private function guardar_asociar(){
        
        /*
        if($this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        */
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        
        
    }
    
    private function _mika_crear_envoltura(){
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        
        $info = $this->con->sql("SELECT * FROM _mika_categorias WHERE id_cat='".$id."' AND id_page='".$this->id_page."' AND eliminado='0'");
        $env = json_decode($info['resultado'][0]['envoltura']);
        $env[] = $nombre;

        $this->con->sql("UPDATE _mika_categorias SET envoltura='".json_encode($env)."' WHERE id_cat='".$id."' AND id_page='".$this->id_page."' AND eliminado='0'");

        $info['op'] = 1;
        $info['mensaje'] = "Envoltura Ingresada Exitosamente";
        $info['reload'] = 1;
        $info['page'] = "_mika_envoltura.php?id=".$id;
        return $info;
        
    }
    
    private function _mika_eliminar_envoltura(){
        
        $idr = explode("/", $_POST['id']);
        $id = $idr[0];
        $pos = $idr[1];
        
        $infor = $this->con->sql("SELECT * FROM _mika_categorias WHERE id_cat='".$id."' AND id_page='".$this->id_page."' AND eliminado='0'");
        $env = json_decode($infor['resultado'][0]['envoltura']);
        
        array_splice($env, $pos, 1);
        
        $this->con->sql("UPDATE _mika_categorias SET envoltura='".json_encode($env)."' WHERE id_cat='".$id."' AND id_page='".$this->id_page."' AND eliminado='0'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Envoltura ".$_POST["nombre"]." Eliminada";
        $info['reload'] = 1;
        $info['page'] = "_mika_envoltura.php?id=".$id;
        return $info;
        
    }
    
    private function ingresarimagen(){
        
        $foto = $this->subirfoto();

        if($_POST["db"] == "tour"){
            $db_name = "_jardinva_tour";
            $id = "id_tour";
        }
        if($_POST["db"] == "propiedades"){
            $db_name = "_javiermo_propiedades";
            $id = "id_pro";
        }
        if($_POST["db"] == "mika_sushi"){
            $db_name = "_mika_categorias";
            $id = "id_cat";
        }
        
        $info['op'] = 2;
        $info['mensaje'] = "Error al subir la imagen";
        
        if($foto['op'] == 1 && isset($db_name)){
            
            $info = $this->con->sql("SELECT * FROM ".$db_name." WHERE ".$id."='".$_POST["id"]."' AND id_page='".$this->id_page."'");
            $images = json_decode($info['resultado'][0]['images']);
            $images[] = $foto['name'];
            $info['images'] = $images;
            
            $this->con->sql("UPDATE ".$db_name." SET images='".json_encode($images)."' WHERE ".$id."='".$_POST["id"]."' AND id_page='".$this->id_page."'");
            
            $info['op'] = 1;
            $info['mensaje'] = "Imagen subida";
            $info['reload'] = 1;
            $info['page'] = "asignar_imagen.php?db=".$_POST["db"]."&id=".$_POST["id"];
            
            
        }  
            
        return $info;
        
        
    }

    private function subirfoto(){
        
        $file_formats = array("jpg", "png", "gif");
        
        if($_SERVER['HTTP_HOST'] == "localhost"){
            $filepath = "C:/Appserv/www/admin/images/uploads/".$this->id_page."/";
        }else{
            $filepath = "/var/www/html/admin/public_html/admin/images/uploads/".$this->id_page."/";
        }
        
        $name = $_FILES['file_image0']['name']; // filename to get file's extension
        $size = $_FILES['file_image0']['size'];
        
        if (strlen($name)){
            $ext = strtolower(end(explode(".", $name)));
            if (in_array($ext, $file_formats)) { // check it if it's a valid format or not
                if ($size < (2048 * 1024)) { // check it if it's bigger than 2 mb or no
                    $imagename = md5(uniqid() . time()) . "." . $ext;
                    $tmp = $_FILES['file_image0']['tmp_name'];
                    if (move_uploaded_file($tmp, $filepath . $imagename)){
                        $info['op'] = 1;
                        $info['mensaje'] = "Imagen subida";
                        $info['name'] = $imagename;
                    } else {
                        $info['op'] = 2;
                        $info['mensaje'] = "No se pudo subir la imagen";
                    }
                } else {
                    $info['op'] = 2;
                    $info['mensaje'] = "Imagen sobrepasa los 2MB establecidos";
                }
            } else {
                $info['op'] = 2;
                $info['mensaje'] = "Formato Invalido";
            }
        } else {
            $info['op'] = 2;
            $info['mensaje'] =  "No ha seleccionado una imagen";
        }
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

    private function _mika_crear_producto(){
        
        $id_cat = $_POST['id_cat'];
        $id_pro = $_POST['id_pro'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $numero = $_POST['numero'];
        
        if($id_pro > 0){
            $this->con->sql("UPDATE _mika_productos SET numero='".$numero."', nombre='".$nombre."', precio='".$precio."'  WHERE id_pro='".$id_pro."' AND id_page='".$this->id_page."'");
            $info['op'] = 1;
            $info['mensaje'] = "Producto modificada exitosamente";
        }
        if($id_pro == 0){
            $pro = $this->con->sql("INSERT INTO _mika_productos (numero, nombre, precio, id_cat, id_page) VALUES ('".$numero."', '".$nombre."', '".$precio."', '".$id_cat."', '".$this->id_page."')");
            $info['op'] = 1;
            $info['mensaje'] = "Producto ingresado exitosamente";
            $id_pro = $pro['insert_id'];
        }
        
        if($this->id_page == 4){
            
            $ingredientes = $admin->con->sql("SELECT * FROM _mika_ingredientes WHERE id_page='".$this->id_page."' AND eliminado='0'");
            for($i=0; $i<$ingredientes['count']; $i++){
                
                $post = $_POST['ing-'.$ingredientes['resultado'][$i]['id_ing']];
                if($post == 0){
                    $admin->con->sql("DELETE FROM _mika_ing_prod WHERE id_pro='".$id_pro."' AND id_ing='".$ingredientes['resultado'][$i]['id_ing']."'");
                }
                if($post == 1){
                    $admin->con->sql("INSERT INTO _mika_ing_prod (id_pro, id_ing) VALUES ('".$id_pro."', '".$ingredientes['resultado'][$i]['id_ing']."')");
                }
                
            }
            
        }
        
        $info['reload'] = 1;
        $info['page'] = "_mika_productos.php?id=".$id_cat;
        return $info;
        
    }
    private function _mika_eliminar_producto(){
        
        $id = $_POST['id'];
        
        $aux = $this->con->sql("SELECT * FROM _mika_productos WHERE id_pro='".$id."' AND id_page='".$this->id_page."'");
        $this->con->sql("UPDATE _mika_productos SET eliminado='1' WHERE id_pro='".$id."' AND id_page='".$this->id_page."'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Producto ".$_POST["nombre"]." Eliminado";
        $info['reload'] = 1;
        $info['page'] = "_mika_productos.php?id=".$aux['resultado'][0]['id_cat'];

        return $info;
        
    }
        
    private function _mika_crear_categoria(){
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $sub_txt = $_POST['sub_txt'];
        
        if($id == 0){
            
            $this->con->sql("INSERT INTO _mika_categorias (nombre, precio, sub_txt, orders, id_page) VALUES ('".$nombre."', '".$precio."', '".$sub_txt."', 0, '".$this->id_page."')");
            $info['op'] = 1;
            $info['mensaje'] = "Categoria ingresada exitosamente";
        }
        if($id > 0){
            $this->con->sql("UPDATE _mika_categorias SET nombre='".$nombre."', precio='".$precio."', sub_txt='".$sub_txt."'  WHERE id_cat='".$id."' AND id_page='".$this->id_page."'");
            $info['op'] = 1;
            $info['mensaje'] = "Categoria modificada exitosamente";
        }    
        $info['reload'] = 1;
        $info['page'] = "_mika_crear_categoria.php";
        return $info;
        
        
    }
    private function _mika_eliminar_categoria(){
        
        $id = $_POST['id'];
        $this->con->sql("UPDATE _mika_categorias SET eliminado='1' WHERE id_cat='".$id."' AND id_page='".$this->id_page."'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Categoria ".$_POST["nombre"]." Eliminada";
        $info['reload'] = 1;
        $info['page'] = "_mika_crear_categoria.php";

        return $info;
        
    }
    private function _mika_crear_ingredientes(){
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $tipo = $_POST['tipo'];
        
        if($id == 0){
            $this->con->sql("INSERT INTO _mika_ingredientes (nombre, tipo, id_page) VALUES ('".$nombre."', '".$tipo."', '".$this->id_page."')");
            $info['op'] = 1;
            $info['mensaje'] = "Ingrediente ingresada exitosamente";
        }
        if($id > 0){
            $this->con->sql("UPDATE _mika_ingredientes SET nombre='".$nombre."', tipo='".$tipo."' WHERE id_ing='".$id."' AND id_page='".$this->id_page."'");
            $info['op'] = 1;
            $info['mensaje'] = "Ingrediente modificada exitosamente";
        }    
        $info['reload'] = 1;
        $info['page'] = "_mika_crear_ingredientes.php";
        return $info;
        
        
    }
    private function _mika_crear_promos(){
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $precio = $_POST['precio'];
        $texto = $_POST['texto'];
        
        if($id == 0){
            
            $a = $this->con->sql("INSERT INTO _mika_promos (nombre, precio, texto, orders, id_page) VALUES ('".$nombre."', '".$precio."', '".$texto."', 0, '".$this->id_page."')");
            $info['op'] = 1;
            $info['mensaje'] = "Promocion ingresada exitosamente";
        }
        if($id > 0){
            $this->con->sql("UPDATE _mika_promos SET nombre='".$nombre."', precio='".$precio."', texto='".$texto."'  WHERE id_prom='".$id."' AND id_page='".$this->id_page."'");
            $info['op'] = 1;
            $info['mensaje'] = "Promocion modificada exitosamente";
        }    
        $info['reload'] = 1;
        $info['page'] = "_mika_crear_promos.php";
        return $info;
        
        
    }
    private function _mika_eliminar_ingrediente(){
        
        $id = $_POST['id'];
        $this->con->sql("UPDATE _mika_ingredientes SET eliminado='1' WHERE id_ing='".$id."' AND id_page='".$this->id_page."'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Ingrediente ".$_POST["nombre"]." Eliminado";
        $info['reload'] = 1;
        $info['page'] = "_mika_crear_ingredientes.php";

        return $info;
        
    }
    private function _mika_eliminar_promocion(){
        
        $id = $_POST['id'];
        $this->con->sql("UPDATE _mika_promos SET eliminado='1' WHERE id_prom='".$id."' AND id_page='".$this->id_page."'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Promocion ".$_POST["nombre"]." Eliminada";
        $info['reload'] = 1;
        $info['page'] = "_mika_crear_promos.php";

        return $info;
        
    }
    
    
    
    private function _javiermo_crear_propiedad(){
        
        $id = $_POST['id'];
        
        $nombre = $_POST['nombre'];
        $tipo = $_POST['tipo'];
        $naturaleza = $_POST['naturaleza'];
        $precio_normal = $_POST['precio_normal'];
        $precio_uf = $_POST['precio_uf'];
        $direccion = $_POST['direccion'];
        $supercifie_util = $_POST['supercifie_util'];
        $supercifie_total = $_POST['supercifie_total'];
        $dormitorios = $_POST['dormitorios'];
        $banos = $_POST['banos'];
        $cocina = $_POST['cocina'];
        $codigo = $_POST['codigo'];
        $descripcion = $_POST['descripcion'];
        $estacionamiento = $_POST['estacionamiento'];
        $bodega = $_POST['bodega'];
        
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];
        $mapa = $_POST['pac-input'];
        
        if($id == 0){
            $this->con->sql("INSERT INTO _javiermo_propiedades (mapa, lat, lng, nombre, tipo, naturaleza, precio_normal, precio_uf, direccion, supercifie_util, supercifie_total, dormitorios, banos, cocina, codigo, descripcion, orders, bodega, estacionamiento, id_page) VALUES ('".$mapa."', '".$lat."', '".$lng."', '".$nombre."', '".$tipo."', '".$naturaleza."', '".$precio_normal."', '".$precio_uf."', '".$direccion."', '".$supercifie_util."', '".$supercifie_total."', '".$dormitorios."', '".$banos."', '".$cocina."', '".$codigo."', '".$descripcion."', '9999', '".$bodega."', '".$estacionamiento."', '".$this->id_page."')");
            $info['op'] = 1;
            $info['mensaje'] = "Propiedad ingresada exitosamente";
        }
        if($id > 0){
            $this->con->sql("UPDATE _javiermo_propiedades SET mapa='".$mapa."', lat='".$lat."', lng='".$lng."', nombre='".$nombre."', tipo='".$tipo."', naturaleza='".$naturaleza."', precio_normal='".$precio_normal."', precio_uf='".$precio_uf."', direccion='".$direccion."', supercifie_util='".$supercifie_util."', supercifie_total='".$supercifie_total."', dormitorios='".$dormitorios."', banos='".$banos."', cocina='".$cocina."', codigo='".$codigo."', descripcion='".$descripcion."', bodega='".$bodega."', estacionamiento='".$estacionamiento."'  WHERE id_pro='".$id."' AND id_page='".$this->id_page."'");
            $info['op'] = 1;
            $info['mensaje'] = "Propiedad modificada exitosamente";
        }
        $info['db'] = $db;     
        $info['reload'] = 1;
        $info['page'] = "_javiermo_crear_propiedad.php";
        return $info;
        
    }
    private function _javiermo_eliminar_propiedad(){
        
        $id = $_POST['id'];
        $this->con->sql("UPDATE _javiermo_propiedades SET eliminado='1' WHERE id_pro='".$id."' AND id_page='".$this->id_page."'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Propiedad ".$_POST["nombre"]." Eliminada";
        $info['reload'] = 1;
        $info['page'] = "_javiermo_crear_propiedad.php";

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
        
        $nmatricula = $_POST['nmatricula'];
        $rut = $_POST['rut'];
        $apellido_p = $_POST['apellido_p'];
        $apellido_m = $_POST['apellido_m'];
        $nombres = $_POST['nombres'];
        $sexo = $_POST['sexo'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];
        $fecha_matricula = $_POST['fecha_matricula'];
        $fecha_ingreso = $_POST['fecha_ingreso'];
        $direccion = $_POST['direccion'];
        $nombre_apoderado = $_POST['nombre_apoderado'];
        $telefono_apoderado = $_POST['telefono_apoderado'];
        $email_apoderado = $_POST['email_apoderado'];
        $fecha_retiro = $_POST['fecha_retiro'];
        $motivo_retiro = $_POST['motivo_retiro'];
        $observaciones = $_POST['observaciones'];
        $curso = $_POST['curso'];
        
        $nombre_01 = $_POST['nombre_01'];
        $nombre_02 = $_POST['nombre_02'];
        
        $celular_01 = $_POST['celular_01'];
        $celular_02 = $_POST['celular_02'];
        
        $email_01 = $_POST['email_01'];
        $email_02 = $_POST['email_02'];
        
        if($id == 0){
            
            $a = $this->con->sql("INSERT INTO _jardinva_alumnos (id_page) VALUES ('".$this->id_page."')");
            $id = $a['insert_id'];
            $info['op'] = 1;
            $info['mensaje'] = "Alumno ingresado exitosamente";
            
        }
        if($id > 0){
            
            $this->con->sql("UPDATE _jardinva_alumnos SET nmatricula='".$nmatricula."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET rut='".$rut."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET apellido_p='".$apellido_p."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET apellido_m='".$apellido_m."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET nombres='".$nombres."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET sexo='".$sexo."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET fecha_nacimiento='".$fecha_nacimiento."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET fecha_matricula='".$fecha_matricula."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET fecha_ingreso='".$fecha_ingreso."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET direccion='".$direccion."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET nombre_apoderado='".$nombre_apoderado."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");$this->con->sql("UPDATE _jardinva_alumnos SET rut='".$rut."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET telefono_apoderado='".$telefono_apoderado."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET email_apoderado='".$email_apoderado."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET fecha_retiro='".$fecha_retiro."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET motivo_retiro='".$motivo_retiro."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET observaciones='".$observaciones."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            
            $this->con->sql("UPDATE _jardinva_alumnos SET id_cur='".$curso."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            
            $this->con->sql("UPDATE _jardinva_alumnos SET nombre_01='".$nombre_01."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET nombre_02='".$nombre_02."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            
            $this->con->sql("UPDATE _jardinva_alumnos SET celular_01='".$celular_01."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET celular_02='".$celular_02."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            
            $this->con->sql("UPDATE _jardinva_alumnos SET email_01='".$email_01."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            $this->con->sql("UPDATE _jardinva_alumnos SET email_02='".$email_02."' WHERE id_alu='".$id."' AND id_page='".$this->id_page."'");
            
            $info['op'] = 1;
            $info['mensaje'] = "Alumno modificado exitosamente";
            
        }
                
        $info['reload'] = 1;
        $info['page'] = "_jardinva_info_alumnos.php";
        return $info;
        
    }
    private function _jardinva_crearboleta(){
        
        /*
        if($this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        */
        
        $id = $_POST['id'];
        
        $nula = $_POST['nula'];
        $tipo = 1;
        $numero = $_POST['nboleta'];
        
        $dia = $_POST['dia'];
        $mes = $_POST['mes'];
        $año = $_POST['año'];
        
        $matricula = $_POST['matricula'];
        
        if($id == 0){
            $a = $this->con->sql("INSERT INTO _jardinva_boletas (numero, dia, mes, ano, tipo, nula, matricula, id_page) VALUES ('".$numero."', '".$dia."', '".$mes."', '".$año."', '".$tipo."', '".$nula."', '".$matricula."', '".$this->id_page."')");
            $info['db'] = $a;
            $info['op'] = 1;
            $info['mensaje'] = "Boleta ingresado exitosamente";
        }
        if($id > 0){
            $a = $this->con->sql("UPDATE _jardinva_boletas SET numero='".$numero."', dia='".$dia."', mes='".$mes."', ano='".$año."', tipo='".$tipo."', nula='".$nula."', matricula='".$matricula."', mjardin='".$mjardin."', msalacuna='".$msalacuna."' WHERE id_bol='".$id."' AND id_page='".$this->id_page."'");
            $info['db'] = $a;
            $info['op'] = 1;
            $info['mensaje'] = "Boleta modificado exitosamente";
        }
                
        $info['reload'] = 1;
        $info['page'] = "_jardinva_crear_boletas.php?mes=".$mes."&ano=".$año."&dia=".$dia;
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
    public function eliminarimage(){
        
        /*
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        */
        
        if($_SERVER['HTTP_HOST'] == "localhost"){
            $filepath = "C:/Appserv/www/admin/images/uploads/".$this->id_page."/";
        }else{
            $filepath = "/var/www/html/admin/public_html/admin/images/uploads/".$this->id_page."/";
        }
        
        $e = explode("/", $_POST["id"]);
        $db = $e[0];
        $id = $e[1];
        $pos = $e[2];
        
        if($db == "tour"){
            $db_name = "_jardinva_tour";
            $db_id = "id_tour";
        }
        if($db == "propiedades"){
            $db_name = "_javiermo_propiedades";
            $db_id = "id_pro";
        }
        if($db == "mika_sushi"){
            $db_name = "_mika_categorias";
            $db_id = "id_cat";
        }
        
        $info_image = $this->con->sql("SELECT images FROM ".$db_name." WHERE ".$db_id."='".$id."' AND id_page='".$this->id_page."'");
        $images = json_decode($info_image['resultado'][0]['images']);
        
        $file = $images[$pos];
        array_splice($images, $pos, 1);
        $this->con->sql("UPDATE ".$db_name." SET images='".json_encode($images)."' WHERE ".$db_id."='".$id."' AND id_page='".$this->id_page."'");
        
        if(file_exists($filepath.$file)){
            unlink($filepath.$file);
        }
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Imagen Eliminada";
        $info['reload'] = 1;
        $info['page'] = "asignar_imagen.php?db=".$db."&id=".$id;

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
    public function _jardinva_eliminarboleta(){
        
        /*
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        */
        $id = $_POST['id'];
        $that = $this->con->sql("SELECT * FROM _jardinva_boletas WHERE id_bol='".$id."' AND id_page='".$this->id_page."'");
        $this->con->sql("UPDATE _jardinva_boletas SET eliminado='1' WHERE id_bol='".$id."' AND id_page='".$this->id_page."'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Curso ".$_POST["nombre"]." Eliminado";
        $info['reload'] = 1;
        $info['page'] = "_jardinva_crear_boletas.php?ano=".$that['resultado'][0]['ano']."&mes=".$that['resultado'][0]['mes']."&dia=".$that['resultado'][0]['dia'];

        return $info;
        
    }

}
