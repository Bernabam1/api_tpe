<?php
    require_once 'app/models/producto.model.php';
    require_once 'app/view/api.view.php';

    class ProdApiController {
        private $view;
        private $model;

        function __construct(){
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
            }
        }

        function deleteProducto($params = []) {
            $producto_id = $params[':ID'];
            $producto = $this->model->getProductoById($producto_id);
    
            if ($producto) {
                $this->model->deleteProducto($producto_id);
                $this->view->response("Producto id=$producto_id eliminado con éxito", 200);
            }
            else 
                $this->view->response("Task id=$producto_id not found", 404);
        }
    
    }