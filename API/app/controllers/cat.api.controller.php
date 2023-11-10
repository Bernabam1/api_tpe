<?php
    require_once 'app/controllers/api.controller.php';
    require_once 'app/models/categoria.model.php';

    class CatApiController extends ApiController{
        private $model;

        function __construct(){
            parent::__construct();
            $this->model = new CategoriaModel();
            $this->view = new APIview();
        }

        function get($params = []){
            if(empty($params)){

                if(isset($_GET))

                $categorias = $this->model->getCategorias();
                return $this->view->response($categorias, 200);
            }
            else{
                $categoria = $this->model->getCategoriaById($params [":ID"]);
                if (!empty($categoria)){
                    return $this->view->response($categoria, 200);
                }
                else{
                    return $this->view->response("Categoria no encontrada", 404);
                }
            }
        }

        function deleteCategoria($params = []){
            $categoria_id = $params[':ID'];
            $categoria = $this->model->getCategoriaById($categoria_id);
    
            if ($categoria) {
                $this->model->deleteCategoria($categoria_id);
                $this->view->response("Categoria id=$categoria_id eliminada con éxito", 200);
            }
            else 
                $this->view->response("Categoria id=$categoria_id no encontrada", 404);
        }

        function addCategoria($params = []){
            $body = $this->getData(); // Desarma el json y genera un objeto

            $nombre = $body->nombre;
            $descripcion = $body->descripcion;
            $imagen = $body->imagen;

            $id = $this->model->insertCategoria($nombre, $descripcion, $imagen);

            $this->view->response('La categoria se insertó con id=' . $id, 201);
        }
        
        function updateCategoria($params = []){
            $categoria_id = $params[':ID']; // Capturo el id
            $categoria = $this->model->getCategoriaById($categoria_id); 
    
            if ($categoria) { // Me fijo q exista
                $body = $this->getData(); // Desarma el json y genera un objeto

                $nombre = $body->nombre;
                $descripcion = $body->descripcion;
                $imagen = $body->imagen;

                $this->model->updateCategoria($categoria_id, $nombre, $descripcion, $imagen); // Si existe, agarro toda la info y actualizo

                $this->view->response("Categoria id=$categoria_id se modificó con éxito", 200);
            }
            else 
                $this->view->response("Categoria id=$categoria_id no encontrada", 404); // Si no existe
        }

    }