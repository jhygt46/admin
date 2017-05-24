<?php

if(file_exists("../config/config.php")){
    exit;
}

if($_POST["accion"] == "crear"){

    $peso = "$";
    $data = "<?php";
    for($i=0; $i<=2; $i++){
        $data .= " ".$peso."db_host[".$i."] = '".$_POST["server"]."'; ".$peso."db_user[".$i."] = '".$_POST["user"]."'; ".$peso."db_database[".$i."] = 'inicio'; ".$peso."db_password[".$i."] = '".$_POST["pass"]."';";
    }
    $data .= " ?>";
    file_put_contents("../config/config.php", $data);
    
    // CONFIGURAR BASE DE DATOS
    require_once("class/mysql_class.php");
    $con = new Conexion();
    $usuarios = "CREATE TABLE IF NOT EXISTS `usuarios` ( `id_user` int(4) NOT NULL, `nombre` varchar(255) COLLATE utf8_spanish2_ci NOT NULL, `correo` varchar(100) COLLATE utf8_spanish2_ci NOT NULL, `pass` varchar(32) COLLATE utf8_spanish2_ci NOT NULL, `intentos` smallint(2) NOT NULL, `fecha_creado` datetime NOT NULL, `block` tinyint(1) NOT NULL, `fecha_block` datetime NOT NULL ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;";
    $con->sql($usuarios);
    $con->sql("INSERT INTO usuarios (nombre, correo, fecha_creado, pass) VALUES ('Diego Gomez', 'diegomez13@hotmail.com', now(), '25d55ad283aa400af464c76d713c07ad')");
    
}
    
?>



<!DOCTYPE html>
<html>
    <head>
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