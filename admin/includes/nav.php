<?php

    $aux['ico'] = 1;
    $aux['categoria'] = "Configuracion Cia";
    
    $aux['subcategoria'][0]['nombre'] = "Perfiles";
    $aux['subcategoria'][0]['link'] = "pages/perfiles_cia.php";
    $aux['subcategoria'][1]['nombre'] = "Cargos";
    $aux['subcategoria'][1]['link'] = "pages/cargos_cia.php";
    $aux['subcategoria'][2]['nombre'] = "Usuarios";
    $aux['subcategoria'][2]['link'] = "pages/usuarios_cia.php";
    $aux['subcategoria'][3]['nombre'] = "Configuracion";
    $aux['subcategoria'][3]['link'] = "pages/config_cia.php";
    $aux['subcategoria'][4]['nombre'] = "Tipos de Claves";
    $aux['subcategoria'][4]['link'] = "pages/tipos_de_claves_cia.php";
    $aux['subcategoria'][5]['nombre'] = "Grupos Asistentes";
    $aux['subcategoria'][5]['link'] = "pages/grupos_cia.php";
    
    $menu[] = $aux;
    $aux = null;
    
    
    $aux['ico'] = 3;
    $aux['categoria'] = "Configuracion Cuerpo";
    $aux['subcategoria'][3]['nombre'] = "Configuracion";
    $aux['subcategoria'][3]['link'] = "pages/config_cue.php";
    $aux['subcategoria'][0]['nombre'] = "Perfiles";
    $aux['subcategoria'][0]['link'] = "pages/perfiles_cue.php";
    $aux['subcategoria'][2]['nombre'] = "Usuarios";
    $aux['subcategoria'][2]['link'] = "pages/usuarios_cue.php";
    $aux['subcategoria'][1]['nombre'] = "Cargos";
    $aux['subcategoria'][1]['link'] = "pages/cargos_cue.php";
    $aux['subcategoria'][4]['nombre'] = "Compañias";
    $aux['subcategoria'][4]['link'] = "pages/crear_cias.php";
    $aux['subcategoria'][5]['nombre'] = "Tipos de Maquina";
    $aux['subcategoria'][5]['link'] = "pages/tipos_de_maquina.php";
    $aux['subcategoria'][6]['nombre'] = "Tipos de Claves";
    $aux['subcategoria'][6]['link'] = "pages/tipos_de_claves_cue.php";
    $aux['subcategoria'][7]['nombre'] = "Grupos Asistentes";
    $aux['subcategoria'][7]['link'] = "pages/grupos_cue.php";
    $menu[] = $aux;
    $aux = null;

    
    $aux['ico'] = 4;
    $aux['categoria'] = "Despacho";
    $aux['subcategoria'][0]['nombre'] = "Nuevo Despacho";
    $aux['subcategoria'][0]['link'] = "pages/despacho.php";
    $menu[] = $aux;
    $aux = null;


    $aux['ico'] = 2;
    $aux['categoria'] = "Super Admin";
    $aux['subcategoria'][0]['nombre'] = "Crear Cuerpo de Bomberos";
    $aux['subcategoria'][0]['link'] = "pages/crear_cuerpo.php";
    $menu[] = $aux;
    $aux = null;


?>
<div class="nav">
    <input id="navw" type="hidden" value="1" />
    <ul class="navlist">
        <?php for($i=0; $i<count($menu); $i++){ ?>
        <li class="lt">
            <div class="ti clearfix" id="menu-<?php echo $i; ?>">
                <div class="icon ico<?php echo $menu[$i]['ico']; ?>"></div>
                <div class="title"><?php echo $menu[$i]['categoria']; ?></div>
                <!--<div class="rows">13</div>-->
            </div>
            <ul>
                <?php for($j=0; $j<count($menu[$i]['subcategoria']); $j++){ ?>
                <li><a class='navlink' onClick="navlink('<?php echo $menu[$i]['subcategoria'][$j]['link']; ?>')"><?php echo $menu[$i]['subcategoria'][$j]['nombre']; ?></a><!--<p>12</p>--></li>
                <?php } ?>
            </ul>
            <div class="tooltip clearfix">
                <div class="toolrows"></div>
                <div class="toolcont">
                        <?php for($j=0; $j<count($menu[$i]['subcategoria']); $j++){ ?>
                        <div class="nt"><a class='navlink' onClick="navlink('<?php echo $menu[$i]['subcategoria'][$j]['link']; ?>')"><?php echo $menu[$i]['subcategoria'][$j]['nombre']; ?></a><!--<p>13</p>--></div>
                        <?php } ?>
                </div>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>