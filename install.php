<?php
if(file_exists("../config/config.php")){
    exit;
}
if($_POST["accion"] == "crear"){
    
    $peso = '$';
    
    // CONFIG
    $config = '<?php ';
    for($i=0; $i<=2; $i++){
        $config .= ' '.$peso.'db_host['.$i.'] = "'.$_POST['server'].'";';
        $config .= ' '.$peso.'db_user['.$i.'] = "'.$_POST['user'].'";';
        $config .= ' '.$peso.'db_database['.$i.'] = "admin";';
        $config .= ' '.$peso.'db_password['.$i.'] = "'.$_POST['pass'].'";';
    }
    $config .= ' ?>';
    file_put_contents("../config/config.php", $config);
    // CONFIG
    
    // NAV
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
    // NAV
    
    $db_name = "admin";
    $enlace = mysql_connect($_POST['server'], $_POST['user'], $_POST['pass']);
    $sql = 'CREATE DATABASE IF NOT EXISTS '.$db_name.' COLLATE utf8_spanish_ci';
    
    $exec[0]['sql'] = "CREATE TABLE usuarios( id_user INT(4) NOT NULL AUTO_INCREMENT, nombre VARCHAR(255) NOT NULL, correo VARCHAR(255) NOT NULL, pass VARCHAR(32) NOT NULL, intentos SMALLINT(2) NOT NULL, fecha_creado DATETIME NOT NULL, block TINYINT(1) NOT NULL, fecha_block DATETIME NOT NULL, PRIMARY KEY ( id_user )); ";
    $exec[0]['txt'] = "TABLAS USUARIOS CREADA";
    
    $exec[1]['sql'] = "INSERT INTO usuarios (nombre, correo, fecha_creado, pass, block) VALUES ('Diegomez', 'diegomez13@hotmail.com', now(), '25d55ad283aa400af464c76d713c07ad', 0)";
    $exec[1]['txt'] = "USUARIO INGRESADO";
    
    if (mysql_query($sql, $enlace)){
        echo "BASE DE DATOS CREADA: <br>";
        mysql_select_db($db_name, $enlace);
        for($i=0; $i<count($exec); $i++){
            if(!mysql_query($exec[$i]['sql'])){
                echo "Error al ejecutar (". $exec[$i]['sql'] . ") -> mysql_error: " .mysql_error();
            }else{
                echo $exec[$i]['txt']."<br>";
            }
        }
    } else {
        echo "Error: " . mysql_error() . "<br>";
    }
    
    //$url_file = "http://www.bridgeinformation.cl/usuarios_base.tar";
    //wgets($url_file, "pages/");
        
    $meta = '<meta http-equiv="refresh" content="3">';
    
    function wgets($url, $dir){
        $name = explode("/", $url);
        $data = file_get_contents($url);
        file_put_contents($dir.end($name), $data);
    }
     
}
    
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
            .form_cont .modulos li div:nth-child(0){
                width: 25px;
                float: left;
            }
            .form_cont .modulos li div:nth-child(1){
                width: 180px;
                float: left;
            }
        </style>
    </head>
    <body>
        <form action="" method="POST">
        <input type="hidden" name="accion" value="crear">
        <div class="form_cont">
            <h1>Base de Datos</h1>
            <ul class="server clearfix">
                <li><span>Server:</span><input type="text" name="server" value="localhost" /></li>
                <li><span>Usuario:</span><input type="text" name="user" value="root" /></li>
                <li><span>Password:</span><input type="text" name="pass" /></li>
            </ul>
            <h1>Informacion</h1>
            <ul class="server clearfix">
                <li><span>Titulo:</span><input type="text" name="titulo" placeholder="Nombre de Fantasia" /></li>
                <li><span>Subtitulo:</span><input type="text" name="subtitulo" placeholder="Software de Gestion" /></li>
                <li></li>
            </ul>
            <h1>Modulos</h1>
            <ul class="modulos clearfix">
                <li class="clearfix">
                    <div class="op clearfix">
                        <div><input type="checkbox" name="modulo1" /></div>
                        <div>Modulo1</div>
                    </div>
                    <div class="op clearfix">
                        <div><input type="checkbox" name="modulo2" /></div>
                        <div>Modulo2</div>
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
                    <div>E</div>
                    <div>F</div>
                    <div>G</div>
                    <div>H</div>
                </li>
                <li class="clearfix">
                    <div>I</div>
                    <div>J</div>
                    <div>K</div>
                    <div>L</div>
                </li>
                <li class="clearfix">
                    <div>M</div>
                    <div>N</div>
                    <div>O</div>
                    <div>P</div>
                </li>
            </ul>
        </div>
        </form>
        
        
        <?php exit; if($_POST["accion"] != "crear"){ ?>
        
            <div class="modulo">
                <h1>Base de datos</h1>
                <label>Servidor</label>
                <input type="text" name="server" value="localhost">
                <label>Usuario</label>
                <input type="text" name="user" value="root">
                <label>Password</label>
                <input type="password" name="pass" value="12345678">
            </div> 
            <div class="modulo">
                <h1>Pagina</h1>
                <label>Titulo</label>
                <input type="text" name="titulo">
                <label>Site Map</label>
                <input type="text" name="site_map">
                <label>Background</label>
                <input type="text" name="background">
            </div>
            <div class="modulo">
                <h1>MODULOS</h1>
                <label>Usuarios</label>
                <input type="checkbox" name="mod_usuarios" value="1">
                <label>Productos</label>
                <input type="checkbox" name="mod_productos" value="1">
            </div>
            <input type="submit" value="Submit">
        </form>
        <?php } ?>
    </body>
</html>