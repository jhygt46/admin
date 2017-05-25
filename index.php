<?php
    session_start();
    
    if(!file_exists("../config/config.php") && file_exists("install.php")){
        
        require_once("class/mysql_class.php");
        include("install.php");
        exit;
        
    }
    
    if(!isset($_SESSION['user']['info']['id_user'])){
        include("login.php");
    }else{
        include("inicio.php");
    }

?>
