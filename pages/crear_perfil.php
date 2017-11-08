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
$list = $admin->get_perfiles();
$tareas = $admin->get_tareas();

$titulo = "Perfil";
$titulo_list = "Lista de Perfiles";
$sub_titulo1 = "Ingresar Perfil";
$sub_titulo2 = "Modificar Perfil";
$accion = "crearperfiles";

$eliminaraccion = "eliminarperfiles";
$id_list = "id_per";
$eliminarobjeto = "Perfil";
$page_mod = "pages/crear_perfil.php";
/* CONFIG PAGE */

$id = 0;
$sub_titulo = $sub_titulo1;
if(isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] != 0){
    
    $sub_titulo = $sub_titulo2;
    $that = $admin->get_perfil($_GET["id"]);
    $id = $_GET["id"];
    
}


?>

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
                        <span>Nombre:</span>
                        <input id="nombre" type="text" value="<?php echo $that['nombre']; ?>" require="" placeholder="Diego Gomez" />
                        <div class="mensaje"></div>
                    </label>
                    <div class="newform">
                    <?php foreach($tareas as $value){ ?>
                    
                        <div class='grupo'><?php echo $value['grupo']; ?></div>
                        <div class="groupdetail">
                            <?php foreach($value['res'] as $value2){ $select = false; for($j=0; $j<count($that); $j++){ if($value2['id_tar'] == $that[$j]['id_tar']){ $select = true; } }?>
                            <label>
                                <input id="tareas-<?php echo $value2['id_tar']; ?>" type="checkbox" value="1" <?php if($select){ echo"checked='checked'"; } ?> />
                                <span class='detail'><?php echo $value2['nombre']; ?></span>
                            </label>
                            <?php } ?>
                        </div>
                    
                    <?php } ?>
                    </div>
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
                        <a title="Perfiles" class="icn agregaradmin" onclick="navlink('<?php echo $page_mod; ?>?parent_id=<?php echo $id; ?>')"></a>
                        
                    </ul>
                </li>
                
                <?php } ?>
                
            </ul>
            
        </div>
    </div>
</div>
<br />
<br />