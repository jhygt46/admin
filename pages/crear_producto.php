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
$id_cat = 0;
if(isset($_GET["id_cat"]))
    $id_cat = $_GET["id_cat"];

$list = $admin->get_productos($id_cat);

$titulo = "Productos";
$titulo_list = "Lista de Productos";
$sub_titulo1 = "Ingresar Producto";
$sub_titulo2 = "Modificar Producto";
$accion = "crearproductos";

$eliminaraccion = "eliminarproductos";
$id_list = "id_pro";
$eliminarobjeto = "Producto";
$page_mod = "pages/crear_producto.php";
$page_asoc = "pages/asociar_producto.php";
/* CONFIG PAGE */

$id = 0;
$sub_titulo = $sub_titulo1;
if(isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] != 0){
    
    $sub_titulo = $sub_titulo2;
    $that = $admin->get_producto($_GET["id"]);
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
                        <input id="nombre" type="text" value="<?php echo $that['nombre']; ?>" require="" placeholder="Super 8" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Descripcion:</span>
                        <input id="descripcion" type="text" value="<?php echo $that['descripcion']; ?>" require="" placeholder="Oblea bañada en chocolate" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Precio:</span>
                        <input id="precio" type="text" value="<?php echo $that['precio']; ?>" require="" placeholder="250" />
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
                        <a title="SubCategorias" class="icn asociar" onclick="navlink('<?php echo $page_asoc; ?>?id=<?php echo $id; ?>')"></a>
                        
                    </ul>
                </li>
                
                <?php } ?>
                
            </ul>
            
        </div>
    </div>
</div>
<br />
<br />