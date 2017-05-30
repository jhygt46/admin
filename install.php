<?php
if(file_exists("../config/config.php")){
    exit;
}
if($_POST["accion"] == "crear"){
    
    $peso = '$';
    $data = '<?php '.$peso.'titulo_bk="'.$_POST['titulo'].'";';
    for($i=0; $i<=2; $i++){
        $data .= ' '.$peso.'db_host['.$i.'] = "'.$_POST['server'].'";';
        $data .= ' '.$peso.'db_user['.$i.'] = "'.$_POST['user'].'";';
        $data .= ' '.$peso.'db_database['.$i.'] = "inicio";';
        $data .= ' '.$peso.'db_password['.$i.'] = "'.$_POST['pass'].'";';
    }
    $data .= ' ?>';
    file_put_contents("../config/config.php", $data);
    
    $db_name = "admin";
    $enlace = mysql_connect($_POST['server'], $_POST['user'], $_POST['pass']);
    $sql = 'CREATE DATABASE IF NOT EXISTS '.$db_name.' COLLATE utf8_spanish_ci';
    
    $exec[0]['sql'] = "CREATE TABLE usuarios( id_user INT(4) NOT NULL AUTO_INCREMENT, nombre VARCHAR(255) NOT NULL, correo VARCHAR(255) NOT NULL, pass VARCHAR(32) NOT NULL, intentos SMALLINT(2) NOT NULL, fecha_creado DATETIME NOT NULL, block TINYINT(1) NOT NULL, fecha_block DATETIME NOT NULL, PRIMARY KEY ( id_user )); ";
    $exec[0]['txt'] = "TABLAS USUARIOS CREADA";
    $exec[1]['sql'] = "INSERT INTO usuarios (nombre, correo, fecha_creado, pass, block) VALUES ('Diegomez', 'diegomez13@hotmail.com', now(), '25d55ad283aa400af464c76d713c07ad', 0)";
    $exec[1]['txt'] = "USUARIO INGRESADO";
    
    if (mysql_query($sql, $enlace)) {
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
            .form{
                display: block;
                width: 150px;
                margin: 0 auto;
            }
            .form h1{
                display: block;
                padding: 5px;
                font-size: 14px;
                background: #ccc;
                margin: 0px;
            }
            .form .modulo{
                display: block;
                background: #ddd;
                padding: 10px 10px;
            }
            .form .modulo label{
                padding: 5px 0;
                display: block;
            }
            .form .modulo input[type=text], input[type=password]{
                display: block;
                width: 100%;
            }
            .form .modulo input[type=checkbox]{
                display: block;
            }
            .form input[type=submit]{
                width: 150px;
                padding: 10px;
                text-align: center;
                margin-top: 5px;
            }
        </style>
    </head>
    <body>
        
        <form action="" method="POST" class="form">
            <input type="hidden" name="accion" value="crear">
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
    </body>
</html>