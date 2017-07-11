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
//$admin->seguridad(1);

/* CONFIG PAGE */
$titulo = "Asociar";
$sub_titulo = "Seleccione Categoria";
$accion = "guardar_asociar";

/* CONFIG PAGE */

if(isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] != 0){
    
    $id_pro = $_GET["id"];
    $that = $admin->arbol_categoria_html();
    /*
    echo "<pre>";
    print_r($that);
    echo "</pre>";
    */
}


?>
<style>
    .newform{
        display: block;
        margin: 0px 3% 0px 3%;
    }
    .newform .categoria{
        display: block;
        padding: 10px 15px;
    }
    .categoria .oplist{

    }
    .categoria .oplist .inp{
        width: 3%;
        float: left;
    }
    .categoria .oplist .nom{
        float: left;
        padding-top: 8px;
        width: 97%;
    }
    .categoria .oplist .nom .nom_t{
        font-size: 14px;
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
                    
                    <div class="newform">
                        
                        <?php echo $that; ?>
                        
                    </div>
                    <label style='margin-top:20px; padding-left: 3%;'>
                        
                        <a id='button' onclick="form()">Enviar</a>
                    </label>
                </fieldset>
            </form>
            
        </div>
    </div>
</div>