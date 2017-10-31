<?php
session_start();

header('Content-type: text/json');
header('Content-type: application/json');

$path = $_SERVER['DOCUMENT_ROOT'];
if($_SERVER['HTTP_HOST'] == "localhost"){
    $path .= "/";
}
$path_ = $path."admin/class";

echo "1";
require_once($path_."/ingreso_class.php");
echo "2";
$ingreso = new Ingreso();
echo "3";
$info = $ingreso->ingresar_user();
echo "4";
echo json_encode($info);

?>