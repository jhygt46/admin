<?php
    session_start();
    
    if($_SERVER['HTTP_HOST'] == "localhost"){
        $path = "";
        echo "LOCAL";
    }else{
        $path = $_SERVER['DOCUMENT_ROOT'];
    }
    
    
    echo "<pre>";
    print_r($_SERVER);
    echo "</pre>";
    
    
    if(!isset($_SESSION['user']['info']['id_user'])){
        include("login.php");
    }else{
        include("inicio.php");
    }

?>
