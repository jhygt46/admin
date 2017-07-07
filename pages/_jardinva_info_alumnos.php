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
        <div class="name"><?php echo $sub_titulo; ?></div>
        <div class="message"></div>
        <div class="sucont">

            <form action="" method="post" class="basic-grey">
                <fieldset>
                    <input id="id" type="hidden" value="<?php echo $id; ?>" />
                    <input id="accion" type="hidden" value="<?php echo $accion; ?>" />
                    <label>
                        <span>Nombres:</span>
                        <input id="nombres" type="text" value="<?php echo $that['resultado'][0]['nombres']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Apellidos:</span>
                        <input id="apellidos" type="text" value="<?php echo $that['resultado'][0]['apellidos']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Rut:</span>
                        <input id="rut" type="text" value="<?php echo $that['resultado'][0]['rut']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Direccion:</span>
                        <input id="direccion" type="text" value="<?php echo $that['resultado'][0]['direccion']; ?>" require="" placeholder="" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Fecha Nacimiento:</span>
                        <input id="fecha_nacimiento" type="text" value="<?php echo $that['resultado'][0]['fecha_nacimiento']; ?>" require="" placeholder="2017-06-27" />
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
                            <span>Tel oficina:</span>
                            <input type="text" id="oficina_01" value="<?php echo $that['resultado'][0]['oficina_01']; ?>"></input>
                            <span>Tel casa:</span>
                            <input type="text" id="casa_01" value="<?php echo $that['resultado'][0]['casa_01']; ?>"></input>
                            <span>Email :</span>
                            <input type="text" id="email_01" value="<?php echo $that['resultado'][0]['email_01']; ?>"></input>
                        </li>
                        <li>
                            <div class="padre">Padre</div>
                            <span>Nombre:</span>
                            <input type="text" id="nombre_02" value="<?php echo $that['resultado'][0]['nombre_02']; ?>"></input>
                            <span>Tel celular:</span>
                            <input type="text" id="celular_02" value="<?php echo $that['resultado'][0]['celular_02']; ?>"></input>
                            <span>Tel Oficina:</span>
                            <input type="text" id="oficina_02" value="<?php echo $that['resultado'][0]['oficina_02']; ?>"></input>
                            <span>Tel casa:</span>
                            <input type="text" id="casa_02" value="<?php echo $that['resultado'][0]['casa_02']; ?>"></input>
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
                    $nombre = $k."- ".$list[$i]['nombres']." ".$list[$i]['apellidos'];
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