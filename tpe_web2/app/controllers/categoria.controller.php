<?php
require_once './app/models/categoria.model.php';
require_once './app/views/categoria.view.php';

class CategoriaController {
    private $model;
    private $view;

    public function __construct() {
        $this->model = new CategoriaModel();
        $this->view = new CategoriaView();
    }

    public function showCategorias(){
        //le pido las categorias al controller

        $categorias = $this->model->getCategorias();

        // muestro las categorias que vienen pero desde la vista

        $this->view->showCategorias($categorias);
    }

    public function addCategoria(){
        // Falta validacion isset?

        // Agarro lo que viene del form y lo guardo en variables
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $imagen = $_POST['img'];
        
        // Inserto

        $id = $this->model->insertCategoria($nombre, $descripcion, $imagen);

        if ($id){ // Si es cero se va por el false
            header('Location: ' . BASE_URL . 'categorias'); // Esto hace redireccion a la BASE_URL q esta como constante apuntando al home
        } else {
            echo "Error al ingresar el producto"; // ojo con esto, lo tengo q cambiar
        }
    }

    public function removeCategoria($id){
        $this->model->deleteCategoria($id);
        header('Location: ' . BASE_URL . 'categorias');
    }

    public function modificarCategoria($id){

        $categoria = $this->model->getCategoriaById($id); // Me quedo con EL objeto

        $this->view->showModificarCategoria($categoria);

        if(isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $img = $_POST['img'];

            $this->model->updateCategoria($id, $nombre, $descripcion, $img);
            //header('Location: ' . BASE_URL); No puedo volver a la pagina porque esto rompe. Modifica bien pero rompe esto
        }
    }

}