<?php
require_once './app/controllers/producto.controller.php';
require_once './app/controllers/about.controller.php';
require_once './app/controllers/auth.controller.php';
require_once './app/controllers/categoria.controller.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$action = 'productos';
if (!empty( $_GET['action'])) {
    $action = $_GET['action'];
}

$params = explode('/', $action);

switch ($params[0]) {
    case 'productos':
        $controller = new ProductoController();
        $controller -> showProductos();
        break;
    case 'agregarProducto':
        $controller = new ProductoController();
        $controller -> addProducto();
        break;
    case 'verProducto':
        $controller = new ProductoController();
        $controller -> verProducto($params[1]); // Del explode trae el ID
        break;
    case 'eliminarProducto':
        $controller = new ProductoController();
        $controller -> removeProducto($params[1]); // Del explode trae el ID
        break;
    case 'modificarProducto':
        $controller = new ProductoController();
        $controller -> modificarProducto($params[1]); // El param en la pos 1 es el id del producto
        break;
    case 'categorias':
        $controller = new CategoriaController();
        $controller -> showCategorias();
        break;
    case 'agregarCategoria':
        $controller = new CategoriaController();
        $controller -> addCategoria();
        break;
    case 'verCategoria':
        $controller = new CategoriaController();
        $controller -> verCategoria($params[1]);
        break;
    case 'eliminarCategoria':
        $controller = new CategoriaController();
        $controller -> removeCategoria($params[1]);
        break;
    case 'modificarCategoria':
        $controller = new CategoriaController();
        $controller -> modificarCategoria($params[1]);
        break;
    case 'about':
        $controller = new AboutController();
        $controller->showAbout();
        break;
    case 'login':
        $controller = new AuthController();
        $controller->showLogin(); 
        break;
    case 'auth':
        $controller = new AuthController();
        $controller->auth();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    default: 
        echo "404 Page Not Found";
        break;
}
