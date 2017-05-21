<?php
session_start();

require_once 'mysql_class.php';

class Core{
    
    public $con = null;

    public function __construct(){
        
        $this->id_cia = $this->getciaid();
        $this->id_cue = $this->getcueid();
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
    public function permiso_cia($result){
        
        if($result['count'] == 1 && $this->id_cia == $result['resultado'][0]['id_cia'] && $this->id_cue == $result['resultado'][0]['id_cue'] && $id_cia > 0){
            return true;
        }
        return false;
        
    }
    public function getuserid(){
        return $_SESSION['user']['info']['id_user'];
    }
    public function getciaid(){
        return $_SESSION['user']['info']['id_cia'];
    }
    public function getcueid(){
        return $_SESSION['user']['info']['id_cue'];
    }
    
    // CUERPO //
    public function get_cuerpos(){
        $cuerpos = $this->con->sql("SELECT * FROM cuerpos");
        return $cuerpos['resultado'];
    }
    public function get_cuerpo($id){
        $cuerpo = $this->con->sql("SELECT * FROM cuerpos WHERE id_cue='".$id."'");
        return $cuerpo['resultado'][0];
    }
    public function get_cuerpo_complete($id){
        $cuerpo = $this->con->sql("SELECT * FROM cuerpos WHERE id_cue='".$id."'");
        $gtareas = $this->con->sql("SELECT * FROM tarea_grupo_cuerpo WHERE id_cue='".$id."'");
        $aux['cuerpo'] = $cuerpo['resultado'][0];
        $aux['gtareas'] = $gtareas['resultado'];
        return $aux;
    }
    
    // COMPAÑIAS //
    
    public function get_cias(){
        $cuerpos = $this->con->sql("SELECT * FROM companias WHERE id_cue='".$this->id_cia."' AND eliminado='0' ORDER BY orden");
        return $cuerpos['resultado'];
    }
    public function get_cia($id){
        $cuerpos = $this->con->sql("SELECT * FROM companias WHERE id_cia='".$id."' AND id_cue='".$this->id_cia."'");
        return $cuerpos['resultado'][0];
    }
    
    // PERFIL //
    public function get_perfiles_cia(){
        
        $perfiles = $this->con->sql("SELECT * FROM perfiles WHERE id_cia='".$this->id_cia."' AND id_cue='".$this->id_cue."' AND eliminado='0'");
        return $perfiles['resultado'];
        
    }
    public function get_perfil_cia($id){

        $perfiles = $this->con->sql("SELECT * FROM perfiles WHERE id_per='".$id."' AND id_cia='".$this->id_cia."' AND id_cue='".$this->id_cue."' AND eliminado='0'");
        return $perfiles['resultado'][0];
        
    }
    public function get_perfiles_cue(){
        
        $perfiles = $this->con->sql("SELECT * FROM perfiles WHERE id_cia='0' AND id_cue='".$this->id_cue."' AND eliminado='0'");
        return $perfiles['resultado'];
        
    }
    public function get_perfil_cue($id){
        
        $perfiles = $this->con->sql("SELECT * FROM perfiles WHERE id_per='".$id."' AND id_cue='".$this->id_cue."' AND id_cia='0' AND eliminado='0'");
        return $perfiles['resultado'][0];
        
    }
    public function get_perfiles_cargo_cia($id){
        
        $perfiles = $this->con->sql("SELECT * FROM perfiles p, perfiles_cargos pc WHERE pc.id_carg='".$id."' AND pc.id_per=p.id_per AND p.id_cia='".$this->id_cia."' AND p.id_cue='".$this->id_cue."'");
        return $perfiles['resultado'];
        
    }
    public function get_perfiles_cargo_cue($id){
        
        $perfiles = $this->con->sql("SELECT * FROM perfiles p, perfiles_cargos pc WHERE pc.id_carg='".$id."' AND pc.id_per=p.id_per AND p.id_cia='0' AND p.id_cue='".$this->id_cue."'");
        return $perfiles['resultado'];
        
    }
    public function get_perfiles_user($id){
        
        $perfiles = $this->con->sql("SELECT * FROM perfiles p, perfiles_usuarios pu WHERE pu.id_user='".$id."' AND pu.id_per=p.id_per");
        return $perfiles['resultado'];
        
    }
    
    // GET USUARIOS //
    public function get_usuarios_cia(){
        
        $usuarios = $this->con->sql("SELECT * FROM usuarios WHERE id_cia='".$this->id_cia."' AND id_cue='".$this->id_cue."' AND eliminado='0'");
        return $usuarios['resultado'];
        
    }
    public function get_usuarios_cue(){
        
        $usuarios = $this->con->sql("SELECT * FROM usuarios WHERE id_cue='".$this->id_cue."' AND eliminado='0'");
        return $usuarios['resultado'];
        
    }
    public function get_usuario_cia($id){

        $usuarios = $this->con->sql("SELECT * FROM usuarios WHERE id_user='".$id."' AND id_cia='".$this->id_cia."' AND id_cue='".$this->id_cia."'");
        return $usuarios['resultado'][0];
        
    }
    public function get_usuario_cue($id){

        $usuarios = $this->con->sql("SELECT * FROM usuarios WHERE id_user='".$id."' AND id_cue='".$this->id_cia."'");
        return $usuarios['resultado'][0];
        
    }
    
    // GET BLOGS //
    public function get_blog_data(){
        
        $blogs = $this->con->sql("SELECT * FROM blog WHERE iscia='1' AND id_cue='".$this->id_cue."' AND (id_cia='".$this->id_cia."' OR id_cia='0')");
        return $blogs['resultado'];
        
    }
    
    // GET CARGOS //
    public function get_cargo_cia($id){
        
        $cuerpo = $this->con->sql("SELECT * FROM cargos WHERE id_carg='".$id."' AND iscia='1' AND id_cue='".$this->id_cue."' AND (id_cia='".$this->id_cia."' OR id_cia='0')");
        return $cuerpo['resultado'][0];
        
    }
    public function get_cargo_cue($id){
        
        $cuerpo = $this->con->sql("SELECT * FROM cargos WHERE id_carg='".$id."' AND id_cia='0' AND iscia='0' AND id_cue='".$this->id_cue."'");
        return $cuerpo['resultado'][0];
        
    }
    public function get_claves_cue(){
        
        $claves = $this->con->sql("SELECT * FROM claves WHERE id_cia='0' AND id_cue='".$this->id_cue."' AND eliminado='0'");
        return $claves['resultado'];
        
    }
    public function get_claves_cia(){
        
        $claves = $this->con->sql("SELECT * FROM claves WHERE id_cue='".$this->id_cue."' AND (id_cia='".$this->id_cia."' || id_cia='0') AND iscia='1' AND eliminado='0'");
        return $claves['resultado'];
        
    }
    public function get_clave_cue($id){
        
        $claves = $this->con->sql("SELECT * FROM claves WHERE id_cla='".$id."' AND id_cia='0' AND id_cue='".$this->id_cue."'");
        $aux['clave'] = $claves['resultado'][0];
        
        if($aux['clave']['todos'] == 0){
            $grupos = $this->con->sql("SELECT * FROM clave_grupos WHERE id_cla='".$aux['clave']['id_cla']."'");
            if($grupos['count'] > 0){
                $aux['grupos'] = $grupos['resultado'];
            }
        }
        
        $tdcs = $this->con->sql("SELECT * FROM claves_tipo WHERE id_cla='".$aux['clave']['id_cla']."'");
        if($tdcs['count'] > 0){
            $aux['tdcs'] = $tdcs['resultado'];
        }
        
        return $aux;
        
    }
    public function get_actos(){
        
        $actos_sel = $this->con->sql("SELECT t1.id_act, t2.nombre, t2.clave, t1.direccion, t1.lat, t1.lng, t1.comuna, t1.fecha_creado, t1.code FROM actos t1, claves t2 WHERE t1.id_cue='".$this->id_cue."' AND t1.id_clave=t2.id_cla");
        
        
        for($i=0; $i<$actos_sel['count']; $i++){
            
            $actos[$i]['info']['id'] = $actos_sel['resultado'][$i]['id_act'];
            $actos[$i]['info']['nombre'] = $actos_sel['resultado'][$i]['nombre'];
            $actos[$i]['info']['clave'] = $actos_sel['resultado'][$i]['clave'];
            $actos[$i]['info']['direccion'] = $actos_sel['resultado'][$i]['direccion'];
            $actos[$i]['info']['lat'] = $actos_sel['resultado'][$i]['lat'];
            $actos[$i]['info']['lng'] = $actos_sel['resultado'][$i]['lng'];
            $actos[$i]['info']['comuna'] = $actos_sel['resultado'][$i]['comuna'];
            $actos[$i]['info']['hora'] = $actos_sel['resultado'][$i]['fecha_creado'];
            $actos[$i]['info']['code'] = $actos_sel['resultado'][$i]['code'];

            $images = $this->con->sql("SELECT nombre FROM actos_imagenes WHERE id_act='".$actos[0]['info']['id']."'");
            for($j=0; $j<$images['count']; $j++){
                $actos[$i]['fotos'][] = $images['resultado'][$j]['nombre'];
            }

            $chats = $this->con->sql("SELECT id_user, texto FROM actos_chat WHERE id_act='".$actos[0]['info']['id']."'");
            $actos[$i]['chat'] = $chats['resultado'];
            
            
        
        }
        
        
        return $actos;
        
    }
    public function get_carros_acto($id){
        
        $acto = $this->con->sql("SELECT * FROM actos WHERE id_act='".$id."'");
        $act = $acto['resultado'][0];
        
        $lat = $act['lat'];
        $lng = $act['lng'];
        
        $carros = $this->con->sql("SELECT * FROM carros WHERE lat='".$lat."' AND lng='".$lng."'");
        return $carros['resultado'];
        
    }
    public function get_clave_cia($id){
        
        $claves = $this->con->sql("SELECT * FROM claves WHERE id_cla='".$id."' AND id_cia='".$this->id_cue."' AND id_cue='".$this->id_cue."'");
        $aux['clave'] = $claves['resultado'][0];
        
        if($aux['clave']['todos'] == 0){
            $grupos = $this->con->sql("SELECT * FROM clave_grupos WHERE id_cla='".$aux['clave']['id_cla']."'");
            if($grupos['count'] > 0){
                $aux['grupos'] = $grupos['resultado'];
            }
        }
        
        $carros = $this->con->sql("SELECT * FROM claves_carros WHERE id_cla='".$aux['clave']['id_cla']."'");
        if($carros['count'] > 0){
            $aux['carros'] = $carros['resultado'];
        }
        
        return $aux;
        
    }
    public function get_grupos_cue(){
        
        $grupos = $this->con->sql("SELECT * FROM grupos WHERE id_cue='".$this->id_cue."' AND id_cia='0' AND eliminado='0'");
        return $grupos['resultado'];
        
    }
    public function get_grupos_cia(){
        
        $grupos = $this->con->sql("SELECT * FROM grupos WHERE id_cue='".$this->id_cue."' AND id_cia='".$this->id_cia."' AND eliminado='0'");
        return $grupos['resultado'];
        
    }
    public function get_grupo_cue($id){
        
        $grupos = $this->con->sql("SELECT * FROM grupos WHERE id_gru='".$id."' AND id_cue='".$this->id_cue."' AND id_cia='0'");
        $aux['gru'] = $grupos['resultado'][0];
        if($grupos['count'] == 1){
            $cargos = $this->con->sql("SELECT id_carg FROM grupos_cargos WHERE id_gru='".$id."'");
            $aux['carg'] = $cargos['resultado'];
        }
        return $aux;
        
    }
    public function get_grupo_cia($id){
        
        $grupos = $this->con->sql("SELECT * FROM grupos WHERE id_gru='".$id."' AND id_cue='".$this->id_cue."' AND id_cia='".$this->id_cia."'");
        $aux['gru'] = $grupos['resultado'][0];
        if($grupos['count'] == 1){
            $cargos = $this->con->sql("SELECT id_carg FROM grupos_cargos WHERE id_gru='".$id."'");
            $aux['carg'] = $cargos['resultado'];
        }
        return $aux;
        
    }
    
    public function get_users_cargo_cue($id){
        // IMPORTANTE REVISAR QUERY
        $users = $this->con->sql("SELECT t2.fecha_creado, t2.id_ucar, t3.id_user, t3.nombre, t2.fecha_ini, t2.fecha_fin FROM cargos t1, usuarios_cargos t2, usuarios t3 WHERE t1.id_carg='".$id."' AND t1.id_carg=t2.id_carg AND t2.id_user=t3.id_user AND t3.id_cue='".$this->id_cue."' AND t1.id_cue='".$this->id_cue."' AND t1.iscia='0' ORDER BY t2.fecha_ini DESC");
        return $users['resultado'];
        
    }
    public function get_users_cargo_cia($id){
        // IMPORTANTE REVISAR QUERY
        $users = $this->con->sql("SELECT * FROM cargos t1, usuarios_cargos t2, usuarios t3 WHERE t1.id_carg='".$id."' AND t1.id_carg=t2.id_carg AND t2.id_user=t3.id_user");
        return $users['resultado'];
        
    }
    public function get_user_cargo_cue($id){
        
        $users = $this->con->sql("SELECT * FROM usuarios_cargos WHERE id_ucar='".$id."' AND fecha_fin!='0000-00-00 00:00:00'");
        return $users['resultado'][0];
        
    }
    public function get_cargos_cia(){
        
        $cuerpos = $this->con->sql("SELECT * FROM cargos WHERE id_cue='".$this->id_cue."' AND iscia='1' AND (id_cia='".$this->id_cia."' || id_cia='0') ORDER BY iscia");
        return $cuerpos['resultado'];
        
    }
    public function get_cargos_cue(){
        
        $cargos = $this->con->sql("SELECT * FROM cargos WHERE id_cue='".$this->id_cue."' AND id_cia='0'");
        return $cargos['resultado'];
        
    }
    
    // GET TAREAS //
    public function get_tareas_cia($type){
        $tareas = $this->con->sql("SELECT * FROM tareas t1, tarea_grupo_cuerpo t2 WHERE t2.id_cue='".$this->id_cue."' AND t2.id_gtar=t1.id_gtar AND t1.iscia='1' ORDER BY grupoorder");
        return ($type == "order") ? $this->order_group($tareas, 'id_tar') : $tareas['resultado'];
    }
    public function get_tareas_cue($type){
        $tareas = $this->con->sql("SELECT * FROM tareas t1, tarea_grupo_cuerpo t2 WHERE t2.id_cue='".$this->id_cue."' AND t2.id_gtar=t1.id_gtar AND t1.iscia='0' ORDER BY grupoorder");
        return ($type == "order") ? $this->order_group($tareas, 'id_tar') : $tareas['resultado'];
    }
    public function tareas_perfil_cia($id_per){
        $tareas = $this->con->sql("SELECT * FROM tareas t, perfiles_tareas pt WHERE pt.id_per='".$id_per."' AND pt.id_tar=t.id_tar");
        return $tareas['resultado'];
    }
    public function get_grupos_tareas(){
        $tareas = $this->con->sql("SELECT * FROM tareas_grupos");
        return $tareas['resultado'];
    }
    
    // CARROS //
    public function get_carros_cia($id){
        $carros = $this->con->sql("SELECT * FROM carros WHERE id_cia='".$id."' AND id_cue='".$this->id_cue."' AND eliminado='0'");
        return $carros['resultado'];
    }
    public function get_carros_mi_cia(){
        $carros = $this->con->sql("SELECT * FROM carros WHERE id_cia='".$this->id_cia."' AND id_cue='".$this->id_cue."' AND eliminado='0'");
        return $carros['resultado'];
    }
    public function get_carro_cia($id_cia, $id){
        $carros = $this->con->sql("SELECT * FROM carros WHERE id_car='".$id."' AND id_cia='".$id_cia."' AND id_cue='".$this->id_cue."' AND eliminado='0'");
        return $carros['resultado'][0];
    }
    public function get_tipos_maquinas(){
        $carros = $this->con->sql("SELECT * FROM tipos_de_carros WHERE id_cue='".$this->id_cue."' AND eliminado='0'");
        return $carros['resultado'];
    }
    public function get_tipos_carro($id){
        $carros = $this->con->sql("SELECT * FROM carros_tipo t1, tipos_de_carros t2 WHERE t1.id_car='".$id."' AND t1.id_tdc=t2.id_tdc AND t2.id_cue='".$this->id_cue."' AND t2.eliminado='0'");
        return $carros['resultado'];
    }
    public function get_tipo_maquina($id){
        $carros = $this->con->sql("SELECT * FROM tipos_de_carros WHERE id_tdc='".$id."' AND id_cue='".$this->id_cue."' AND eliminado='0'");
        return $carros['resultado'][0];
    }
    
    // CONFIGURACION //
    public function get_config_cue(){
        
        $aux = $this->con->sql("SELECT * FROM cuerpos WHERE id_cue='".$this->id_cue."'");
        return $aux['resultado'][0];
        
    }
    public function get_config_cia(){
        
        $aux = $this->con->sql("SELECT * FROM companias WHERE id_cia='".$this->id_cia."'");
        return $aux['resultado'][0];
        
    }
    
    
    // PERMISOS //
    public function permisos_cargos($id_carg){
        
        $aux = Array();
        $permisos_car = $this->con->sql("SELECT t4.id_tar FROM perfiles_cargos t1, perfiles t2, perfiles_tareas t3, tareas t4 WHERE t1.id_carg='".$id_carg."' AND t1.id_per=t2.id_per AND t2.id_per=t3.id_per AND t3.id_tar=t4.id_tar");
        for($i=0; $i<$permisos_car['count']; $i++){
            $aux[] = $permisos_car['resultado'][$i]['id_tar'];
        }
        return $aux;
        
    }
    public function permisos_ususarios($id_user){
        
        $aux = Array();
        $permisos_per = $this->con->sql("SELECT t4.id_tar FROM perfiles_usuarios t1, perfiles t2, perfiles_tareas t3, tareas t4 WHERE t1.id_user='".$id_user."' AND t1.id_per=t2.id_per AND t2.id_per=t3.id_per AND t3.id_tar=t4.id_tar");
        for($i=0; $i<$permisos_per['count']; $i++){
            $aux[] = $permisos_per['resultado'][$i]['id_tar'];
        }
        return $aux;
        
    }
    
    // ORDER //
    public function order_group($result, $id){
        
        for($i=0; $i<$result['count']; $i++){
            
            $aux_ini = $result['resultado'][$i];
            $aux[$aux_ini['grupoorder']]['grupo'] = $aux_ini['grupo'];
            $aux2[$id] = $aux_ini[$id];
            $aux2['nombre'] = $aux_ini['nombre'];
            $aux[$aux_ini['grupoorder']]['res'][] = $aux2;
        }
        return $aux;
        
    }
    
    public function actuales($list_user_cargo){
        
        $now = @time();
        for($i=0; $i<count($list_user_cargo); $i++){
            $f_ini = @strtotime($list_user_cargo[$i]['fecha_ini']);
            $f_fin = @strtotime($list_user_cargo[$i]['fecha_fin']);
            if($f_fin == "" || $f_fin > $now){
                if($f_ini < $now){
                    if($f_fin == ""){
                        $act['f_fin'] = "Actualidad";
                    }else{
                        $act['f_fin'] = $list_user_cargo[$i]['fecha_fin'];
                    }
                    $act['id_ucar'] = $list_user_cargo[$i]['id_ucar'];
                    $act['id_user'] = $list_user_cargo[$i]['id_user'];
                    $act['nombre'] = $list_user_cargo[$i]['nombre'];
                    $act['f_ini'] = $list_user_cargo[$i]['fecha_ini'];
                    $actual[] = $act;
                }
            }
        }
        return $actual;
        
    }
}