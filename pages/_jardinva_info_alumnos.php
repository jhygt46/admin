<?php
// TODOS LOS ARCHIVOS EN PAGES//
session_start();

$path = $_SERVER['DOCUMENT_ROOT'];
if($_SERVER['HTTP_HOST'] == "localhost"){
    $path .= "/";
}
$path_ = $path."admin/class";
require_once($path_."/admin.php");
// TODOS LOS ARCHIVOS EN PAGES//

$admin = new Admin();
//$admin->seguridad(1);

/* CONFIG PAGE */
$db_var_name = "_jardinva";
$list_ = $admin->con->sql("SELECT * FROM ".$db_var_name."_alumnos  WHERE eliminado='0' AND id_page='1' ORDER BY orders");
$curs_ = $admin->con->sql("SELECT * FROM ".$db_var_name."_cursos WHERE eliminado='0' AND id_page='1' ORDER BY orders");
$list = $list_['resultado'];
$curs = $curs_['resultado'];

for($k=0; $k<count($list); $k++){
    
    //$apellidos = explode(" ", $list[$k]['apellidos']);
    //$admin->con->sql("UPDATE ".$db_var_name."_alumnos SET apellido_p='".$apellidos[0]."', apellido_m='".$apellidos[1]."' WHERE id_alu='".$list[$k]['id_alu']."'");

}



$titulo = "Alumnos";
$titulo_list = "Lista de Alumnos";
$sub_titulo1 = "Ingresar Alumno";
$sub_titulo2 = "Modificar Alumno";
$accion = "_jardinva_crearalumnos";

$eliminaraccion = "_jardinva_eliminaralumnos";
$id_list = "id_alu";
$eliminarobjeto = "Alumno";
$page_mod = "pages/_jardinva_info_alumnos.php";
/* CONFIG PAGE */

$id = 0;
$sub_titulo = $sub_titulo1;
if(isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] != 0){
    
    $sub_titulo = $sub_titulo2;
    $that = $admin->con->sql("SELECT * FROM ".$db_var_name."_alumnos WHERE id_alu='".$_GET["id"]."' AND eliminado='0' AND id_page='1'");
    $id = $_GET["id"];
    
}


?>

<script>
    $('.listUser').sortable({
        stop: function(e, ui){
            var order = [];
            $(this).find('.user').each(function(){
                order.push($(this).attr('rel'));
            });
            
            var send = {accion: 'order', values: order, tabla: '_cursos_md02', id: 'id_alu'};
            $.ajax({
                url: "ajax/index.php",
                type: "POST",
                data: send,
                success: function(data){
                    
                }, error: function(e){

                }
            });
            
        }
    });
    $('.listUser').disableSelection();
</script>  

<style>
    .padres{
        margin-left: 16%;
        width: 75%;
        padding: 15px 0px;
    }
    .padres li{
        float: left;
        width: 50%;
    }
    .padres li .padre{
        font-size: 22px;
    }
    .padres li span{
        display: block;
        padding-top: 10px;
    }
    .padres li input{
        width: 100%;
    }
</style>

<div class="title">
    <h1><?php echo $titulo; ?></h1>
    <ul class="clearfix">
        <li class="back" onclick="backurl()"></li>
    </ul>
