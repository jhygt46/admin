<?php
    
    session_start();
    
    if($_GET["accion"] == "logout"){
        session_destroy();
        echo '<meta http-equiv="refresh" content="0; url=index.php">';
        exit;
    }
    
    if(!file_exists("../config/config.php") && file_exists("install.php")){
        
        include("install.php");
        exit;
        
    }
    if(file_exists("../config/config.php") && file_exists("install.php")){
        
        //unlink("install.php");
        
    }
    
    if(!isset($_SESSION['user']['info']['id_user'])){
        include("login.php");
    }else{
        include("inicio.php");
    }

?>
