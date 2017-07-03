<?php

class Install{
    
    public $dbconfig = true;
    public $localconfig = true;
    public $enlace = false;
    
    public function __construct(){
        
        if(file_exists("../config/config.php")){
            
            require_once "../config/config.php";
            $this->enlace = mysqli_connect($db_host[0], $db_user[0], $db_password[0]);
            if($this->enlace){
                
                $this->dbconfig = false;
                if(file_exists("conf.php")){
                    
                    require_once "conf.php";
                    if(mysqli_select_db($this->enlace, $dbname)){
                        $this->localconfig = false;
                    }
                    
                }
                
            }
            
        }
        
        if($_POST["accion"] == "crear"){
            $this->creardbconfig();
            $this->crearlocalconfig();
        }
        
    }
    public function crearlocalconfig(){
        
        if($_POST["db_name"] != ""){
            if(!mysqli_select_db($this->enlace, $_POST["db_name"])){
                if($this->creardb($_POST["db_name"])){
                    // CREAR MODULOS
                }
            }
        }else{
            echo "NO INGRESO NOMBRE DE BASE DE DATOS";
        }
        
    }
    public function creardbconfig(){
        
        if(mysqli_connect($_POST['server'], $_POST['user'], $_POST['pass'])){
        
            $peso = '$';
            $config = '<?php ';
            for($i=0; $i<=2; $i++){
                $config .= ' '.$peso.'db_host['.$i.'] = "'.$_POST['server'].'";';
                $config .= ' '.$peso.'db_user['.$i.'] = "'.$_POST['user'].'";';
                $config .= ' '.$peso.'db_password['.$i.'] = "'.$_POST['pass'].'";';
            }
            $config .= ' ?>';
            file_put_contents("../config/config.php", $config);
            
        }
        
    }
    
    public function crearinfonav(){
        
        $peso = '$';
        $nav = '<?php ';
        $nav .= ' '.$peso.'aux["ico"] = 4;';
        $nav .= ' '.$peso.'aux["categoria"] = "Productos";';
        $nav .= ' '.$peso.'aux["subcategoria"][0]["nombre"] = "Ingresar Categorias";';
        $nav .= ' '.$peso.'aux["subcategoria"][0]["link"] = "pages/crear_categoria.php";';
        $nav .= ' '.$peso.'aux["subcategoria"][1]["nombre"] = "Ingresar Productos";';
        $nav .= ' '.$peso.'aux["subcategoria"][1]["link""] = "pages/crear_productos.php";';
        $nav .= ' '.$peso.'menu[] = $aux;';
        $nav .= ' '.$peso.'aux = null;';

        $nav .= ' '.$peso.'aux["ico"] = 2;';
        $nav .= ' '.$peso.'aux["categoria"] = "Usuarios";';
        $nav .= ' '.$peso.'aux["subcategoria"][0]["nombre"] = "Ingresar Usuarios";';
        $nav .= ' '.$peso.'aux["subcategoria"][0]["link"] = "pages/crear_user.php";';
        $nav .= ' '.$peso.'menu[] = $aux;';
        $nav .= ' '.$peso.'aux = null;';
        $nav .= ' ?>';

        file_put_contents("includes/info_nav.php", $nav);
        
    }
    
    public function creardb($db_name){
        
        $create_db = "CREATE DATABASE IF NOT EXISTS ".$db_name." COLLATE utf8_spanish_ci";
        if($this->enlace->query($create_db) === TRUE){
            return true;
        }else{
            return false;
        }
        
    }
    
    public function querydb($sql){
        
        if(mysqli_query($this->enlace, $sql["sql"])){
            echo $sql["txt"]."<br/>";
        }
        
    }
    
    //$url_file = "http://www.bridgeinformation.cl/usuarios_base.tar";
    //wgets($url_file, "pages/");
        
    public function wgets($url, $dir){
        
        $name = explode("/", $url);
        $data = file_get_contents($url);
        file_put_contents($dir.end($name), $data);
        
    }
    
    
}

$i = new Install();

