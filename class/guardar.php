<?php
session_start();

require_once 'core.php';

class Guardar extends Core{
    
    public $con = null;
    public $id_cia = null;
    public $id_cue = null;
    
    public function __construct(){
        $this->id_cia = $this->getciaid();
        $this->id_cue = $this->getcueid();
        $this->con = new Conexion();
    }
    
    public function process(){

        // CRAER //
        if($_POST['accion'] == "crearcuerpo"){
            return $this->crearcuerpo();
        }
        if($_POST['accion'] == "crearcia"){
            return $this->crearcia();
        }
        if($_POST['accion'] == "crearusuario"){
            return $this->crearusuario();
        }
        if($_POST['accion'] == "crearperfilcia"){
            return $this->crearperfilcia();
        }
        if($_POST['accion'] == "crearperfilcue"){
            return $this->crearperfilcue();
        }
        if($_POST['accion'] == "crearcargoscia"){
            return $this->crearcargoscia();
        }
        if($_POST['accion'] == "crearcargoscue"){
            return $this->crearcargoscue();
        }
        if($_POST['accion'] == "crearcarrocia"){
            return $this->crearcarrocia();
        }
        if($_POST['accion'] == "creartipomaquina"){
            return $this->creartipomaquina();
        }
        if($_POST['accion'] == "crearclavecue"){
            return $this->crearclavecue();
        }
        if($_POST['accion'] == "crearclavecia"){
            return $this->crearclavecia();
        }
        if($_POST['accion'] == "creargrupocia"){
            return $this->creargrupocia();
        }
        if($_POST['accion'] == "creargrupocue"){
            return $this->creargrupocue();
        }
        if($_POST['accion'] == "crearacto"){
            return $this->crearacto();
        }
        
        // OTROS //
        if($_POST['accion'] == "ordercia"){
            return $this->ordercia();
        }
        if($_POST['accion'] == "configcia"){
            return $this->configcia();
        }
        if($_POST['accion'] == "configcue"){
            return $this->configcue();
        }
        
        // ASIGNAR //
        if($_POST['accion'] == "asignartareascia"){
            return $this->asignartareascia();
        }
        if($_POST['accion'] == "asignartareascue"){
            return $this->asignartareascue();
        }
        if($_POST['accion'] == "asignarperfilusuariocia"){
            return $this->asignarperfilusuariocia();
        }
        if($_POST['accion'] == "asignarperfilusuariocue"){
            return $this->asignarperfilusuariocue();
        }
        if($_POST['accion'] == "asignartareascargocia"){
            return $this->asignartareascargocia();
        }
        if($_POST['accion'] == "asignartareascargocue"){
            return $this->asignartareascargocue();
        }
        if($_POST['accion'] == "asignarcargousuarioscue"){
            return $this->asignarcargousuarioscue();
        }
        if($_POST['accion'] == "asignarcargousuarioscia"){
            return $this->asignarcargousuarioscia();
        }
        
        // ELIMINAR //
        if($_POST['accion'] == "eliminarperfilcia"){
            return $this->eliminarperfilcia();
        }
        if($_POST['accion'] == "eliminarperfilcue"){
            return $this->eliminarperfilcue();
        }
        if($_POST['accion'] == "eliminarcargoscia"){
            return $this->eliminarcargoscia();
        }
        if($_POST['accion'] == "eliminarcarrocia"){
            return $this->eliminarcarrocia();
        }
        if($_POST['accion'] == "eliminarusuario"){
            return $this->eliminarusuario();
        }
        if($_POST['accion'] == "eliminarcia"){
            return $this->eliminarcia();
        }
        if($_POST['accion'] == "eliminartipomaquina"){
            return $this->eliminartipomaquina();
        }
        if($_POST['accion'] == "eliminargrupocia"){
            return $this->eliminargrupocia();
        }
        if($_POST['accion'] == "eliminargrupocue"){
            return $this->eliminargrupocue();
        }
        if($_POST['accion'] == "eliminarclavecia"){
            return $this->eliminarclavecia();
        }
        if($_POST['accion'] == "eliminarclavecue"){
            return $this->eliminarclavecue();
        }
        
        
    }
    private function ordercia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $values = $_POST['values'];
        for($i=0; $i<count($values); $i++){
            $this->con->sql("UPDATE companias SET orden='".$i."' WHERE id_cia='".$values[$i]."'");
        }
        // ALGORITMO PARA ANTIGUEDAD
        
    }
    private function crearcuerpo(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $sigla = $_POST['sigla'];

        if($id == 0){
            $aux = $this->con->sql("INSERT INTO cuerpos (nombre, fecha_creado, sigla) VALUES ('".$nombre."', now(), '".$sigla."')");
            $info['op'] = 1;
            $info['mensaje'] = "Cuerpo creado exitosamente";
            $id_cue = $aux['insert_id'];
            $this->instalarcuerpo($id_cue);
        }
        if($id > 0){
            $aux = $this->con->sql("UPDATE cuerpos SET nombre='".$nombre."', sigla='".$sigla."' WHERE id_cue='".$id."'");
            $info['op'] = 1;
            $info['mensaje'] = "Cuerpo modificado exitosamente";
            $id_cue = $id;
        }
        
        $gtareas = $this->get_grupos_tareas();
        for($i=0; $i<count($gtareas); $i++){
            
            $id_gtar = $gtareas[$i]['id_gtar'];
            $aux2 = $_POST['gtarea-'.$id_gtar];
            
            $gtar_cue = $this->con->sql("SELECT * FROM tarea_grupo_cuerpo WHERE id_cue='".$id_cue."' AND id_gtar='".$id_gtar."'");
            
            if($aux2 == 1 && $gtar_cue['count'] == 0){
                $this->con->sql("INSERT INTO tarea_grupo_cuerpo (id_gtar, id_cue) VALUES ('".$id_gtar."', '".$id_cue."')");
            }
            if($aux2 == 0 && $gtar_cue['count'] == 1){
                $this->con->sql("DELETE FROM tarea_grupo_cuerpo WHERE id_gtar='".$id_gtar."' AND id_cue='".$id_cue."'");
            }
            
        }
        
        $info['reload'] = 1;
        $info['page'] = "crear_cuerpo.php";

        return $info;
        
    }
    
    private function crearcia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $numero = $_POST['numero'];

        if($id == 0){
            $aux = $this->con->sql("INSERT INTO companias (nombre, fecha_creado, numero, id_cue) VALUES ('".$nombre."', now(), '".$numero."', '".$this->id_cue."')");
            $info['op'] = 1;
            $info['mensaje'] = "Compañia creada exitosamente";
            $id_cia = $aux['insert_id'];
            $this->instalarcia($id_cia);
        }
        if($id > 0){
            $this->con->sql("UPDATE companias SET nombre='".$nombre."', numero='".$numero."' WHERE id_cia='".$id."' AND id_cue='".$this->id_cue."'");
            $info['op'] = 1;
            $info['mensaje'] = "Compañia modificada exitosamente";
            $id_cia = $id;
        }

        $this->con->sql("INSERT INTO cuerpo_cias_despacho (id_cue, id_cia) VALUES ('".$this->id_cue."', '".$id_cia."')");
        $info['reload'] = 1;
        $info['page'] = "crear_cias.php";

        return $info;
        
    }
    private function crearacto(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];
        $clave = $_POST['clave'];
        $direccion = $_POST['direccion'];
        $lat = $_POST['lat'];
        $lng = $_POST['lng'];

        if($id == 0){
            $aux = $this->con->sql("INSERT INTO actos (id_clave, direccion, lat, lng, id_cue) VALUES ('".$clave."', '".$direccion."', '".$lat."', '".$lng."', '".$this->id_cue."')");
            $info['carros'] = $this->get_carros_acto($aux['insert_id']);
        }
        if($id > 0){
            $this->con->sql("UPDATE actos SET id_clave='".$clave."', direccion='".$direccion."', lat='".$lng."', lat='".$lng."' WHERE id_act='".$id."' AND id_cue='".$this->id_cue."'");
        }
        
        

        return $info;
        
    }
    
    private function crearusuario(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        if($id == 0){
            $aux = $this->con->sql("INSERT INTO usuarios (nombre, fecha_creado, id_cia, id_cue) VALUES ('".$nombre."', now(), '".$this->id_cia."', '".$this->id_cue."')");
            $info['op'] = 1;
            $info['mensaje'] = "Usuario creado exitosamente";
        }
        if($id > 0){
            $aux = $this->con->sql("UPDATE usuarios SET nombre='".$nombre."' WHERE id_cue='".$id."' AND id_cia='".$this->id_cia."' AND id_cue='".$this->id_cue."'");
            $info['op'] = 1;
            $info['mensaje'] = "Usuario modificado exitosamente";
        }
        $info['reload'] = 1;
        $info['page'] = "usuarios.php";

        return $info;
        
    }
    
    private function creartipomaquina(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        if($id == 0){
            $aux = $this->con->sql("INSERT INTO tipos_de_carros (nombre, fecha_creado, id_cue) VALUES ('".$nombre."', now(), '".$this->id_cue."')");
            $info['op'] = 1;
            $info['mensaje'] = "Tipo de Maquina creado exitosamente";
        }
        if($id > 0){
            $aux = $this->con->sql("UPDATE tipos_de_carros SET nombre='".$nombre."' WHERE id_tdc='".$id."' AND id_cue='".$this->id_cue."'");
            $info['op'] = 1;
            $info['mensaje'] = "Tipo de Maquina modificado exitosamente";
        }
        $info['reload'] = 1;
        $info['page'] = "tipos_de_maquina.php";

        return $info;
        
    }
    private function crearcarrocia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id_car = 0;
        $id = $_POST['id'];
        $id_cia = $_POST['id_cia'];
        $nombre = $_POST['nombre'];

        if($id == 0){
            $aux = $this->con->sql("INSERT INTO carros (nombre, fecha_creado, id_cia, id_cue) VALUES ('".$nombre."', now(), '".$id_cia."', '".$this->id_cue."')");
            $info['op'] = 1;
            $info['mensaje'] = "Usuario creado exitosamente";
            $id_car = $aux['insert_id'];
        }
        if($id > 0){
            $aux = $this->con->sql("UPDATE carros SET nombre='".$nombre."' WHERE id_car='".$id."' AND id_cia='".$id_cia."' AND id_cue='".$this->id_cue."'");
            $info['op'] = 1;
            $info['mensaje'] = "Usuario modificado exitosamente";
            if($aux['estado']){ $id_car = $id; }
        }
        if($id_car > 0){
            
            $tdc = $this->get_tipos_maquinas();
            for($i=0; $i<count($tdc); $i++){
                
                $id_tdc = $tdc[$i]['id_tdc'];
                $auxs = $_POST['tdc-'.$id_tdc];
                $tipo_car = $this->con->sql("SELECT * FROM carros_tipo WHERE id_tdc='".$id_tdc."' AND id_car='".$id_car."'");
                
                if($auxs == 1 && $tipo_car['count'] == 0){
                    $this->con->sql("INSERT INTO carros_tipo (id_car, id_tdc) VALUES ('".$id_car."', '".$id_tdc."')");
                }
                if($auxs == 0 && $tipo_car['count'] == 1){
                    $this->con->sql("DELETE FROM carros_tipo WHERE id_car='".$id_car."' AND id_tdc='".$id_tdc."'");
                }
                
            }
            
        }
        $info['reload'] = 1;
        $info['page'] = "carros_cia.php?id=".$id_cia;
        return $info;
        
    }
    private function crearclavecue(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];
        $tipo = $_POST['tipo'];
        $iscia = $_POST['origen'];
        $nombre = $_POST['nombre'];
        $clave = $_POST['clave'];
        $grupo = $_POST['grupo'];
        $asist = $_POST['asist'];
        $falta = $_POST['falta'];
        $todos = $_POST['todos'];

        if($id == 0){
            $cla = $this->con->sql("INSERT INTO claves (nombre, clave, grupo, tipo, asist, falta, iscia, todos, id_cia, id_cue) VALUES ('".$nombre."', '".$clave."', '".$grupo."', '".$tipo."', '".$asist."', '".$falta."', '".$iscia."', '".$todos."', '0', '".$this->id_cue."')");
            $info['op'] = 1;
            $info['mensaje'] = "Clave creada exitosamente";
            $id_cla = $cla['insert_id'];
        }
        if($id > 0){
            $this->con->sql("UPDATE claves SET nombre='".$nombre."', clave='".$clave."', grupo='".$grupo."', tipo='".$tipo."', asist='".$asist."', falta='".$falta."', iscia='".$iscia."', todos='".$todos."' WHERE id_cla='".$id."' AND id_cia='0' AND id_cue='".$this->id_cue."'");
            $info['op'] = 1;
            $info['mensaje'] = "Clave modificada exitosamente";
            $id_cla = $id;
        }

        if($todos == 0){
            $grupos = $this->get_grupos_cue();
            for($i=0; $i<count($grupos); $i++){
                $id_gru =  $grupos[$i]["id_gru"];
                $gru = $_POST["gru-".$id_gru];
                $aux = $this->con->sql("SELECT * FROM clave_grupos WHERE id_cla='".$id_cla."' AND id_gru='".$id_gru."'");
                if($aux['count'] == 1 && $gru == 0){
                    $this->con->sql("DELETE FROM clave_grupos WHERE id_cla='".$id_cla."' AND id_gru='".$id_gru."'");
                }
                if($aux['count'] == 0 && $gru == 1){
                    $this->con->sql("INSERT INTO clave_grupos (id_cla, id_gru) VALUES ('".$id_cla."', '".$id_gru."')");
                }
            }
        }
        if($tipo == 1 || $tipo == 2){
            $tdcs = $this->get_tipos_maquinas();
            for($i=0; $i<count($tdcs); $i++){
                $id_tdc = $tdcs[$i]["id_tdc"];
                $tdc = $_POST["tdc-".$id_tdc];
                $aux = $this->con->sql("SELECT * FROM claves_tipo WHERE id_cla='".$id_cla."' AND id_tdc='".$id_tdc."'");
                if($aux['count'] == 1 && $tdc == ""){
                    $this->con->sql("DELETE FROM claves_tipo WHERE id_cla='".$id_cla."' AND id_tdc='".$id_tdc."'");
                }
                if($aux['count'] == 0 && $tdc > 0){
                    $this->con->sql("INSERT INTO claves_tipo (id_cla, id_tdc, cantidad) VALUES ('".$id_cla."', '".$id_tdc."', '".$tdc."')");
                }
            }
        }
        
        
        
        $info['reload'] = 1;
        $info['page'] = "tipos_de_claves_cue.php";
        
        return $info;
        
    }
    private function crearclavecia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $clave = $_POST['clave'];
        $asist = $_POST['asist'];
        $falta = $_POST['falta'];
        $todos = $_POST['todos'];

        if($id == 0){
            $cla = $this->con->sql("INSERT INTO claves (nombre, clave, asist, falta, iscia, todos, id_cia, id_cue) VALUES ('".$nombre."', '".$clave."', '".$asist."', '".$falta."', '1', '".$todos."', '".$this->id_cia."', '".$this->id_cue."')");
            $info['op'] = 1;
            $info['mensaje'] = "Clave creada exitosamente";
            $id_cla = $cla['insert_id'];
        }
        if($id > 0){
            $this->con->sql("UPDATE claves SET nombre='".$nombre."', clave='".$clave."', asist='".$asist."', falta='".$falta."', todos='".$todos."' WHERE id_cla='".$id."' AND id_cia='".$this->id_cia."' AND id_cue='".$this->id_cue."'");
            $info['op'] = 1;
            $info['mensaje'] = "Clave modificada exitosamente";
            $id_cla = $id;
        }
        
        if($todos == 0){
            $grupos = $this->get_grupos_cia();
            for($i=0; $i<count($grupos); $i++){
                $id_gru =  $grupos[$i]["id_gru"];
                $gru = $_POST["gru-".$id_gru];
                $aux = $this->con->sql("SELECT * FROM clave_grupos WHERE id_cla='".$id_cla."' AND id_gru='".$id_gru."'");
                if($aux['count'] == 1 && $gru == 0){
                    $this->con->sql("DELETE FROM clave_grupos WHERE id_cla='".$id_cla."' AND id_gru='".$id_gru."'");
                }
                if($aux['count'] == 0 && $gru == 1){
                    $this->con->sql("INSERT INTO clave_grupos (id_cla, id_gru) VALUES ('".$id_cla."', '".$id_gru."')");
                }
            }
        }
        
        $todos = $_POST['sincarros'];
        $carros = $this->get_carros_mi_cia();
        for($i=0; $i<count($carros); $i++){
            $id_car = $carros[$i]["id_car"];
            $car = $_POST["car-".$id_car];
            $aux = $this->con->sql("SELECT * FROM claves_carros WHERE id_cla='".$id_cla."' AND id_car='".$id_car."'");
            $info['aux'] = $car;
            if($aux['count'] == 1 && $car == 0){
                $info['db'][] = $this->con->sql("DELETE FROM claves_carros WHERE id_cla='".$id_cla."' AND id_car='".$id_car."'");
            }
            if($aux['count'] == 0 && $car > 0){
                $info['db'][] = $this->con->sql("INSERT INTO claves_carros (id_cla, id_car) VALUES ('".$id_cla."', '".$id_car."')");
            }
        }
        
        
        
        
        $info['reload'] = 1;
        $info['page'] = "tipos_de_claves_cia.php";
        
        return $info;
        
    }
    private function crearperfilcia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        if($id == 0){
            $aux = $this->con->sql("INSERT INTO perfiles (nombre, fecha_creado, id_cia, id_cue) VALUES ('".$nombre."', now(), '".$this->id_cia."', '".$this->id_cue."')");
            $info['op'] = 1;
            $info['mensaje'] = "Perfil creado exitosamente";
        }
        if($id > 0){
            $aux = $this->con->sql("UPDATE perfiles SET nombre='".$nombre."' WHERE id_per='".$id."' AND id_cia='".$this->id_cia."' AND id_cue='".$this->id_cue."'");
            $info['op'] = 1;
            $info['mensaje'] = "Perfil modificado exitosamente";
        }
        $info['reload'] = 1;
        $info['page'] = "perfiles_cia.php";
        
        return $info;
        
    }
    private function crearperfilcue(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        if($id == 0){
            $aux = $this->con->sql("INSERT INTO perfiles (nombre, fecha_creado, id_cia, id_cue) VALUES ('".$nombre."', now(), '0', '".$this->id_cue."')");
            $info['op'] = 1;
            $info['mensaje'] = "Perfil creado exitosamente";
        }
        if($id > 0){
            $aux = $this->con->sql("UPDATE perfiles SET nombre='".$nombre."' WHERE id_per='".$id."' AND id_cia='0' AND id_cue='".$this->id_cue."'");
            $info['op'] = 1;
            $info['mensaje'] = "Perfil modificado exitosamente";
        }
        $info['reload'] = 1;
        $info['page'] = "perfiles_cue.php";
        
        return $info;
        
    }
    private function creargrupocia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        if($id == 0){
            $aux = $this->con->sql("INSERT INTO grupos (nombre, fecha_creado, id_cia, id_cue) VALUES ('".$nombre."', now(), '".$this->id_cia."', '".$this->id_cue."')");
            $info['op'] = 1;
            $info['mensaje'] = "Perfil creado exitosamente";
            $id_gru = $aux['insert_id'];
        }
        if($id > 0){
            $this->con->sql("UPDATE grupos SET nombre='".$nombre."' WHERE id_gru='".$id."' AND id_cia='".$this->id_cia."' AND id_cue='".$this->id_cue."'");
            $info['op'] = 1;
            $info['mensaje'] = "Perfil modificado exitosamente";
            $id_gru = $id;
        }
        
        $cargos = $this->get_cargos_cia();
        for($i=0; $i<count($cargos); $i++){
            
            $id_carg = $cargos[$i]['id_carg'];
            $carg = $_POST["carg-".$id_carg];
            
            $auxs = $this->con->sql("SELECT * FROM grupos_cargos WHERE id_gru='".$id_gru."' AND id_carg='".$id_carg."'");
            if($auxs['count'] == 1 && $carg == 0){
                $this->con->sql("DELETE FROM grupos_cargos WHERE id_gru='".$id_gru."' AND id_carg='".$id_carg."'");
            }
            if($auxs['count'] == 0 && $carg > 0){
                $this->con->sql("INSERT INTO grupos_cargos (id_gru, id_carg) VALUES ('".$id_gru."', '".$id_carg."')");
            }
            
        }

        $info['reload'] = 1;
        $info['page'] = "grupos_cia.php";
        
        return $info;
        
    }
    private function creargrupocue(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];

        if($id == 0){
            $aux = $this->con->sql("INSERT INTO grupos (nombre, fecha_creado, id_cia, id_cue) VALUES ('".$nombre."', now(), '0', '".$this->id_cue."')");
            $info['op'] = 1;
            $info['mensaje'] = "Perfil creado exitosamente";
            $id_gru = $aux['insert_id'];
        }
        if($id > 0){
            $this->con->sql("UPDATE grupos SET nombre='".$nombre."' WHERE id_gru='".$id."' AND id_cia='0' AND id_cue='".$this->id_cue."'");
            $info['op'] = 1;
            $info['mensaje'] = "Perfil modificado exitosamente";
            $id_gru = $id;
        }
        
        $cargos = $this->get_cargos_cue();
        for($i=0; $i<count($cargos); $i++){
            
            $id_carg = $cargos[$i]['id_carg'];
            $carg = $_POST["carg-".$id_carg];
            
            $auxs = $this->con->sql("SELECT * FROM grupos_cargos WHERE id_gru='".$id_gru."' AND id_carg='".$id_carg."'"); 
            if($auxs['count'] == 1 && $carg == 0){
                $info['db'][] = $this->con->sql("DELETE FROM grupos_cargos WHERE id_gru='".$id_gru."' AND id_carg='".$id_carg."'");
            }
            if($auxs['count'] == 0 && $carg > 0){
                $info['db'][] = $this->con->sql("INSERT INTO grupos_cargos (id_gru, id_carg) VALUES ('".$id_gru."', '".$id_carg."')");
            }
            
        }

        $info['reload'] = 1;
        $info['page'] = "grupos_cue.php";
        
        return $info;
        
    }
    
    private function configcia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $post[0]['nombre'] = "nombre";
        $post[0]['valor'] = $_POST['nombre'];
        
        for($i=0; $i<count($post); $i++){
            $this->con->sql("UPDATE companias SET ".$post[$i]['nombre']."='".$post[$i]['valor']."' WHERE id_cia='".$this->id_cia."' AND id_cue='".$this->id_cue."'");
        }
        
        $info['op'] = 1;
        $info['mensaje'] = "Configuracion modificada exitosamente";
        
        return $info;
        
    }
    
    private function configcue(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $post[0]['nombre'] = "nombre";
        $post[0]['valor'] = $_POST['nombre'];
        
        for($i=0; $i<count($post); $i++){
            $this->con->sql("UPDATE cuerpos SET ".$post[$i]['nombre']."='".$post[$i]['valor']."' WHERE id_cue='".$this->id_cue."'");
        }
        
        $info['op'] = 1;
        $info['mensaje'] = "Configuracion modificada exitosamente";
        
        return $info;
        
    }
    
    private function asignartareascargocia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];

        $perfiles = $this->get_perfiles_cia();
        $cargo = $this->get_cargo_cia($id);

        if(isset($cargo['id_carg'])){

            $id_carg = $cargo['id_carg'];
            for($i=0; $i<count($perfiles); $i++){

                $id_per = $perfiles[$i]['id_per'];
                $aux = $_POST['perfiles-'.$id_per];
                $per_car = $this->con->sql("SELECT * FROM perfiles_cargos WHERE id_per='".$id_per."' AND id_carg='".$id_carg."'");
                
                if($aux == 1 && $per_car['count'] == 0){
                    $this->con->sql("INSERT INTO perfiles_cargos (id_carg, id_per) VALUES ('".$id_carg."', '".$id_per."')");
                }
                if($aux == 0 && $per_car['count'] == 1){
                    $this->con->sql("DELETE FROM perfiles_cargos WHERE id_carg='".$id_carg."' AND id_per='".$id_per."'");
                }

            }
            $info['op'] = 1;
            $info['mensaje'] = "Cambios realizados con exito";
            $info['reload'] = 1;
            $info['page'] = "cargos_cia.php";

        }

        return $info;
        
    }
    
    private function asignartareascargocue(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];

        $perfiles = $this->get_perfiles_cue();
        $cargo = $this->get_cargo_cue($id);

        if(isset($cargo['id_carg'])){

            $id_carg = $cargo['id_carg'];
            for($i=0; $i<count($perfiles); $i++){

                $id_per = $perfiles[$i]['id_per'];
                $aux = $_POST['perfiles-'.$id_per];
                $per_car = $this->con->sql("SELECT * FROM perfiles_cargos WHERE id_per='".$id_per."' AND id_carg='".$id_carg."'");
                
                if($aux == 1 && $per_car['count'] == 0){
                    $this->con->sql("INSERT INTO perfiles_cargos (id_carg, id_per) VALUES ('".$id_carg."', '".$id_per."')");
                }
                if($aux == 0 && $per_car['count'] == 1){
                    $this->con->sql("DELETE FROM perfiles_cargos WHERE id_carg='".$id_carg."' AND id_per='".$id_per."'");
                }

            }
            $info['op'] = 1;
            $info['mensaje'] = "Cambios realizados con exito";
            $info['reload'] = 1;
            $info['page'] = "cargos_cue.php";

        }

        return $info;
        
    }
    
    private function asignarperfilusuariocia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];

        $perfiles = $this->get_perfiles_cia();
        $usuario = $this->get_usuario_cia($id);
        
        if(isset($usuario['id_user'])){

            $id_user = $usuario['id_user'];
            for($i=0; $i<count($perfiles); $i++){

                $id_per = $perfiles[$i]['id_per'];
                $aux = $_POST['perfiles-'.$id_per];
                $per_user = $this->con->sql("SELECT * FROM perfiles_usuarios WHERE id_per='".$id_per."' AND id_user='".$id_user."'");
                $info['db'] = $per_user;
                
                if($aux == 1 && $per_user['count'] == 0){
                    $this->con->sql("INSERT INTO perfiles_usuarios (id_user, id_per) VALUES ('".$id_user."', '".$id_per."')");
                }
                if($aux == 0 && $per_user['count'] == 1){
                    $this->con->sql("DELETE FROM perfiles_usuarios WHERE id_user='".$id_user."' AND id_per='".$id_per."'");
                }

            }
            $info['op'] = 1;
            $info['mensaje'] = "Cambios realizados con exito";
            $info['reload'] = 1;
            $info['page'] = "usuarios_cia.php";

        }else{

            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";

        }

        return $info;
        
    }
    private function asignarperfilusuariocue(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];

        $perfiles = $this->get_perfiles_cue();
        $usuario = $this->get_usuario_cue($id);
        
        if(isset($usuario['id_user'])){

            $id_user = $usuario['id_user'];
            for($i=0; $i<count($perfiles); $i++){

                $id_per = $perfiles[$i]['id_per'];
                $aux = $_POST['perfiles-'.$id_per];
                $per_user = $this->con->sql("SELECT * FROM perfiles_usuarios WHERE id_per='".$id_per."' AND id_user='".$id_user."'");

                if($aux == 1 && $per_user['count'] == 0){
                    $this->con->sql("INSERT INTO perfiles_usuarios (id_user, id_per) VALUES ('".$id_user."', '".$id_per."')");
                }
                if($aux == 0 && $per_user['count'] == 1){
                    $this->con->sql("DELETE FROM perfiles_usuarios WHERE id_user='".$id_user."' AND id_per='".$id_per."'");
                }

            }
            $info['op'] = 1;
            $info['mensaje'] = "Cambios realizados con exito";
            $info['reload'] = 1;
            $info['page'] = "usuarios_cue.php";

        }else{

            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";

        }

        return $info;
        
    }
    
    private function asignarcargousuarioscue(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id_cargo = $_POST["id_cargo"];
        $cargo = $this->con->sql("SELECT * FROM cargos WHERE id_carg='".$id_cargo."' AND id_cue='$this->id_cue' AND iscia='0'");
        if($cargo['count'] == 1){
            
            $id_ucar = $_POST["id_ucar"];
            $aux_id_ucar = $this->con->sql("SELECT * FROM usuarios_cargos t1, cargos t2 WHERE t1.id_ucar='".$id_ucar."' AND t1.id_carg=t2.id_carg AND t2.id_cue='".$this->id_cue."' AND t2.iscia='0'");
            $fecha_ini = @date("Y-m-d H:i:s", @strtotime($_POST["h_f_ini"]));
            $fecha_fin = @date("Y-m-d H:i:s", @strtotime($_POST["h_f_fin"]));
            if($id_ucar > 0 && $aux_id_ucar['count'] == 1){
                $this->con->sql("UPDATE usuarios_cargos SET fecha_ini='".$fecha_ini."', fecha_fin='".$fecha_fin."' WHERE id_ucar='".$id_ucar."'");
            }
            if($id_ucar == 0){
                $id_user = $_POST['h_id_user'];
                $this->con->sql("INSERT INTO usuarios_cargos(id_carg, id_user, fecha_creado, fecha_ini, fecha_fin) VALUES ('".$id_cargo."', '".$id_user."', now(), '".$fecha_ini."', '".$fecha_fin."')");
            }
            
            $actuales = $this->actuales($this->get_users_cargo_cue($id_cargo));
            for($i=0; $i<count($actuales); $i++){
                
                $id_uca = $actuales[$i]["id_ucar"];
                $id_user = $_POST["actual-".$id_uca];
                $f_ini = $_POST["fini-".$id_uca];
                if($id_user > 0 && $f_ini != ""){
                    $f_inia = @strtotime($f_ini);
                    $this->con->sql("UPDATE usuarios_cargos SET fecha_fin='".@date("Y-m-d H:i:s", $f_inia)."' WHERE id_ucar='".$id_uca."'");
                    $this->con->sql("INSERT INTO usuarios_cargos (id_carg, id_user, fecha_creado, fecha_ini) VALUES ('".$id_cargo."', '".$id_user."', now(), '".@date("Y-m-d H:i:s", $f_inia)."')");
                }
                
            }
            
            $info['op'] = 1;
            $info['mensaje'] = "Cambios realizados con exito";
            $info['reload'] = 1;
            $info['page'] = "cargos_usuarios_cue.php?id=".$id_cargo;
            
        }
        
        return $info;
        
    }
    private function asignarcargousuarioscia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id_cargo = $_POST["id_cargo"];
        $cargo = $this->con->sql("SELECT * FROM cargos WHERE id_carg='".$id_cargo."' AND id_cue='$this->id_cue' AND iscia='1' AND (id_cia='".$this->id_cia."' OR id_cia='0')");
        if($cargo['count'] == 1){
            
            $id_ucar = $_POST["id_ucar"];
            $aux_id_ucar = $this->con->sql("SELECT * FROM usuarios_cargos t1, cargos t2 WHERE t1.id_ucar='".$id_ucar."' AND t1.id_carg=t2.id_carg AND t2.id_cue='".$this->id_cue."' AND t2.iscia='1' AND (t2.id_cia='0' OR t2.id_cia='".$this->id_cia."')");
            $fecha_ini = @date("Y-m-d H:i:s", @strtotime($_POST["h_f_ini"]));
            $fecha_fin = @date("Y-m-d H:i:s", @strtotime($_POST["h_f_fin"]));
            if($id_ucar > 0 && $aux_id_ucar['count'] == 1){
                $this->con->sql("UPDATE usuarios_cargos SET fecha_ini='".$fecha_ini."', fecha_fin='".$fecha_fin."' WHERE id_ucar='".$id_ucar."'");
            }
            if($id_ucar == 0){
                $id_user = $_POST['h_id_user'];
                $this->con->sql("INSERT INTO usuarios_cargos(id_carg, id_user, fecha_creado, fecha_ini, fecha_fin) VALUES ('".$id_cargo."', '".$id_user."', now(), '".$fecha_ini."', '".$fecha_fin."')");
            }
            
            $actuales = $this->actuales($this->get_users_cargo_cia($id_cargo));
            for($i=0; $i<count($actuales); $i++){
                
                $id_uca = $actuales[$i]["id_ucar"];
                $id_user = $_POST["actual-".$id_uca];
                $f_ini = $_POST["fini-".$id_uca];
                if($id_user > 0 && $f_ini != ""){
                    $f_inia = @strtotime($f_ini);
                    $this->con->sql("UPDATE usuarios_cargos SET fecha_fin='".@date("Y-m-d H:i:s", $f_inia)."' WHERE id_ucar='".$id_uca."'");
                    $this->con->sql("INSERT INTO usuarios_cargos (id_carg, id_user, fecha_creado, fecha_ini) VALUES ('".$id_cargo."', '".$id_user."', now(), '".@date("Y-m-d H:i:s", $f_inia)."')");
                }
                
            }
            
            $info['op'] = 1;
            $info['mensaje'] = "Cambios realizados con exito";
            $info['reload'] = 1;
            $info['page'] = "cargos_usuarios_cia.php?id=".$id_cargo;
            
        }
        
        return $info;
        
    }
    private function asignartareascia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];
        $tareas = $this->get_tareas_cia('normal');
        $perfil = $this->get_perfil_cia($id);

        if(isset($perfil['id_per'])){

            $id_per = $perfil['id_per'];
            for($i=0; $i<count($tareas); $i++){

                $id_tar = $tareas['id_tar'];
                $aux = $_POST['tareas-'.$id_tar];
                $per_tar = $this->con->sql("SELECT * FROM perfiles_tareas WHERE id_tar='".$id_tar."' AND id_per='".$id_per."'");

                if($aux == 1 && $per_tar['count'] == 0){
                    $this->con->sql("INSERT INTO perfiles_tareas (id_tar, id_per) VALUES ('".$id_tar."', '".$id_per."')");
                }
                if($aux == 0 && $per_tar['count'] == 1){
                    $this->con->sql("DELETE FROM perfiles_tareas WHERE id_tar='".$id_tar."' AND id_per='".$id_per."'");
                }

            }
            $info['op'] = 1;
            $info['mensaje'] = "Cambios realizados con exito";
            $info['reload'] = 1;
            $info['page'] = "perfiles_cia.php";

        }else{

            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";

        }
            
        
        return $info;
        
    }
    private function asignartareascue(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $tareas = $this->get_tareas_cue('normal');
        $perfil = $this->get_perfil_cue($id);

        if(isset($perfil['id_per'])){

            $id_per = $perfil['id_per'];
            for($i=0; $i<count($tareas); $i++){

                $id_tar = $tareas[$i]['id_tar'];
                $aux = $_POST['tareas-'.$id_tar];
                $per_tar = $this->con->sql("SELECT * FROM perfiles_tareas WHERE id_tar='".$id_tar."' AND id_per='".$id_per."'");

                if($aux == 1 && $per_tar['count'] == 0){
                    $this->con->sql("INSERT INTO perfiles_tareas (id_tar, id_per) VALUES ('".$id_tar."', '".$id_per."')");
                }
                if($aux == 0 && $per_tar['count'] == 1){
                    $this->con->sql("DELETE FROM perfiles_tareas WHERE id_tar='".$id_tar."' AND id_per='".$id_per."'");
                }

            }
            $info['op'] = 1;
            $info['mensaje'] = "Cambios realizados con exito";
            $info['reload'] = 1;
            $info['page'] = "perfiles_cue.php";

        }else{

            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";

        }
            
        
        return $info;
        
    }
    
    private function crearcargoscia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $cantidad = $_POST['cantidad'];
        
        if($id == 0){
            $this->con->sql("INSERT INTO cargos (nombre, fecha_creado, cantidad, iscia, id_cia, id_cue) VALUES ('".$nombre."', now(), '".$cantidad."', '1', '".$this->id_cia."', '".$this->id_cue."')");
            $info['op'] = 1;
            $info['mensaje'] = "Cargo creado exitosamente";
        }
        if($id > 0){
            $this->con->sql("UPDATE cargos SET nombre='".$nombre."', cantidad='".$cantidad."' WHERE id_carg='".$id."' AND iscia='1' AND id_cia='".$this->id_cia."' AND id_cue='".$this->id_cue."'");
            $info['op'] = 1;
            $info['mensaje'] = "Cuerpo modificado exitosamente";
        }
        $info['reload'] = 1;
        $info['page'] = "cargos_cia.php";
        return $info;
        
    }
    private function crearcargoscue(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
            
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $iscia = $_POST['iscia'];
        $ismando = $_POST['ismando'];
        $cantidad = $_POST['cantidad'];

        if($id == 0){
            $this->con->sql("INSERT INTO cargos (nombre, fecha_creado, cantidad, ismando, iscia, id_cia, id_cue) VALUES ('".$nombre."', now(), '".$cantidad."', '".$ismando."', '".$iscia."', '0', '".$this->id_cue."')");
            $info['op'] = 1;
            $info['mensaje'] = "Cargo creado exitosamente";
        }
        if($id > 0){
            $this->con->sql("UPDATE cargos SET nombre='".$nombre."', iscia='".$iscia."', ismando='".$ismando."', cantidad='".$cantidad."' WHERE id_carg='".$id."' AND id_cia='0' AND id_cue='".$this->id_cue."'");
            $info['op'] = 1;
            $info['mensaje'] = "Cuerpo modificado exitosamente";
        }
        $info['reload'] = 1;
        $info['page'] = "cargos_cue.php";
        return $info;
        
    }
    
    public function eliminarcarrocia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $carro = $this->con->sql("SELECT * FROM carros WHERE id_car='".$id."' AND id_cue='".$this->id_cue."'");
        $id_cia = $carro['resultado'][0]['id_cia'];
        if($carro['count'] == 1){
            $info['db'] = $this->con->sql("UPDATE carros SET fecha_eliminado=now(), eliminado='1' WHERE id_car='".$id."'");
        }
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Carro ".$_POST["nombre"]." Eliminado";
        $info['reload'] = 1;
        $info['page'] = "carros_cia.php?id=".$id_cia;

        return $info;
        
    }
    
    public function eliminartipomaquina(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $this->con->sql("UPDATE tipos_de_carros SET fecha_eliminado=now(), eliminado='1' WHERE id_cue='".$this->id_cue."' AND id_tdc='".$id."'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Tipo de Carro ".$_POST["nombre"]." Eliminada";
        $info['reload'] = 1;
        $info['page'] = "tipos_de_maquina.php";

        return $info;
        
    }
    
    public function eliminarcia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $this->con->sql("UPDATE companias SET fecha_eliminado=now(), eliminado='1' WHERE id_cue='".$this->id_cue."' AND id_cia='".$id."'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Compañia ".$_POST["nombre"]." Eliminada";
        $info['reload'] = 1;
        $info['page'] = "crear_cias.php";

        return $info;
        
    }
    
    public function eliminarcargoscia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $cargos = $this->con->sql("SELECT * FROM cargos WHERE id_carg='".$id."'");
        if($this->permiso_cia($cargos)){

            $this->con->sql("UPDATE cargos SET eliminado='1', fecha_eliminado=now() WHERE id_carg='".$id."'");
            $info['tipo'] = "success";
            $info['titulo'] = "Eliminado";
            $info['texto'] = "Cargo ".$_POST["nombre"]." Eliminado";
            $info['reload'] = 1;
            $info['page'] = "cargos_cia.php";

        }else{
            $info['tipo'] = "error";
            $info['titulo'] = "Error: de Seguridad";
        }

        return $info;
        
    }
    public function eliminarusuario(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $usuarios = $this->con->sql("SELECT * FROM usuarios WHERE id_user='".$id."'");
        if($this->permiso_cia($usuarios)){

            $this->con->sql("UPDATE usuarios SET eliminado='1', fecha_eliminado=now() WHERE id_user='".$id."'");
            $info['tipo'] = "success";
            $info['titulo'] = "Eliminado";
            $info['texto'] = "Usuario ".$_POST["nombre"]." Eliminado";
            $info['reload'] = 1;
            $info['page'] = "usuarios.php";

        }else{
            
            $info['tipo'] = "error";
            $info['titulo'] = "Error: de Seguridad";
            
        }

        return $info;
        
    }
    
    public function eliminarperfilcia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $perfil = $this->get_perfil_cia($id);
        if(isset($perfil['id_per'])){
            
            $del_per = $this->con->sql("UPDATE perfiles SET eliminado='1', fecha_eliminado=now() WHERE id_per='".$id."' AND id_cia='".$this->id_cia."' AND id_cue='".$this->id_cue."'");
            $info['tipo'] = "success";
            $info['titulo'] = "Eliminado";
            $info['texto'] = "Perfil ".$_POST["nombre"]." Eliminado";
            $info['reload'] = 1;
            $info['page'] = "perfiles_cia.php";
            
        }else{
            $info['tipo'] = "error";
            $info['titulo'] = "Error: de Seguridad";
        }
        
        return $info;
        
    }
    public function eliminarperfilcue(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $perfil = $this->get_perfil_cue($id);
        if(isset($perfil['id_per'])){
            
            $del_per = $this->con->sql("UPDATE perfiles SET eliminado='1', fecha_eliminado=now() WHERE id_per='".$id."' AND id_cia='0' AND id_cue='".$this->id_cue."'");
            $info['tipo'] = "success";
            $info['titulo'] = "Eliminado";
            $info['texto'] = "Perfil ".$_POST["nombre"]." Eliminado";
            $info['reload'] = 1;
            $info['page'] = "perfiles_cue.php";
            
        }else{
            $info['tipo'] = "error";
            $info['titulo'] = "Error: de Seguridad";
        }
        
        return $info;
        
    }
    
    public function eliminargrupocia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $this->con->sql("UPDATE grupos SET fecha_eliminado=now(), eliminado='1' WHERE id_cue='".$this->id_cue."' AND id_gru='".$id."' AND id_cia='".$this->id_cia."'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Grupo ".$_POST["nombre"]." Eliminado";
        $info['reload'] = 1;
        $info['page'] = "grupos_cia.php";

        return $info;
        
    }
    
    public function eliminargrupocue(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $this->con->sql("UPDATE grupos SET fecha_eliminado=now(), eliminado='1' WHERE id_cue='".$this->id_cue."' AND id_gru='".$id."' AND id_cia='0'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Grupo ".$_POST["nombre"]." Eliminado";
        $info['reload'] = 1;
        $info['page'] = "grupos_cue.php";

        return $info;
        
    }
    
    public function eliminarclavecia(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $this->con->sql("UPDATE claves SET fecha_eliminado=now(), eliminado='1' WHERE id_cue='".$this->id_cue."' AND id_cla='".$id."' AND id_cia='".$this->id_cia."'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Clave ".$_POST["nombre"]." Eliminado";
        $info['reload'] = 1;
        $info['page'] = "tipos_de_claves_cia.php";

        return $info;
        
    }
    
    public function eliminarclavecue(){
        
        if(!$this->seguridad(1)){
            $info['op'] = 2;
            $info['mensaje'] = "No tiene los permisos para ejecutar esta Tarea";
            return $info;
        }
        
        $id = $_POST['id'];
        $this->con->sql("UPDATE claves SET fecha_eliminado=now(), eliminado='1' WHERE id_cue='".$this->id_cue."' AND id_cla='".$id."' AND id_cia='0'");
        
        $info['tipo'] = "success";
        $info['titulo'] = "Eliminado";
        $info['texto'] = "Clave ".$_POST["nombre"]." Eliminado";
        $info['reload'] = 1;
        $info['page'] = "tipos_de_claves_cue.php";

        return $info;
        
    }
    
    public function instalarcia($id){
        
    }
    public function instalarcuerpo($id){
        
        // FUNCION QUE SE EJECUTA AL CRAER EL CUERPO
        /*
        $cargos = $this->con->sql("SELECT * FROM cargos WHERE id_cue='1'");
        for($i=0; $i<$cargos['count']; $i++){
            $this->con->sql("INSERT INTO cargos (nombre, iscia, ismando, ordermando, id_cua) VALUES ('".$cargos['resultado'][$i]['nombre']."', '".$cargos['resultado'][$i]['iscia']."', '".$cargos['resultado'][$i]['ismando']."', '".$cargos['resultado'][$i]['ordermando']."', '".$id."')");
        }
        */
        
    }
    
    
}
