<?php
    session_start();
    
    if(!file_exists("../config.php") && file_exists("install.php")){
        include("install.php");
        exit;   
    }
    
    if(!isset($_SESSION['user']['info']['id_user'])){
        include("login.php");
    }else{
        include("inicio.php");
    }

?>
