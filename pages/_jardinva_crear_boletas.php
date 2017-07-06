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
$parent_id = 0;
if(isset($_GET["parent_id"])){
    $parent_id = $_GET["parent_id"];
}

$mes = $_GET['mes'];
if($mes == ""){
    $mes = date("m");
}
$año = $_GET['ano'];
if($año == ""){
    $año = date("Y");
}
$cant_dias = cal_days_in_month(CAL_GREGORIAN, $mes, $año);

$db_var_name = "_jardinva";
$list_ = $admin->con->sql("SELECT * FROM ".$db_var_name."_boletas WHERE ano='".$año."' AND mes='".$mes."'");
$list = $list_['resultado'];

$max_boleta_ = $admin->con->sql("SELECT MAX(numero) as max FROM ".$db_var_name."_boletas WHERE tipo='1'");
$max_factura_ = $admin->con->sql("SELECT MAX(numero) as max FROM ".$db_var_name."_boletas WHERE tipo='2'");

$max_boleta = $max_boleta_['resultado'][0]['max'] + 1;
$max_factura = $max_factura_['resultado'][0]['max'] + 1;

$titulo = "Boletas y Facturas";
$titulo_list = "Listado de Boletas y Facturas";
$sub_titulo1 = "Ingresar";
$sub_titulo2 = "Modificar";
$accion = "_jardinva_crearboleta";

$eliminaraccion = "_jardinva_eliminarboleta";
$id_list = "id_bol";
$eliminarobjeto = "Boleta/Factura";
$page_mod = "pages/_jardinva_crear_boletas.php";


/* CONFIG PAGE */

$id = 0;
$sub_titulo = $sub_titulo1;
if(isset($_GET["id"]) && is_numeric($_GET["id"]) && $_GET["id"] != 0){
    
    $sub_titulo = $sub_titulo2;
    $that = $admin->con->sql("SELECT * FROM ".$db_var_name."_boleta WHERE id_bol='".$_GET["id"]."'");
    $id = $_GET["id"];
    
}


?>

<script>
    $("#mes").change(function (){
        var año = $("#año option:selected").val();
        var mes = $("#mes option:selected").val();
        navlink('pages/_jardinva_crear_boletas.php?ano='+año+'&mes='+mes);
    });
    $("#año").change(function (){
        var año = $("#año option:selected").val();
        var mes = $("#mes option:selected").val();
        navlink('pages/_jardinva_crear_boletas.php?ano='+año+'&mes='+mes);
    });
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
                        <span>Año:</span>
                        <select id="año">
                            <?php $desde = date("Y") - 5; for($i=$desde; $i<=date("Y")+1; $i++){ ?>
                            <option value="<?php echo $i; ?>" <?php if($i == $año){ echo "selected"; } ?>><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Mes:</span>
                        <select id="mes">
                            <option value="1" <?php if($mes == 1){ echo "selected"; } ?>>Enero</option>
                            <option value="2" <?php if($mes == 2){ echo "selected"; } ?>>Febrero</option>
                            <option value="3" <?php if($mes == 3){ echo "selected"; } ?>>Marzo</option>
                            <option value="4" <?php if($mes == 4){ echo "selected"; } ?>>Abril</option>
                            <option value="5" <?php if($mes == 5){ echo "selected"; } ?>>Mayo</option>
                            <option value="6" <?php if($mes == 6){ echo "selected"; } ?>>Junio</option>
                            <option value="7" <?php if($mes == 7){ echo "selected"; } ?>>Julio</option>
                            <option value="8" <?php if($mes == 8){ echo "selected"; } ?>>Agosto</option>
                            <option value="9" <?php if($mes == 9){ echo "selected"; } ?>>Septiembre</option>
                            <option value="10" <?php if($mes == 10){ echo "selected"; } ?>>Octubre</option>
                            <option value="11" <?php if($mes == 11){ echo "selected"; } ?>>Noviembre</option>
                            <option value="12" <?php if($mes == 12){ echo "selected"; } ?>>Diciembre</option>
                        </select>
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Dia:</span>
                        <select id="dia">
                            <?php for($i=1; $i<=$cant_dias; $i++){ ?>
                            <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                        </select>
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Tipo:</span>
                        <input name="tipo1" id="tipo1" type="radio" value="1" checked="checked" /> Boleta
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span></span>
                        <input name="tipo1" id="tipo1" type="radio" value="2" /> Factura
                        <div class="mensaje"></div>
                    </label>
                    <label class="nboleta">
                        <span>Numero Boleta:</span>
                        <input id="nboleta" type="text" value="<?php echo $max_boleta; ?>" />
                        <div class="mensaje"></div>
                    </label>
                    <label class="nfactura">
                        <span>Numero Factura:</span>
                        <input id="nfactura" type="text" value="<?php echo $max_factura; ?>" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Matricula:</span>
                        <input id="matricula" type="text" value="<?php echo $that['resultado'][0]['matricula']; ?>" require="" placeholder="Electro" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Mensualidad Jardin:</span>
                        <input id="jardin" type="text" value="<?php echo $that['resultado'][0]['jardin']; ?>" require="" placeholder="Electro" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Mensualidad Sala Cuna:</span>
                        <input id="salacuna" type="text" value="<?php echo $that['resultado'][0]['salacuna']; ?>" require="" placeholder="Electro" />
                        <div class="mensaje"></div>
                    </label>
                    <label>
                        <span>Nula:</span>
                        <input id="nula" type="checkbox" value="1" <?php if($that['resultado'][0]['nula'] == 1){ echo "checked='checked'";} ?> />
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
                        <a title="Modificar" class="icn modificar" onclick="navlink('<?php echo $page_mod; ?>?id=<?php echo $id; ?>')"></a>
                        <a title="Asistencia" class="icn prods" onclick="navlink('<?php echo $page_mod; ?>?id=<?php echo $id; ?>')"></a>
                    </ul>
                </li>
                
                <?php } ?>
                
            </ul>
            
        </div>
    </div>
</div>
<br />
<br />