</div>
<hr>
<div class="info">
    <div class="fc" id="info-0">
        <div class="minimizar m1"></div>
        <div class="close"></div>
        <div class="options">
            <ul class="ops clearfix">
                <li class="op">
                    <ul class="ss clearfix">
                        <li></li>
                        <li class="ic4a" onclick="openwn('pages/_jardinva_resumen.php?tipo=3', 1320, 450)" title="Informacion"></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="name"><?php echo $sub_titulo; ?></div>
        <div class="message"></div>
        <div class="sucont">

            <form action="" method="post" class="basic-grey">
                <fieldset>
                    <input id="id" type="hidden" value="<?php echo $id; ?>" />
                    <input id="accion" type="hidden" value="<?php echo $accion; ?>" />
                    <label>
                        <span>N° de Matricula:</span>
                        <input id="nmatricula" type="text" value="<?php echo $that['resultado'][0]['nmatricula']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Rut:</span>
                        <input id="rut" type="text" value="<?php echo $that['resultado'][0]['rut']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Apellidos Paterno:</span>
                        <input id="apellido_p" type="text" value="<?php echo $that['resultado'][0]['apellido_p']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Apellidos Materno:</span>
                        <input id="apellido_m" type="text" value="<?php echo $that['resultado'][0]['apellido_m']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Nombres:</span>
                        <input id="nombres" type="text" value="<?php echo $that['resultado'][0]['nombres']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Sexo:</span>
                        <select id="sexo">
                            <option value="0">Seleccionar</option>
                            <option value="1" <?php if($that['resultado'][0]['sexo'] == 1){ echo "selected"; } ?>>Masculino</option>
                            <option value="2" <?php if($that['resultado'][0]['sexo'] == 2){ echo "selected"; } ?>>Femenino</option>
                        </select>
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Fecha Nacimiento:</span>
                        <input id="fecha_nacimiento" type="text" value="<?php echo $that['resultado'][0]['fecha_nacimiento']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Fecha Matricula:</span>
                        <input id="fecha_matricula" type="text" value="<?php echo $that['resultado'][0]['fecha_matricula']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Fecha Ingreso:</span>
                        <input id="fecha_ingreso" type="text" value="<?php echo $that['resultado'][0]['fecha_ingreso']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Direccion:</span>
                        <input id="direccion" type="text" value="<?php echo $that['resultado'][0]['direccion']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Nombre Apoderado:</span>
                        <input id="nombre_apoderado" type="text" value="<?php echo $that['resultado'][0]['nombre_apoderado']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Telefono Apoderado:</span>
                        <input id="telefono_apoderado" type="text" value="<?php echo $that['resultado'][0]['telefono_apoderado']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Email Apoderado:</span>
                        <input id="email_apoderado" type="text" value="<?php echo $that['resultado'][0]['email_apoderado']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Fecha Retiro:</span>
                        <input id="fecha_retiro" type="text" value="<?php echo $that['resultado'][0]['fecha_retiro']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Motivo Retiro:</span>
                        <select id="motivo_retiro">
                            <option value="0">Seleccionar</option>
                            <option value="1" <?php if($that['resultado'][0]['motivo_retiro'] == 1){ echo "selected"; } ?>>Cumpli&oacute; 2 a&ntilde;os</option>
                            <option value="2" <?php if($that['resultado'][0]['motivo_retiro'] == 2){ echo "selected"; } ?>>Enfermedad</option>
                            <option value="3" <?php if($that['resultado'][0]['motivo_retiro'] == 3){ echo "selected"; } ?>>Decision de Padres</option>
                            <option value="4" <?php if($that['resultado'][0]['motivo_retiro'] == 4){ echo "selected"; } ?>>Egreso</option>
                        </select>
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Observaciones:</span>
                        <textarea id="observaciones"><?php echo $that['resultado'][0]['observaciones']; ?></textarea>
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Curso:</span>
                        <select id="curso">
                            <option value="0">Retirado</option>
                            <?php for($i=0; $i<$curs_['count']; $i++){ $sel=""; if($curs[$i]['id_cur'] == $that['resultado'][0]['id_cur']){ $sel = "selected"; } ?>
                            <option value="<?php echo $curs[$i]['id_cur']; ?>" <?php echo $sel; ?>><?php echo $curs[$i]['nombre']; ?></option>
                            <?php } ?>
                        </select>
                        <div class="mensaje"></div>
                    </label>
                    
                    <ul class="padres clearfix">
                        <li>
                            <div class="padre">Madre</div>
                            <span>Nombre:</span>
                            <input type="text" id="nombre_01" value="<?php echo $that['resultado'][0]['nombre_01']; ?>"></input>
                            <span>Tel celular:</span>
                            <input type="text" id="celular_01" value="<?php echo $that['resultado'][0]['celular_01']; ?>"></input>
                            <span>Email :</span>
                            <input type="text" id="email_01" value="<?php echo $that['resultado'][0]['email_01']; ?>"></input>
                        </li>
                        <li>
                            <div class="padre">Padre</div>
                            <span>Nombre:</span>
                            <input type="text" id="nombre_02" value="<?php echo $that['resultado'][0]['nombre_02']; ?>"></input>
                            <span>Tel celular:</span>
                            <input type="text" id="celular_02" value="<?php echo $that['resultado'][0]['celular_02']; ?>"></input>
                            <span>Email :</span>
                            <input type="text" id="email_02" value="<?php echo $that['resultado'][0]['email_02']; ?>"></input>
                        </li>
                    </ul>
                    
                    <label style='margin-top:20px'>
                        <span>&nbsp;</span>
                        <a id='button' onclick="form()">Enviar</a>
                    </label>
                </fieldset>
            </form>
            
        </div>
    </div>
</div>

<div class="info">
    <div class="fc" id="info-0">
        <div class="minimizar m1"></div>
        <div class="close"></div>
        <div class="options">
            <ul class="ops clearfix">
                <li class="op">
                    <ul class="ss clearfix">
                        <li><input class="inptxt" type="text"></li>
                        <li class="ic1" onclick="opcs(this, 'name')" title="Nombre"></li>
                    </ul>
                </li>
                <li class="op">
                    <ul class="ss clearfix">
                        <li>
                            <select class="inpsel">
                                <option value='-1'>Todos</option>
                                <?php for($i=0; $i<count($curs); $i++){ ?>
                                <option value='<?php echo $curs[$i]['id_cur']; ?>'><?php echo $curs[$i]['nombre']; ?></option>
                                <?php } ?>
                            </select>
                        </li>
                        <li class="ic2" onclick="opcs(this, 'id_cur')" title="Curso"></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="name"><?php echo $titulo_list; ?></div>
        <div class="message"></div>
        <div class="sucont">
            
            <ul class='listUser'>
                
                <?php
                
                for($i=0; $i<count($list); $i++){
                    $k = $i + 1;
                    $id = $list[$i][$id_list];
                    $nombre = $k."- ".$list[$i]['nombres']." ".$list[$i]['apellido_p']." ".$list[$i]['apellido_m'];
                    $id_cur = $list[$i]['id_cur'];
                ?>
                
                <li class="user" rel="<?php echo $id; ?>">
                    <ul class="clearfix">
                        <li class="nombre" id_cur="<?php echo $id_cur; ?>" name="<?php echo $nombre; ?>"><?php echo $nombre; ?></li>
                        <a title="Eliminar" class="icn borrar" onclick="eliminar('<?php echo $eliminaraccion; ?>', <?php echo $id; ?>, '<?php echo $eliminarobjeto; ?>', '<?php echo $nombre; ?>')"></a>
                        <a title="Modificar" class="icn modificar" onclick="navlink('<?php echo $page_mod; ?>?id=<?php echo $id; ?>')"></a>
                        <?php if($_SESSION['user']['info']['tareas'] == 1){ ?>
                        <a title="Perfiles" class="icn agregaradmin" onclick="navlink('<?php echo $page_mod; ?>?id=<?php echo $id; ?>')"></a>
                        <?php } ?>
                    </ul>
                </li>
                
                <?php } ?>
                
            </ul>
            
        </div>
    </div>
</div>
<br />
<br />