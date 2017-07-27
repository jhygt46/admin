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
$id_cur = $_GET["curso"];
$db_var_name = "_jardinva";

if($tipo == 1){
    
    $list_ = $admin->con->sql("SELECT * FROM ".$db_var_name."_alumnos WHERE eliminado='0' AND id_page='1'");
    $list = $list_['resultado'];

}
if($tipo == 3){
    
    $admin_curso = $admin->con->sql("SELECT * FROM ".$db_var_name."_cursos WHERE id_cur='".$id_cur."' AND eliminado='0' AND id_page='1'");
    $prnt_id = $admin_curso['resultado'][0]['parent_id'];
    
    if($prnt_id > 0){
        $list_ = $admin->con->sql("SELECT * FROM ".$db_var_name."_alumnos WHERE (id_cur='".$id_cur."' OR id_cur='".$prnt_id."') AND eliminado='0' AND id_page='1'");
    }else{
        $list_ = $admin->con->sql("SELECT * FROM ".$db_var_name."_alumnos WHERE id_cur='".$id_cur."' AND eliminado='0' AND id_page='1'");
    }

    $list = $list_['resultado'];
    
}
if($tipo == 2 || $tipo == 4){
    
    $list_ = $admin->con->sql("SELECT * FROM ".$db_var_name."_alumnos WHERE eliminado='0' AND id_page='1'");
    $list = $list_['resultado'];
    
}
?>

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" lang="es-CL">
    <head>
        <title>Jardin Valle Encantado - Administrador</title>
        <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    </head>
    <body>
        <style>
            body{
                margin: 0px;
            }
            .tabla{

            }
            .tabla tr{

            }
            .td1{
                height: 60px;
                font-size: 16px;
            }
            .td1 td{
                text-align: center;
            }
            .td2{
                height: 40px;
                font-size: 14px;
            }
            .td3{
                height: 30px;
                font-size: 12px;
            }
            .color01{
                background: #efefef;
            }
            .color01a{
                background: #e8e8e8;
            }
            .color01b{
                background: #f9f9f9;
            }
            .color01c{
                background: #f4f4f4;
            }
            .color02{
                background: #eaeaea;
            }
            .color02a{
                background: #e4e4e4;
            }
            .color02b{
                background: #f8f8f8;
            }
            .color02c{
                background: #f3f3f3;
            }
            .padd{
                padding-left: 5px;
            }
        </style>

<?php if($tipo == 1){ ?>
    <table cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td colspan="2"><img src="../images/hada.jpg"></td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 18px; padding-top: 5px;">Lista de Pagos</td>
        </tr>
    </table>
    <table cellspacing="0" cellpadding="0" class="tabla" border="1" width="1300px" style="margin-top: 25px">
        <tr class="td2">
            <td width="20">#</td>
            <td style="text-align: left; padding: 2px 4px" width="180">Nombre</td>
            <td width="100" style="padding-left: 4px">Matricula</td>
            <td width="100" style="padding-left: 4px">Marzo</td>
            <td width="100" style="padding-left: 4px">Abril</td>
            <td width="100" style="padding-left: 4px">Mayo</td>
            <td width="100" style="padding-left: 4px">Junio</td>
            <td width="100" style="padding-left: 4px">Julio</td>
            <td width="100" style="padding-left: 4px">Agosto</td>
            <td width="100" style="padding-left: 4px">Septiembre</td>
            <td width="100" style="padding-left: 4px">Octubre</td>
            <td width="100" style="padding-left: 4px">Nomviembre</td>
            <td width="100" style="padding-left: 4px">Diciembre</td>
        </tr>
        <?php for($i=0; $i<count($list); $i++){ $r=$i+1; if($i % 2 == 0){ $c = "color02"; }else{ $c = "color01"; } ?>
        <tr>
            <td><?php echo $r; ?></td>
            <td align="left" style="padding: 2px 4px"><?php echo utf8_encode($list[$i]['nombres']); ?> <?php echo utf8_encode($list[$i]['apellido_p']); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <?php } ?>
    </table>
<?php } ?>


<?php if($tipo == 3){ ?>

    <table cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td colspan="2"><img src="../images/hada.jpg"></td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 20px">Asistencia Por Nivel <?php echo $admin_curso['resultado'][0]['nombre']; ?></td>
        </tr>
        <tr>
            <td width="300" style="padding: 5px 0px">Educadora: ____________</td>
            <td width="300">Fecha: _____/_____</td>
        </tr>
    </table>
    <br><br><br>
    <table cellspacing="0" cellpadding="0" class="tabla" border="1" width="1300px">
        <tr class="td1">
            <td width="20">#</td>
            <td style="text-align: left; padding: 2px 4px" width="195">Nombre</td>
            <?php for($m=1; $m<=31; $m++){ ?>
            <td width="35"><?php echo $m; ?></td>
            <?php } ?>
        </tr>
        <?php for($i=0; $i<count($list); $i++){ $r=$i+1; if($i % 2 == 0){ $c = "color02"; }else{ $c = "color01"; } ?>
        <tr>
            <td><?php echo $r; ?></td>
            <td align="left" style="padding: 2px 4px">- <?php echo utf8_encode($list[$i]['nombres']); ?> <?php echo utf8_encode($list[$i]['apellido_p']); ?></td>
            <?php for($m=1; $m<=31; $m++){ ?>
            <td></td>
            <?php } ?>
        </tr>
        <?php } ?>
        <tr>
            <td></td>
            <td style="padding: 2px 4px">Total Presentes</td>
            <?php for($m=1; $m<=31; $m++){ ?>
            <td></td>
            <?php } ?>
        </tr>
        <tr>
            <td></td>
            <td style="padding: 2px 4px">Total Ausentes</td>
            <?php for($m=1; $m<=31; $m++){ ?>
            <td></td>
            <?php } ?>
        </tr>
    </table>
<?php } ?>


