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

//$res = $admin->arbol_categoria();
$aux = $admin->con->sql("SELECT * FROM _mika_promos WHERE id_page='".$_SESSION['user']['info']['id_page']."' AND eliminado='0' ORDER BY orders");

$list = $aux['resultado'];
$titulo = "Promociones";
$titulo_list = "Lista de Promociones";
$sub_titulo1 = "Ingresar Promocion";
$sub_titulo2 = "Modificar Promocion";
$accion = "_mika_crear_promos";

$eliminaraccion = "_mika_eliminar_promocion";
$id_list = "id_prom";
$eliminarobjeto = "Promociones";
$page_mod = "pages/_mika_crear_promos.php";
/* CONFIG PAGE */

$id = 0;
$sub_titulo = $sub_titulo1;
if(isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] != 0){
    
    $id = $_GET["id"];
    $sub_titulo = $sub_titulo2;
    $mm = $admin->con->sql("SELECT * FROM _mika_promos WHERE id_page='".$_SESSION['user']['info']['id_page']."' AND id_prom='".$id."' AND eliminado='0'");
    $that = $mm['resultado'][0];
    
}


?>

<script>
    $('.listUser').sortable({
        stop: function(e, ui){
            var order = [];
            $(this).find('.user').each(function(){
                order.push($(this).attr('rel'));
            });
            var send = {accion: 'order', values: order, tabla: '_promos_mika', id: 'id_prom'};
            $.ajax({
                url: "ajax/index.php",
                type: "POST",
                data: send,
                success: function(data){
                    console.log(data);
                }, error: function(e){

                }
            });
            
        }
    });
    $('.listUser').disableSelection();
</script>   


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
                        <input id="nombre" type="text" value="<?php echo $that['nombre']; ?>" require="" placeholder="California Rolls" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Tipo:</span>
                        <input id="precio" type="text" value="<?php echo $that['precio']; ?>" require="" placeholder="3800" />
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
                
                <li class="user" rel="<?php echo $id; ?>">
                    <ul class="clearfix">
                        <li class="nombre"><?php echo $nombre; ?></li>
                        <a title="Eliminar" class="icn borrar" onclick="eliminar('<?php echo $eliminaraccion; ?>', <?php echo $id; ?>, '<?php echo $eliminarobjeto; ?>', '<?php echo $nombre; ?>')"></a>
                        <a title="Modificar" class="icn modificar" onclick="navlink('<?php echo $page_mod; ?>?id=<?php echo $id; ?>')"></a>
                    </ul>
                </li>
                
                <?php } ?>
                
            </ul>
            
        </div>
    </div>
</div>
<br />
<br />