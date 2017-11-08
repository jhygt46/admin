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
$titulo = "Imagenes";
$titulo_list = "Lista de Imagenes";
$sub_titulo = "Ingresar Imagen";
$accion = "ingresarimagen";

$eliminaraccion = "eliminarimage";
$eliminarobjeto = "Imagen";
$page_resize = "pages/resize_imagen.php";
/* CONFIG PAGE */

$id = 0;

if(isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] != 0){
    
    if($_GET["db"] == "tour"){
        $db_name = "_jardinva_tour";
        $db_id = "id_tour";
    }
    if($_GET["db"] == "propiedades"){
        $db_name = "_javiermo_propiedades";
        $db_id = "id_pro";
    }
    $that = $admin->con->sql("SELECT * FROM ".$db_name." WHERE ".$db_id."='".$_GET["id"]."' AND id_page='3'");
    $id = $_GET["id"];
    $images = json_decode($that['resultado'][0]['images']);
    
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
                    <input id="db" type="hidden" value="<?php echo $_GET["db"]; ?>" />
                    <input id="accion" type="hidden" value="<?php echo $accion; ?>" />
                    <label>
                        <span>Nombre:</span>
                        <input id="file_image" type="file" />
                        <div class="mensaje"></div>
                    </label>
                    <label style='margin-top:20px'>
                        <span>&nbsp;</span>
                        <a id='button' onclick="form()">Enviar</a>
                    </label>
                </fieldset>
            </form>
            
        </div>
    </div>
</div>
<?php if(isset($images)){ ?>
<div class="info">
    <div class="fc" id="info-0">
        <div class="minimizar m1"></div>
        <div class="close"></div>
        <div class="name"><?php echo $titulo_list; ?></div>
        <div class="message"></div>
        <div class="sucont">
            
            <ul class='listUser'>
                
                <?php
                
                for($i=0; $i<count($images); $i++){
                    $nombre = $images[$i];
                ?>
                
                <li class="user">
                    <ul class="clearfix">
                        <li class="nombre"><?php echo $nombre; ?></li>
                        <a title="Eliminar" class="icn borrar" onclick="eliminar('<?php echo $eliminaraccion; ?>', '<?php echo $_GET["db"]; ?>/<?php echo $_GET["id"]; ?>/<?php echo $i; ?>', '<?php echo $eliminarobjeto; ?>', '<?php echo $nombre; ?>')"></a>
                        <?php if(false){ ?>
                        <a title="Cuadrar" class="icn cuadrar" onclick="navlink('<?php echo $page_resize; ?>?nombre=<?php echo $nombre; ?>')"></a>
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
<?php } ?>