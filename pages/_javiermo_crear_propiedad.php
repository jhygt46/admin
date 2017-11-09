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

$titulo = "Propiedades";
$titulo_list = "Lista de Propiedades";
$sub_titulo1 = "Ingresar Propiedad";
$sub_titulo2 = "Modificar Propiedad";
$accion = "_javiermo_crear_propiedad";

$eliminaraccion = "_javiermo_eliminar_propiedad";
$id_list = "id_pro";
$eliminarobjeto = "Propiedad";
$page_mod = "pages/_javiermo_crear_propiedad.php";

$page_pic = "pages/asignar_imagen.php?db=propiedades";
/* CONFIG PAGE */

$list = $admin->get_propiedades();

$id = 0;
$sub_titulo = $sub_titulo1;
if(isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] != 0){
    
    $sub_titulo = $sub_titulo2;
    $that = $admin->get_propiedad($_GET["id"]);
    $id = $_GET["id"];
    
}


?>

<script>
    
    var map;    
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -34.397, lng: 150.644},
            zoom: 8
        });
    }
    $('#dirmapa').keyup(function(){
        $('#map').show();
    });
    $('.listUser').sortable({
        stop: function(e, ui){
            var order = [];
            $(this).find('.user').each(function(){
                order.push($(this).attr('rel'));
            });
            var send = {accion: 'order', values: order, tabla: '_propiedades', id: 'id_pro'};
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
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbKlHezhqgy7z57ipcJk8mDK4rf6drvjY&libraries=places" async defer></script>

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
                        <input id="nombre" type="text" value="<?php echo $that['nombre']; ?>" require="" placeholder="Electro" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Tipo:</span>
                        <select id="tipo">
                            <option value="0">Seleccionar</option>
                            <option value="1" <?php if($that['tipo'] == 1){ echo "selected"; }?>>Arriendo</option>
                            <option value="2" <?php if($that['tipo'] == 2){ echo "selected"; }?>>Venta</option>
                        </select>
                    </label>
                    <label>
                        <span>Naturaleza:</span>
                        <select id="naturaleza">
                            <option value="0">Seleccionar</option>
                            <option value="1" <?php if($that['naturaleza'] == 1){ echo "selected"; }?>>Casas</option>
                            <option value="2" <?php if($that['naturaleza'] == 2){ echo "selected"; }?>>Departamentos</option>
                            <option value="3" <?php if($that['naturaleza'] == 3){ echo "selected"; }?>>Oficinas</option>
                            <option value="4" <?php if($that['naturaleza'] == 4){ echo "selected"; }?>>Industriales</option>
                            <option value="5" <?php if($that['naturaleza'] == 5){ echo "selected"; }?>>Comerciales</option>
                        </select>
                    </label>
                    <label>
                        <span>Precio normal:</span>
                        <input id="precio_normal" type="text" value="<?php echo $that['precio_normal']; ?>" require="" placeholder="140.000.000" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Precio UF:</span>
                        <input id="precio_uf" type="text" value="<?php echo $that['precio_uf']; ?>" require="" placeholder="5500" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Direccion:</span>
                        <input id="direccion" type="text" value="<?php echo $that['direccion']; ?>" require="" placeholder="Jose Tomas Rider 1185, Providencia" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Mapa:</span>
                        <input id="dirmapa" type="text" value="<?php echo $that['direccion']; ?>" require="" placeholder="Jose Tomas Rider 1185, Providencia" />
                        <div class="mensaje"></div>
                    </label>
                    <div id="map" style="height: 400px; display: none;"></div>
                    <label>
                        <span>Superficie &uacute;til:</span>
                        <input id="supercifie_util" type="text" value="<?php echo $that['supercifie_util']; ?>" require="" placeholder="60" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Superficie total:</span>
                        <input id="supercifie_total" type="text" value="<?php echo $that['supercifie_total']; ?>" require="" placeholder="65" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Dormitorios:</span>
                        <input id="dormitorios" type="text" value="<?php echo $that['dormitorios']; ?>" require="" placeholder="3" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Ba&ntilde;os:</span>
                        <input id="banos" type="text" value="<?php echo $that['banos']; ?>" require="" placeholder="2" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Cocina:</span>
                        <input id="cocina" type="text" value="<?php echo $that['cocina']; ?>" require="" placeholder="Equipada" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Codigo:</span>
                        <input id="codigo" type="text" value="<?php echo $that['codigo']; ?>" require="" placeholder="003" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Descripcion:</span>
                        <textarea id="descripcion"><?php echo $that['descripcion']; ?></textarea>
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
                        <a title="Fotos" class="icn fotos" onclick="navlink('<?php echo $page_pic; ?>&id=<?php echo $id; ?>')"></a>
                    </ul>
                </li>
                
                <?php } ?>
                
            </ul>
            
        </div>
    </div>
</div>
<br />
<br />