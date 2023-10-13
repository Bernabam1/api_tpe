<?php
require_once './app/controllers/producto.controller.php';
require_once './app/controllers/about.controller.php';
require_once './app/controllers/auth.controller.php';
require_once './app/controllers/categoria.controller.php';

define('BASE_URL', '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']).'/');

$action = 'productos'; // accion por defecto despues tendria q ser categorias
if (!empty( $_GET['action'])) {
    $action = $_GET['action'];
}


// productos        ->      getProductos();
// agregar          ->      addProducto();
// eliminar/:ID     ->      removeProducto($id);
// modificar/:ID    ->      modificarProducto($id);

// about ->             aboutController->showAbout();
// login ->             authContoller->showLogin();
// logout ->            authContoller->logout();
// auth                 authContoller->auth(); // toma los datos del post y autentica al usuario



// parsea la accion para separar accion real de parametros
$params = explode('/', $action);

switch ($params[0]) {
    case 'productos':
        $controller = new ProductoController();
        $controller -> showProductos();
        break;   
    case 'agregar':
        $controller = new ProductoController();
        $controller -> addProducto();
        break;    
    case 'eliminar':
        $controller = new ProductoController();
        $controller -> removeProducto($params[1]); // Del explode trae el ID
        break;
    case 'modificar':
        $controller = new ProductoController();
        $controller -> modificarProducto($params[1]); // El param en la pos 1 es el id del producto
        break;  
    case 'categorias':
        $controller = new CategoriaController();
        $controller -> showCategorias();
        break; 
    // Como hago el eliminar para categorias??    
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
        // esto lo tengo q cambiar
        echo "404 Page Not Found";
        break;
}
