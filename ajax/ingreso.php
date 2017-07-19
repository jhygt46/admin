<?php
session_start();

header('Content-type: text/json');
header('Content-type: application/json');

$path = $_SERVER['DOCUMENT_ROOT'];
if($_SERVER['HTTP_HOST'] == "localhost"){
    $path .= "/";
}
$path_ = $path."admin/class";


require_once($path_."/ingreso_class.php");
$ingreso = new Ingreso();
$info = $ingreso->ingresar_user();
echo json_encode($info);

?>