/*
$exec[0]['sql'] = "CREATE TABLE usuarios( id_user INT(4) NOT NULL AUTO_INCREMENT, nombre VARCHAR(255) NOT NULL, correo VARCHAR(255) NOT NULL, pass VARCHAR(32) NOT NULL, intentos SMALLINT(2) NOT NULL, fecha_creado DATETIME NOT NULL, block TINYINT(1) NOT NULL, fecha_block DATETIME NOT NULL, PRIMARY KEY ( id_user ));";
$exec[0]['txt'] = "TABLAS USUARIOS CREADA";

$exec[1]['sql'] = "INSERT INTO usuarios (nombre, correo, fecha_creado, pass, block) VALUES ('Diegomez', 'diegomez13@hotmail.com', now(), '25d55ad283aa400af464c76d713c07ad', 0)";
$exec[1]['txt'] = "USUARIO INGRESADO";

$exec[2]['sql'] = "CREATE TABLE categorias( id_cat INT(4) NOT NULL AUTO_INCREMENT, nombre VARCHAR(255) NOT NULL, parent_id INT(4) NOT NULL, orders INT(4) NOT NULL, id_page INT(4) NOT NULL, fecha_creado DATETIME NOT NULL, eliminado TINYINT(1) NOT NULL, fecha_eliminado DATETIME NOT NULL, PRIMARY KEY ( id_cat ));";
$exec[2]['txt'] = "TABLAS CATEGORIA CREADA";

$exec[3]['sql'] = "CREATE TABLE cat_pro( id_cat INT(4) NOT NULL, id_pro INT(4) NOT NULL, PRIMARY KEY ( id_cat, id_pro ));";
$exec[3]['txt'] = "TABLAS CATEGORIA-PRODUCTOS CREADA";

// QUIZA BORRAR
$exec[4]['sql'] = "CREATE TABLE configuracion( id_page INT(4) NOT NULL AUTO_INCREMENT, titulo VARCHAR(255) NOT NULL, subtitulo VARCHAR(255) NOT NULL, PRIMARY KEY ( id_page ));";
$exec[4]['txt'] = "TABLAS CONFIGURACION CREADA";

$exec[5]['sql'] = "CREATE TABLE productos( id_pro INT(4) NOT NULL AUTO_INCREMENT, nombre VARCHAR(255) NOT NULL, id_page INT(4) NOT NULL, fecha_creado DATETIME NOT NULL, eliminado TINYINT(1) NOT NULL, fecha_eliminado DATETIME NOT NULL, PRIMARY KEY ( id_pro ));";
$exec[5]['txt'] = "TABLAS PRODUCTOS CREADA";

$exec[6]['sql'] = "CREATE TABLE tareas( id_tar INT(4) NOT NULL AUTO_INCREMENT, nombre VARCHAR(255) NOT NULL, PRIMARY KEY ( id_tar ));";
$exec[6]['txt'] = "TABLAS TAREAS CREADA";

$exec[7]['sql'] = "CREATE TABLE paginas( id_page INT(4) NOT NULL AUTO_INCREMENT, url VARCHAR(255) NOT NULL, PRIMARY KEY ( id_page ));";
$exec[7]['txt'] = "TABLAS PAGINAS CREADA";

$exec[8]['sql'] = "CREATE TABLE paginas_tareas( id_page INT(4) NOT NULL, id_tar INT(4) NOT NULL, PRIMARY KEY ( id_page, id_tar ));";
$exec[8]['txt'] = "TABLAS PAGINAS-TAREAS CREADA";

$exec[9]['sql'] = "CREATE TABLE perfiles( id_per INT(4) NOT NULL AUTO_INCREMENT, nombre VARCHAR(255) NOT NULL, PRIMARY KEY ( id_per ));";
$exec[9]['txt'] = "TABLAS PAGINAS CREADA";
*/




if($_POST["accion"] == "crear"){
     
}

$meta = '<meta http-equiv="refresh" content="3">';

?>

