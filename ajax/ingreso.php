<?php
session_start();

header('Content-type: text/json');
header('Content-type: application/json');

if($_SERVER['HTTP_HOST'] == "localhost"){
    $path = $_SERVER['DOCUMENT_ROOT']."/";
}else{
    $path = $_SERVER['DOCUMENT_ROOT'];
}
$path_ = $path."admin/class";


require_once($path_."/ingreso_class.php");
$ingreso = new Ingreso();
$info = $ingreso->ingresar_user();
echo json_encode($info);

?>