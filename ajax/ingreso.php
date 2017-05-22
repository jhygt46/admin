<?php
session_start();

header('Content-type: text/json');
header('Content-type: application/json');

if($_SERVER['HTTP_HOST'] == "localhost"){
    $path = $_SERVER['DOCUMENT_ROOT']."/admin/class";
}else{
    $path = $_SERVER['DOCUMENT_ROOT']."admin/class";
}

//require_once($path+"/mysql_class.php");
require_once($path+"/ingreso_class.php");
$ingreso = new Ingreso();
$info = $ingreso->ingresar_user();
echo json_encode($info);

?>