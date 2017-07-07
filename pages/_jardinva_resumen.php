<?php
// TODOS LOS ARCHIVOS EN PAGES//
session_start();
if(!isset($_SESSION['user']['info']['id_user'])){
    exit;
}
$path = $_SERVER['DOCUMENT_ROOT'];
if($_SERVER['HTTP_HOST'] == "localhost"){
    $path .= "/";
}
$path_ = $path."admin/class";
require_once($path_."/admin.php");
// TODOS LOS ARCHIVOS EN PAGES//

$admin = new Admin();
//$admin->seguridad(1);
$tipo = $_GET["tipo"];


if($tipo == 1){
    
    $mes = $_GET["mes"];
    $año = $_GET["año"];
    
    $db_var_name = "_jardinva";
    $list_ = $admin->con->sql("SELECT * FROM ".$db_var_name."_boletas WHERE ano='".$año."' AND mes='".$mes."' AND eliminado='0' AND id_page='1'");
    $list = $list_['resultado'];
    echo "<pre>";
    print_r($list);
    echo "</pre>";

}
if($tipo == 2){
    
    $id_cur = $_GET["curso"];
    $id_cur = 0;
    
    $db_var_name = "_jardinva";
    $list_ = $admin->con->sql("SELECT * FROM ".$db_var_name."_alumnos WHERE id_cur='".$id_cur."' AND eliminado='0' AND id_page='1'");
    $list = $list_['resultado'];
    echo "<pre>";
    print_r($list_);
    echo "</pre>";

}
?>
<style>
    body{
        margin: 0px;
    }
    .tabla{
        background: #0ff;
        width: 100%;
        height: 100%;
    }
</style>
<table cellspacing='0' cellpadding='0' class='tabla'>
    <tr>
        <td>AA</td>
    </tr>
</table>