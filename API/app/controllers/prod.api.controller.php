<?php
    require_once 'app/controllers/api.controller.php';
    require_once 'app/models/producto.model.php';

    class ProdApiController extends ApiController{
        private $model;

        function __construct(){
            parent::__construct();
            $this->model = new ProductoModel();
            $this->view = new APIview();
        }

        function get($params = []){
            if(empty($params)){

                $productos = $this->model->getProductos();
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