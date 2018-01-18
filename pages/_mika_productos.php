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
$titulo = "Productos";
$titulo_list = "Lista de Productos";
$sub_titulo1 = "Ingresar Producto";
$sub_titulo2 = "Modificar Producto";
$accion = "_mika_crear_producto";

$eliminaraccion = "_mika_eliminar_producto";
$id_list = "id_pro";
$eliminarobjeto = "Producto";
$page_mod = "pages/_mika_productos.php";
/* CONFIG PAGE */

$id_cat = 0;
$sub_titulo = $sub_titulo1;
if(isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] != 0){
    
    $id_cat = $_GET["id"];
    $mm = $admin->con->sql("SELECT * FROM _mika_productos WHERE id_page='".$_SESSION['user']['info']['id_page']."' AND id_cat='".$id_cat."' AND eliminado='0'");
    $list = $mm['resultado'];
    $id_pro = 0;
    
    if(isset($_GET["id_pro"]) && is_numeric($_GET["id_pro"]) && $_GET["id_pro"] != 0){
        
        $sub_titulo = $sub_titulo2;
        $aux = $admin->con->sql("SELECT * FROM _mika_productos WHERE id_page='".$_SESSION['user']['info']['id_page']."' AND id_pro='".$_GET["id_pro"]."' AND eliminado='0'");
        $that = $aux['resultado'][0];
        $id_pro = $_GET["id_pro"];
    
    }
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
                    <input id="id_cat" type="hidden" value="<?php echo $id_cat; ?>" />
                    <input id="id_pro" type="hidden" value="<?php echo $id_pro; ?>" />
                    <input id="accion" type="hidden" value="<?php echo $accion; ?>" />
                    <label>
                        <span>Numero:</span>
                        <input id="numero" type="text" value="<?php echo $that['numero']; ?>" require="" placeholder="1" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Nombre:</span>
                        <input id="nombre" type="text" value="<?php echo $that['nombre']; ?>" require="" placeholder="Salmon, palta, queso crema" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Precio:</span>
                        <input id="precio" type="text" value="<?php echo $that['precio']; ?>" require="" placeholder="0" />
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
                    $numero = $list[$i]['numero'];
                ?>
                
                <li class="user" rel="<?php echo $id; ?>">
                    <ul class="clearfix">
                        <li class="nombre"><?php echo $numero; ?>.- <?php echo $nombre; ?></li>
                        <a title="Eliminar" class="icn borrar" onclick="eliminar('<?php echo $eliminaraccion; ?>', <?php echo $id; ?>, '<?php echo $eliminarobjeto; ?>', '<?php echo $nombre; ?>')"></a>
                        <a title="Modificar" class="icn modificar" onclick="navlink('<?php echo $page_mod; ?>?id=<?php echo $id_cat; ?>&id_pro=<?php echo $id; ?>')"></a>
                    </ul>
                </li>
                
                <?php } ?>
                
            </ul>
            
        </div>
    </div>
</div>
<br />
<br />