<!DOCTYPE html>
<html>
    <head>
        <?php echo $meta; ?>
        <style>
            body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,textarea,p,blockquote,th,td,span{
                margin:0;
                padding:0;
                outline:none;
            }
            body{
                font: 62.5% Arial, Helvetica, sans-serif;
            }
            pre{
                font-size: 2em;
            }
            table{
                /*border-collapse:collapse;
                border-spacing:0;*/
                width:100%;
            }
            fieldset,img, abbr, acronym{
                border:0;
            }
            address,caption,cite,code,dfn,th,var{
                font-style:normal;
                font-weight:normal;
            }
            ol,ul,dl{
                list-style:none;
            }
            caption,th{
                text-align:left;
            }
            img{
                border:0;
            }
            h1,h2,h3,h4,h5,h6{
                font-size:1em;
                font-size:100%;
                font-weight:normal;
            }
            a{
                outline:none;
            }
            /*PROPIEDADES*******************************/
            .clearfix:after{
                visibility: hidden;
                display: block;
                font-size: 0;
                content: " ";
                clear: both;
                height: 0;
            }
            .clearfix{
                display: inline-block;
            }
            /*\*/* html .clearfix {
                height: 1%;
            }
            .clearfix {
                display: block;
            }/**/
            .margen_bloque{
                margin-right:10px;
            }
            .flotar_izq{
                float:left;
                display:inline;
            }
            .flotar_der{
                float:right;
                display:inline;
            }
            .form_cont{
                display: block;
                width: 900px;
                margin: 10px auto;
            }
            .form_cont ul{
                list-style:none;
            }
            .form_cont h1{
                display: block;
                padding: 10px 5px;
                font-size: 18px;
                background: #aaa;
                margin: 0px;
            }
            .form_cont .server{
                width: 900px;
                margin-bottom: 20px;
                background: #ccc;
            }
            .form_cont .server li{
                width: 280px;
                float: left;
                padding: 10px;
            }
            .form_cont .server li span{
                display: block;
                font-size: 18px;
            }
            .form_cont .server li input{
                display: block;
                width: 100%;
                height: 25px;
            }
            .form_cont .modulos{
                width: 900px;
                margin-bottom: 20px;
                background: #ccc;
            }
            .form_cont .modulos li{
                width: 205px;
                float: left;
                padding: 10px;
            }
            .form_cont .modulos li .op{
                
            }
            .form_cont .modulos li .op div:nth-child(1){
                width: 15px;
                float: left;
            }
            .form_cont .modulos li .op div:nth-child(1) input{
                width: 15px;
                height: 15px;
            }
            .form_cont .modulos li .op div:nth-child(2){
                width: 180px;
                float: left;
                font-size: 13px;
                margin-left: 10px;
            }
            .form_cont .sub{
                display: block;
                text-align: center;
            }
            .form_cont .sub input{
                width: 150px;
                padding: 10px;
                font-size: 16px;
            }
        </style>
    </head>
    <body>
        <form action="" method="POST">
            <input type="hidden" name="accion" value="crear">
            <div class="form_cont">
                <?php if($i->dbconfig){ ?>
                <h1>Base de Datos</h1>
                <ul class="server clearfix">
                    <li><span>Server:</span><input type="text" name="server" value="localhost" /></li>
                    <li><span>Usuario:</span><input type="text" name="user" value="root" /></li>
                    <li><span>Password:</span><input type="text" name="pass" /></li>
                </ul>
                <?php } ?>
                <?php if($i->localconfig){ ?>
                <h1>Informacion</h1>
                <ul class="server clearfix">
                    <li><span>Nombre BD:</span><input type="text" name="db_name" placeholder="admin" /></li>
                    <li><span>Titulo:</span><input type="text" name="titulo" placeholder="Nombre de Fantasia" /></li>
                    <li></li>
                </ul>
                <?php } ?>
                <h1>Modulos</h1>
                <ul class="modulos clearfix">
                    <li class="clearfix">
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo1" /></div>
                            <div>Usuarios Simple</div>
                        </div>
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo2" /></div>
                            <div>Usuarios Permisos Tareas</div>
                        </div>
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo3" /></div>
                            <div>Modulo3</div>
                        </div>
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo4" /></div>
                            <div>Modulo4</div>
                        </div>
                    </li>
                    <li class="clearfix">
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo5" /></div>
                            <div>Modulo1</div>
                        </div>
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo6" /></div>
                            <div>Modulo2</div>
                        </div>
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo7" /></div>
                            <div>Modulo3</div>
                        </div>
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo8" /></div>
                            <div>Modulo4</div>
                        </div>
                    </li>
                    <li class="clearfix">
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo9" /></div>
                            <div>Modulo1</div>
                        </div>
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo10" /></div>
                            <div>Modulo2</div>
                        </div>
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo11" /></div>
                            <div>Modulo3</div>
                        </div>
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo12" /></div>
                            <div>Modulo4</div>
                        </div>
                    </li>
                    <li class="clearfix">
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo13" /></div>
                            <div>Modulo1</div>
                        </div>
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo14" /></div>
                            <div>Modulo2</div>
                        </div>
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo15" /></div>
                            <div>Modulo3</div>
                        </div>
                        <div class="op clearfix">
                            <div><input type="checkbox" name="modulo16" /></div>
                            <div>Modulo4</div>
                        </div>
                    </li>
                </ul>
                <div class="sub"><input type="submit" value="Submit"></div>
            </div>
        </form>
        
    </body>
</html>