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
$admin->seguridad(1);

/* CONFIG PAGE */
$db_var_name = "_jardinva";
$list_ = $admin->con->sql("SELECT * FROM ".$db_var_name."_alumnos");
$list = $list_['resultado'];

$titulo = "Alumnos";
$titulo_list = "Lista de Alumnos";
$sub_titulo1 = "Ingresar Alumno";
$sub_titulo2 = "Modificar Alumno";
$accion = "crearalumnos";

$eliminaraccion = "eliminaralumnos";
$id_list = "id_alu";
$eliminarobjeto = "Alumno";
$page_mod = "pages/info_alumnos.php";
/* CONFIG PAGE */

$id = 0;
$sub_titulo = $sub_titulo1;
if(isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] != 0){
    
    $sub_titulo = $sub_titulo2;
    $that = $admin->con->sql("SELECT * FROM ".$db_var_name."_alumnos WHERE id_alu='".$_GET["id"]."'");
    $id = $_GET["id"];
    
}


?>
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
        font-size: 25px;
    }
    .padres li span{
        display: block;
    }
    .padres li input{
        width: 90%;
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
                        <input id="nombre" type="text" value="<?php echo $that['resultado'][0]['nombre']; ?>" require="" placeholder="Diego Gomez" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Apellidos:</span>
                        <input id="nombre" type="text" value="<?php echo $that['resultado'][0]['nombre']; ?>" require="" placeholder="Diego Gomez" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Rut:</span>
                        <input id="nombre" type="text" value="<?php echo $that['resultado'][0]['nombre']; ?>" require="" placeholder="Diego Gomez" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Direccion:</span>
                        <input id="nombre" type="text" value="<?php echo $that['resultado'][0]['nombre']; ?>" require="" placeholder="Diego Gomez" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Fecha de Nacimiento:</span>
                        <input id="correo" type="text" value="<?php echo $that['correo']; ?>" require="" placeholder="diegomez13@hotmail.com" />
                        <div class="mensaje"></div>
                    </label>
                    <ul class="padres clearfix">
                        <li>
                            <div class="padre">Padre</div>
                            <span>Nombre:</span>
                            <input type="text"></input>
                        </li>
                        <li>
                            <div class="padre">Madre</div>
                            <span>Nombre:</span>
                            <input type="text"></input>
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
        <div class="name"><?php echo $titulo_list; ?></div>
        <div class="message"></div>
        <div class="sucont">
            
            <ul class='listUser'>
                
                <?php
                
                for($i=0; $i<count($list); $i++){
                    $id = $list[$i][$id_list];
                    $nombre = $list[$i]['nombre'];
                ?>
                
                <li class="user">
                    <ul class="clearfix">
                        <li class="nombre"><?php echo $nombre; ?></li>
                        <a title="Eliminar" class="icn borrar" onclick="eliminar('<?php echo $eliminaraccion; ?>', <?php echo $id; ?>, '<?php echo $eliminarobjeto; ?>', '<?php echo $nombre; ?>')"></a>
                        <a title="Modificar" class="icn modificar" onclick="navlink('<?php echo $page_mod; ?>?id=<?php echo $id; ?>&parent_id=<?php echo $parent_id; ?>')"></a>
                        <?php if($_SESSION['user']['info']['tareas'] == 1){ ?>
                        <a title="Perfiles" class="icn agregaradmin" onclick="navlink('<?php echo $page_mod; ?>?parent_id=<?php echo $id; ?>')"></a>
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