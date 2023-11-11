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

            $sortField = isset($_GET['sort']) ? $_GET['sort'] : 'id_producto'; // Toma lo que esta en el sort o el predeterminado
            $sortOrder = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC'; // Si esta seteado y es descendente -> desc, sino ascendente por defecto

            if(empty($params)){

                $productos = $this->model->getProductos($sortField, $sortOrder); // Le agrego al get los sorts
                return $this->view->response($productos, 200);

                //$productos = $this->model->getProductos(); ESTOS SON LOS Q ESTABAN FUNCIONANDO PRE SORT
                //return $this->view->response($productos, 200);
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

    }