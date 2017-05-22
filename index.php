<?php
    session_start();
    
    if($_SERVER['HTTP_HOST'] == "localhost"){
        $path = $_SERVER['DOCUMENT_ROOT']."/admin/class";
    }else{
        $path = $_SERVER['DOCUMENT_ROOT']."admin/class";
    }
        
    if(!isset($_SESSION['user']['info']['id_user'])){
        include("login.php");
    }else{
        include("inicio.php");
    }

?>
