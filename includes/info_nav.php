<?php

$aux["ico"] = 4;
$aux["categoria"] = "Productos";
$aux["subcategoria"][0]["nombre"] = "Ingresar Categorias";
$aux["subcategoria"][0]["link"] = "pages/crear_categoria.php";
$aux["subcategoria"][1]["nombre"] = "Ingresar Productos";
$aux["subcategoria"][1]["link"] = "pages/crear_producto.php";
$menu[] = $aux; 
unset($aux);

$aux["ico"] = 2;
$aux["categoria"] = "Usuarios";
$aux["subcategoria"][0]["nombre"] = "Ingresar Usuarios";
$aux["subcategoria"][0]["link"] = "pages/crear_usuario.php";
$aux["subcategoria"][1]["nombre"] = "Ingresar Perfiles";
$aux["subcategoria"][1]["link"] = "pages/crear_perfil.php";
$menu[] = $aux;
unset($aux);

$aux["ico"] = 1;
$aux["categoria"] = "Configuracion";
$aux["subcategoria"][0]["nombre"] = "Configuracion";
$aux["subcategoria"][0]["link"] = "pages/configuracion.php";
$menu[] = $aux;
unset($aux);

?>