<?php if($tipo == 2){ ?>

    <table cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td colspan="2"><img src="../images/hada.jpg"></td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 18px; padding-top: 5px;">Informacion</td>
        </tr>
    </table>

<table cellspacing="0" cellpadding="0" class="tabla" border="0" width="1300px" style="margin-top: 25px">
    
    <tr class="td2">
        <td width="20">#</td>
        <td width="60">Matricula</td>
        <td width="160">Nombre</td>
        <td width="70">Rut</td>
        <td width="100">Fecha Nac</td>
        <td width="60">Sexo</td>
        <td width="190">Direccion</td>
        <td width="100">Fecha Mat</td>
        <td width="100">Fecha Ing</td>
        <td width="100">Apoderado</td>
        <td width="100">Telefono</td>
        <td width="100">Email</td>
        <td width="140"></td>
    </tr>
    
    
    <?php 
    
    for($i=0; $i<count($list); $i++){ 
        $f = $i + 1;
        $f_n = strtotime($list[$i]['fecha_nacimiento']);
        $f_i = strtotime($list[$i]['fecha_ingreso']);
        $f_m = strtotime($list[$i]['fecha_matricula']);
        ?>
    
    <tr class="td3">
        
        <td class="<?php echo $class_01; ?>" align="center"><?php echo $f; ?></td>
        <td class="<?php echo $class_02; ?>" ><?php echo $list[$i]['nmatricula']; ?></td>
        <td class="<?php echo $class_01; ?>" ><?php echo $list[$i]['nombres']." ".$list[$i]['apellido_p']." ".$list[$i]['apellido_m']; ?></td>
        <td class="<?php echo $class_02; ?>" ><?php echo $list[$i]['rut']; ?></td>
        <td class="<?php echo $class_01; ?>" ><?php echo intval($f_n[2]); ?>/<?php echo intval($f_n[1]); ?>/<?php echo $f_n[0]; ?></td>
        <td class="<?php echo $class_02; ?>" ><?php echo ($list[$i]['sexo'] == 1)? "Masculino" : "Femenino"; ?></td>
        <td class="<?php echo $class_01; ?>" ><?php echo $list[$i]['direccion']; ?></td>
        <td class="<?php echo $class_02; ?>" ><?php echo intval($f_i[2]); ?>/<?php echo intval($f_i[1]); ?>/<?php echo $f_i[0]; ?></td>
        <td class="<?php echo $class_01; ?>" ><?php echo intval($f_m[2]); ?>/<?php echo intval($f_m[1]); ?>/<?php echo $f_m[0]; ?></td>
        <td class="<?php echo $class_02; ?>" ><?php echo $list[$i]['nombre_apoderado']; ?></td>
        <td class="<?php echo $class_01; ?>" ><?php echo $list[$i]['telefono_apoderado']; ?></td>
        <td class="<?php echo $class_02; ?>" ><?php echo $list[$i]['email_apoderado']; ?></td>
        <td class="<?php echo $class_01; ?>" ></td>
        
    </tr>
    
    <?php } ?>
<?php } ?>
    <?php if($tipo == 4){ ?>

    <table cellspacing="0" cellpadding="0" border="0">
        <tr>
            <td colspan="2"><img src="../images/hada.jpg"></td>
        </tr>
        <tr>
            <td colspan="2" style="font-size: 18px; padding-top: 5px;">Datos Generales</td>
        </tr>
    </table>

<table cellspacing="0" cellpadding="0" class="tabla" border="1" width="1300px" style="margin-top: 25px">
    <tr style="font-size: 22px; padding: 3px 0px;">
        <td colspan="2" align="center">Alumno</td>
        <td colspan="2" align="center">Mama</td>
        <td colspan="2" align="center">Papa</td>
    </tr>
    <tr style="font-size: 20px; padding: 2px 0px;">
        <td width="20">#</td>
        <td width="360">Nombre</td>
        <td width="230">Nombre</td>
        <td width="230">Celular</td>
        <td width="230">Nombre</td>
        <td width="230">Celular</td>
    </tr>
    
    <?php
    for($i=0; $i<count($list); $i++){ $f = $i + 1;
    ?>
    
    <tr style="font-size: 18px; padding: 1px 0px;">
        
        <td><?php echo $f; ?></td>
        <td><?php echo utf8_encode($list[$i]['nombres'])." ".utf8_encode($list[$i]['apellido_p'])." ".utf8_encode($list[$i]['apellido_m']); ?></td>
        <td><?php echo utf8_encode($list[$i]['nombre_01']); ?></td>
        <td><?php echo $list[$i]['celular_01']; ?></td>
        <td><?php echo utf8_encode($list[$i]['nombre_02']); ?></td>
        <td><?php echo $list[$i]['celular_02']; ?></td>
        
    </tr>
    
    <?php } ?>
<?php } ?>
</body>
</html>
<?php

    function mes($i){
            
        if($i == 1) return "Enero";
        if($i == 2) return "Febrero";
        if($i == 3) return "Marzo";
        if($i == 4) return "Abril";
        if($i == 5) return "Mayo";
        if($i == 6) return "Junio";
        if($i == 7) return "Julio";
        if($i == 8) return "Agosto";
        if($i == 9) return "Septiembre";
        if($i == 10) return "Ocubre";
        if($i == 11) return "Noviembre";
        if($i == 12) return "Diciembre";
            
    }
        
?>