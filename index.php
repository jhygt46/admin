<?php

    session_start();
    
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
    
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
