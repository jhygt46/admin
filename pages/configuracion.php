<?php
// TODOS LOS ARCHIVOS EN PAGES//
session_start();
if(!isset($_SESSION['user']['info']['id_user'])){
    exit;
}
$path = $_SERVER['DOCUMENT_ROOT'];
if($_SERVER['HTTP_HOST'] == "localhost"){
    $path .= "/";
}
$path_ = $path."admin/class";
require_once($path_."/admin.php");
// TODOS LOS ARCHIVOS EN PAGES//

$admin = new Admin();
$admin->seguridad(1);
$that = $admin->get_config();

/* CONFIG PAGE */
$titulo = "Configuracion";
$sub_titulo = "Modificar Configuracion";
$accion = "configuracion";
/* CONFIG PAGE */

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
                        <span>Titulo:</span>
                        <input id="nombre" type="text" value="<?php echo $that["titulo"]; ?>" require="" placeholder="Super 8" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Subtitulo:</span>
                        <input id="descripcion" type="text" value="<?php echo $that["subtitulo"]; ?>" require="" placeholder="Oblea bañada en chocolate" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Tema:</span>
                        <select id="precio">
                            <option value="1" <?php if($that["tema"] == 1){ echo "selected"; } ?>>Tema 1</option>
                            <option value="2" <?php if($that["tema"] == 2){ echo "selected"; } ?>>Tema 2</option>
                            <option value="3" <?php if($that["tema"] == 3){ echo "selected"; } ?>>Tema 3</option>
                            <option value="4" <?php if($that["tema"] == 4){ echo "selected"; } ?>>Tema 4</option>
                        </select>
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Perfiles:</span>
                        <input id="perfiles" type="checkbox" value="1" <?php if($that["perfiles"] == 1){ echo "checked"; } ?> />
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