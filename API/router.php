<?php
require_once 'libs/Router.php';
require_once 'app/controllers/prod.api.controller.php';
require_once 'app/controllers/cat.api.controller.php';
require_once 'app/controllers/user.api.controller.php';

$router = new Router();


// Router productos
// Endpoint - Verbo - Controller - Método HTTP
$router -> addRoute('productos', 'GET', 'ProdApiController', 'get');
$router -> addRoute('productos/:ID', 'GET', 'ProdApiController', 'get');
$router -> addRoute('productos', 'POST', 'ProdApiController', 'addProducto');
$router -> addRoute('productos/:ID', 'PUT', 'ProdApiController', 'updateProducto');
$router -> addRoute('productos/:ID', 'DELETE', 'ProdApiController', 'deleteProducto');

// Router categorias
$router -> addRoute('categorias', 'GET', 'CatApiController', 'get');
$router -> addRoute('categorias/:ID', 'GET', 'CatApiController', 'get');
$router -> addRoute('categorias', 'POST', 'CatApiController', 'addCategoria');
$router -> addRoute('categorias/:ID', 'PUT', 'CatApiController', 'updateCategoria');
$router -> addRoute('categorias/:ID', 'DELETE', 'CatApiController', 'deleteCategoria');

// Router productos por categoria
$router->addRoute('productos/categorias/:ID', 'GET', 'ProdApiController', 'getProductosByCategoria');

// Router usuarios
$router -> addRoute('user/token', 'GET', 'UserApiController', 'getToken');

$router -> route($_GET['resource'], $_SERVER['REQUEST_METHOD']); //Le paso el resource como esta en el htacces