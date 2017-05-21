<?php
session_start();

header('Content-type: text/json');
header('Content-type: application/json');




if($_POST["accion"] == "ingreso"){
    require_once("../../class/admin.php");
    $admin = new Admin();
    $info = $admin->ingreso();
    echo json_encode($info);
    exit;
}

require_once("../../class/guardar.php");
$guardar = new Guardar();
$data = $guardar->process();
echo json_encode($data);


?>