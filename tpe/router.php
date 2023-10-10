<?php

require_once 'app/productos.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$action = 'productos'; // accion por defecto
if (!empty( $_GET['action'])) {
    $action = $_GET['action'];
}


// productos        ->      getProductos();
// agregar          ->      addProducto();
// eliminar/:ID     ->      removeProducto($id);
// modificar/:ID    ->      modificarProducto($id);


// parsea la accion para separar accion real de parametros
$params = explode('/', $action);

switch ($params[0]) {
    case 'productos':
        mostrarProductos();
        break;   
    case 'agregar':
        addProducto();
        break;    
    case 'eliminar':
        removeProducto($params[1]); // Del explode trae el ID
        break;  
    case 'modificar':
        modificarProducto($params[1]); // Como hago andar esta
        break;  
    default: 
        echo "404 Page Not Found";
        break;
}
