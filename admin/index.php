<?php
    session_start();
    
    echo "<pre>";
    print_r($_SERVER);
    echo "</pre>";
    
    
    if(!isset($_SESSION['user']['info']['id_user'])){
        include("login.php");
    }else{
        include("inicio.php");
    }

?>
