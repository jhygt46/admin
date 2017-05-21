<?php
session_start();

header('Content-type: text/json');
header('Content-type: application/json');

require_once("../../class/fireapp.php");
$fire = new Fireapp();
$info = $fire->ingreso();
echo json_encode($info);

?>