<?php

    
    $aux["ico"] = 2;
    $aux["categoria"] = "Usuarios";
    $aux["subcategoria"][0]["nombre"] = "Ingresar Usuarios";
    $aux["subcategoria"][0]["link"] = "pages/crear_usuario.php";
    
    if($_SESSION['user']['info']['tareas'] == 1){
    
        $aux["subcategoria"][1]["nombre"] = "Ingresar Perfiles";
        $aux["subcategoria"][1]["link"] = "pages/crear_perfil.php";
    
    }
    
    $menu[] = $aux;
    unset($aux);

    


?>