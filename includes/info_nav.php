<?php
    
    $page = $_SESSION['user']['info']['id_page'];
    
    if($page == 2){
        $array[0]["nombre"] = "Categorias";
        $array[0]["link"] = "pages/_mika_crear_categoria.php";
    }
    if($page == 2){
        $array[1]["nombre"] = "Promos";
        $array[1]["link"] = "pages/_mika_crear_promos.php";
    }
    
    if(isset($array)){
        
        $aux["ico"] = 5;
        $aux["categoria"] = "Productos";
        $aux["show"] = true;
        $aux["subcategoria"] = $array;
        $menu[] = $aux;
        unset($aux);
        unset($array);
        
    }
    
    if($page == 1){
        $array[0]["nombre"] = "Alumnos";
        $array[0]["link"] = "pages/_jardinva_info_alumnos.php";
    }
    if($page == 1){
        $array[1]["nombre"] = "Cursos";
        $array[1]["link"] = "pages/_jardinva_crear_cursos.php";
    }
    if($page == 1){
        $array[2]["nombre"] = "Boletas";
        $array[2]["link"] = "pages/_jardinva_crear_boletas.php";
    }
    
    if(isset($array)){
        
        $aux["ico"] = 4;
        $aux["categoria"] = "Informacion";
        $aux["subcategoria"] = $array;
        $menu[] = $aux;
        unset($aux);
        unset($array);
        
    }
    
    if($page == 1){
        $array[0]["nombre"] = "Tour Virtual";
        $array[0]["link"] = "pages/_jardinva_tour_virtual.php";
    }
    
    if(isset($array)){
    
        $aux["ico"] = 3;
        $aux["categoria"] = "Configuracion";
        $aux["subcategoria"] = $array;
        $menu[] = $aux;
        unset($aux);
        unset($array);
        
    }
        
    if($page == 3){
        $array[0]["nombre"] = "Ingresar Propiedades";
        $array[0]["link"] = "pages/_javiermo_crear_propiedad.php";
    }
    
    if(isset($array)){
    
        $aux["ico"] = 3;
        $aux["categoria"] = "Propiedades";
        $aux["subcategoria"] = $array;
        $menu[] = $aux;
        unset($aux);
        unset($array);
        
    }
    
    if($page == 4){
        $array[0]["nombre"] = "Categorias";
        $array[0]["link"] = "pages/_mika_crear_categoria.php";
    }
    if($page == 4){
        $array[1]["nombre"] = "Ingredientes";
        $array[1]["link"] = "pages/_mika_crear_ingredientes.php";
    }
    if($page == 4){
        $array[2]["nombre"] = "Promociones";
        $array[2]["link"] = "pages/_mika_crear_promos.php";
    }
    
    if(isset($array)){
    
        $aux["ico"] = 3;
        $aux["categoria"] = "Productos";
        $aux["subcategoria"] = $array;
        $menu[] = $aux;
        unset($aux);
        unset($array);
        
    }
    

?>