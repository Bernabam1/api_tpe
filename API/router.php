<?php
require_once 'libs/Router.php';
require_once 'app/controllers/prod.api.controller.php';

$router = new Router();

// Endpoint - Verbo - Controller - Método HTTP
$router -> addRoute('productos', 'GET', 'ProdApiController', 'get');
$router -> addRoute('productos/:ID', 'GET', 'ProdApiController', 'get');
$router -> addRoute('productos', 'POST', 'ProdApiController', 'addProducto');
$router -> addRoute('productos/:ID', 'PUT', 'ProdApiController', 'updateProducto');
$router -> addRoute('productos/:ID', 'DELETE', 'ProdApiController', 'deleteProducto');

$router -> route($_GET['resource'], $_SERVER['REQUEST_METHOD']); //Le paso el resource como esta en el htacces