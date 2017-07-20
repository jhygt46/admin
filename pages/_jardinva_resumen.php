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
if($tipo == 2){
    
    $admin_curso = $admin->con->sql("SELECT * FROM ".$db_var_name."_cursos WHERE id_cur='".$id_cur."' AND eliminado='0' AND id_page='1'");
    $prnt_id = $admin_curso['resultado'][0]['parent_id'];
    
    if($prnt_id > 0){
        $list_ = $admin->con->sql("SELECT * FROM ".$db_var_name."_alumnos WHERE (id_cur='".$id_cur."' OR id_cur='".$prnt_id."') AND eliminado='0' AND id_page='1'");
    }else{
        $list_ = $admin->con->sql("SELECT * FROM ".$db_var_name."_alumnos WHERE id_cur='".$id_cur."' AND eliminado='0' AND id_page='1'");
    }

    $list = $list_['resultado'];
    
    echo "<pre>";
    print_r($list);
    echo "</pre>";
    
}
if($tipo == 3){
    
    $list_ = $admin->con->sql("SELECT * FROM ".$db_var_name."_alumnos WHERE eliminado='0' AND id_page='1'");
    $list = $list_['resultado'];
    
}
?>
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

    <table cellspacing="0" cellpadding="0" class="tabla" border="1" width="1300px">
        <tr class="td1">
            <td width="20" class="color01">#</td>
            <td style="text-align: left; padding: 2px 4px" width="180" class="color01">Nombre</td>
            <td width="100" class="color01">Matricula</td>
            <td width="100" class="color01">Marzo</td>
            <td width="100" class="color01">Abril</td>
            <td width="100" class="color01">Mayo</td>
            <td width="100" class="color01">Junio</td>
            <td width="100" class="color01">Julio</td>
            <td width="100" class="color01">Agosto</td>
            <td width="100" class="color01">Septiembre</td>
            <td width="100" class="color01">Octubre</td>
            <td width="100" class="color01">Nomviembre</td>
            <td width="100" class="color01">Diciembre</td>
        </tr>
        <?php for($i=0; $i<count($list); $i++){ $r=$i+1; if($i % 2 == 0){ $c = "color02"; }else{ $c = "color01"; } ?>
        <tr>
            <td class="<?php echo $c; ?>"><?php echo $r; ?></td>
            <td align="left" style="padding: 2px 4px" class="<?php echo $c; ?>"><?php echo utf8_encode($list[$i]['nombres']); ?> <?php echo utf8_encode($list[$i]['apellido_p']); ?></td>
            <td class="<?php echo $c; ?>"></td>
            <td class="<?php echo $c; ?>"></td>
            <td class="<?php echo $c; ?>"></td>
            <td class="<?php echo $c; ?>"></td>
            <td class="<?php echo $c; ?>"></td>
            <td class="<?php echo $c; ?>"></td>
            <td class="<?php echo $c; ?>"></td>
            <td class="<?php echo $c; ?>"></td>
            <td class="<?php echo $c; ?>"></td>
            <td class="<?php echo $c; ?>"></td>
            <td class="<?php echo $c; ?>"></td>
        </tr>
        <?php } ?>
    </table>
<?php } ?>


<?php if($tipo == 3){ ?>

    <table cellspacing="0" cellpadding="0" class="tabla" border="1" width="1300px">
        <tr class="td1">
            <td width="20" class="color01">#</td>
            <td style="text-align: left; padding: 2px 4px" width="195" class="color01">Nombre</td>
            <?php for($m=1; $m<=31; $m++){ ?>
            <td width="35" class="color01"><?php echo $m; ?></td>
            <?php } ?>
        </tr>
        <?php for($i=0; $i<count($list); $i++){ $r=$i+1; if($i % 2 == 0){ $c = "color02"; }else{ $c = "color01"; } ?>
        <tr>
            <td class="<?php echo $c; ?>"><?php echo $r; ?></td>
            <td align="left" style="padding: 2px 4px" class="<?php echo $c; ?>"><?php echo utf8_encode($list[$i]['nombres']); ?> <?php echo utf8_encode($list[$i]['apellido_p']); ?></td>
            <?php for($m=1; $m<=31; $m++){ ?>
            <td class="<?php echo $c; ?>"></td>
            <?php } ?>
        </tr>
        <?php } ?>
    </table>
<?php } ?>


<?php if($tipo == 2){ ?>
<table cellspacing="0" cellpadding="0" class="tabla" border="0" width="1300px">
    <tr class="td1">
        <td colspan="4" class="color01">Alumnos</td>
        <td colspan="3" class="color02">Mama</td>
        <td colspan="3" class="color01">Papa</td>
    </tr>
    <tr class="td2">
        
        <td width="30" class="color01a" align="center">#</td>
        <td width="250" class="color01a">Nombre</td>
        <td width="190" class="color01a">Fecha de Nacimiento</td>
        <td width="130" class="color01a">Telefono Casa</td>

        <td width="150" class="padd color02a">Nombre</td>
        <td width="100" class="color02a">Fono Oficina</td>
        <td width="100" class="color02a">Fono Celular</td>
        
        <td width="150" class="color01a padd">Nombre</td>
        <td width="100" class="color01a">Fono Oficina</td>
        <td width="100" class="color01a">Fono Celular</td>
        
    </tr>
    
    <?php for($i=0; $i<count($list); $i++){ $f = $i + 1; $f_n = explode("-", $list[$i]['fecha_nacimiento']); if($i % 2 == 0){ $class_01 = "color01b"; $class_02 = "color02b"; }else{ $class_01 = "color01c"; $class_02 = "color02c"; } ?>
    
    <tr class="td3">
        
        <td class="<?php echo $class_01; ?>" align="center"><?php echo $f; ?></td>
        <td class="<?php echo $class_01; ?>" ><?php echo $list[$i]['nombres']." ".$list[$i]['apellidos']; ?></td>
        <td class="<?php echo $class_01; ?>" ><?php echo $f_n[2]; ?> de <?php echo mes(intval($f_n[1])); ?> de <?php echo $f_n[0]; ?></td>
        <td class="<?php echo $class_01; ?>" >+56222044474</td>
        <td class="<?php echo $class_02; ?>" ><?php echo $list[$i]['nombre_01']; ?></td>
        <td class="<?php echo $class_02; ?>" ><?php echo $list[$i]['oficina_01']; ?></td>
        <td class="<?php echo $class_02; ?>" ><?php echo $list[$i]['celular_01']; ?></td>
        <td class="<?php echo $class_01; ?>" ><?php echo $list[$i]['nombre_02']; ?></td>
        <td class="<?php echo $class_01; ?>" ><?php echo $list[$i]['oficina_02']; ?></td>
        <td class="<?php echo $class_01; ?>" ><?php echo $list[$i]['celular_02']; ?></td>
        
    </tr>
    
    <?php } ?>
<?php } ?>

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