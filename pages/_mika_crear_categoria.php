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
$parent_id = 0;
if(isset($_GET["parent_id"])){
    $parent_id = $_GET["parent_id"];
}

//$res = $admin->arbol_categoria();
$list = $admin->con->sql("SELECT * FROM _mika_categorias WHERE id_page='".$_SESSION['user']['info']['id_page']."'");

$titulo = "Categorias";
$titulo_list = "Lista de Categorias";
$sub_titulo1 = "Ingresar Categoria";
$sub_titulo2 = "Modificar Categoria";
$accion = "crearcategoria";

$eliminaraccion = "eliminarcategoria";
$id_list = "id_cat";
$eliminarobjeto = "Categoria";
$page_mod = "pages/crear_categoria.php";
/* CONFIG PAGE */

$id = 0;
$sub_titulo = $sub_titulo1;
if(isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] != 0){
    
    $sub_titulo = $sub_titulo2;
    $that = $admin->get_categoria($_GET["id"]);
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
            
            var send = {accion: 'ordercat', values: order};
            console.log(order);
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
                    <input id="parent_id" type="hidden" value="<?php echo $parent_id; ?>" />
                    <input id="accion" type="hidden" value="<?php echo $accion; ?>" />
                    <label>
                        <span>Nombre:</span>
                        <input id="nombre" type="text" value="<?php echo $that['nombre']; ?>" require="" placeholder="Electro" />
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
                    $prods = $list[$i]['prods'];
                ?>
                
                <li class="user" rel="<?php echo $id; ?>">
                    <ul class="clearfix">
                        <li class="nombre"><?php echo $nombre; ?></li>
                        <a title="Eliminar" class="icn borrar" onclick="eliminar('<?php echo $eliminaraccion; ?>', <?php echo $id; ?>, '<?php echo $eliminarobjeto; ?>', '<?php echo $nombre; ?>')"></a>
                        <a title="Modificar" class="icn modificar" onclick="navlink('<?php echo $page_mod; ?>?id=<?php echo $id; ?>&parent_id=<?php echo $parent_id; ?>')"></a>
                        <?php if($prods == 0){ ?>
                        <a title="SubCategorias" class="icn database" onclick="navlink('<?php echo $page_mod; ?>?parent_id=<?php echo $id; ?>')"></a>
                        <?php }else{ ?>
                        <a title="Ver Productos" class="icn prods" onclick="navlink('pages/ver_productos.php?id_cat=<?php echo $id; ?>')"></a>
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