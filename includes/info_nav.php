<?php
    


    // PAGE 1 //
    $aux["ico"] = 4;
    $aux["categoria"] = "Informacion";
    $aux["subcategoria"][0]["nombre"] = "Alumnos";
    $aux["subcategoria"][0]["link"] = "pages/_jardinva_info_alumnos.php";
    $aux["subcategoria"][1]["nombre"] = "Cursos";
    $aux["subcategoria"][1]["link"] = "pages/_jardinva_crear_cursos.php";
    $aux["subcategoria"][2]["nombre"] = "Boletas";
    $aux["subcategoria"][2]["link"] = "pages/_jardinva_crear_boletas.php";
    $menu[] = $aux;
    unset($aux);
    // PAGE 1 //
    
    // PAGE 1 //
    $aux["ico"] = 3;
    $aux["categoria"] = "Configuracion";
    $aux["subcategoria"][0]["nombre"] = "Tour Virtual";
    $aux["subcategoria"][0]["link"] = "pages/_jardinva_tour_virtual.php";
    $menu[] = $aux;
    unset($aux);
    // PAGE 1 //
    
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