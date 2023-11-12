<?php
    require_once 'app/controllers/api.controller.php';
    require_once 'app/models/producto.model.php';
    require_once 'app/helpers/auth.api.helper.php';

    class ProdApiController extends ApiController{
        private $model;
        private $authHelper;

        function __construct(){
            parent::__construct();
            $this->model = new ProductoModel();
            $this->authHelper = new AuthHelper();
        }

        function get($params = []){
            
            if(empty($params)){

                // Sorting
                $permitidos = ['id_producto', 'nombre', 'id_categoria', 'precio', 'stock', 'imagen']; // Los campos permitidos para ordenamiento

                $sortField = isset($_GET['sort']) ? $_GET['sort'] : 'id_producto'; // Toma lo que esta en el sort o el predeterminado
                $sortOrder = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC'; // Si esta seteado y es descendente -> desc, sino ascendente por defecto

                if (!in_array($sortField, $permitidos)) { // Si lo que hay no se corresponde con un campo permitido corto acá
                    return $this->view->response("Bad Request", 400);
                }

                //Paginación
                $page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Toma los valores de la URL y los pasa a numero, si no se proporciona pone 1
                $perPage = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10; // Toma los valores de la URL y los pasa a numero, si no se proporciona pone 10

                $productos = $this->model->getProductos($sortField, $sortOrder, $page, $perPage); // Le agrego al get los sorts y la paginacion
                return $this->view->response($productos, 200);
            }
            else{
                $producto = $this->model->getProductoById($params [":ID"]);
                if (!empty($producto)){
                    return $this->view->response($producto, 200);
                }
                else{
                    return $this->view->response("Producto no encontrado", 404);
                }
            }
        }

        function deleteProducto($params = []){
            $user = $this->authHelper->currentUser();
            if(!$user){
                $this->view->response('Unauthorized', 401);
                return;
            }

            $producto_id = $params[':ID'];
            $producto = $this->model->getProductoById($producto_id);
    
            if ($producto) {
                $this->model->deleteProducto($producto_id);
                $this->view->response("Producto id=$producto_id eliminado con éxito", 200);
            }
            else 
                $this->view->response("Producto id=$producto_id no encontrado", 404);
        }

        function addProducto($params = []){
            $user = $this->authHelper->currentUser();
            if(!$user){
                $this->view->response('Unauthorized', 401);
                return;
            }

            $body = $this->getData(); // Desarma el json y genera un objeto

            $nombre = $body->nombre;
            $id_categoria = $body->id_categoria;
            $precio = $body->precio;
            $stock = $body->stock;
            $imagen = $body->imagen;

            $id = $this->model->insertProducto($nombre, $id_categoria, $precio, $stock, $imagen);

            $this->view->response('El producto se insertó con id=' . $id, 201);
        }
        
        function updateProducto($params = []){
            $user = $this->authHelper->currentUser();
            if(!$user){
                $this->view->response('Unauthorized', 401);
                return;
            }

            $producto_id = $params[':ID']; // Capturo el id
            $producto = $this->model->getProductoById($producto_id); 
    
            if ($producto) { // Me fijo q exista el producto
                $body = $this->getData(); // Desarma el json y genera un objeto

                $nombre = $body->nombre;
                $id_categoria = $body->id_categoria;
                $precio = $body->precio;
                $stock = $body->stock;
                $imagen = $body->imagen;

                $this->model->updateProducto($producto_id, $nombre, $id_categoria, $precio, $stock, $imagen,); // Si existe, agarro toda la info y actualizo

                $this->view->response("Producto id=$producto_id se modificó con éxito", 200);
            }
            else 
                $this->view->response("Producto id=$producto_id no encontrado", 404); // Si no existe
        }

        function getProductosByCategoria($params = []) {
            $categoria_id = $params[':ID'];

            $productos = $this->model->getProductosByCategoria($categoria_id);
        
            if (!empty($productos)) {
                return $this->view->response($productos, 200);
            } else {
                return $this->view->response("No se encontraron productos en la categoría $categoria_id", 404);
            }
        }

    }