<?php
require_once './app/models/categoria.model.php';
require_once './app/views/categoria.view.php';
require_once './app/models/producto.model.php';

class CategoriaController {
    private $model;
    private $view;
    private $prodModel;

    public function __construct() {
        $this->model = new CategoriaModel();
        $this->view = new CategoriaView();
        $this->prodModel = new ProductoModel();
    }

    public function showCategorias(){
        $isAdmin = AuthHelper::isAdmin();

        //le pido las categorias al controller

        $categorias = $this->model->getCategorias();

        // muestro las categorias que vienen pero desde la vista

        $this->view->showCategorias($categorias, $isAdmin);
    }

    public function verCategoria($id){
        $isAdmin = AuthHelper::isAdmin();

        $categoria = $this->model->getCategoriaById($id);
        $productos = $this->prodModel->getProductos(); 

        if (empty($productos)){
            $this->view->showError('No hay productos en esta categoría', $isAdmin);
        } else{
            $this->view->showCategoria($id, $categoria, $productos, $isAdmin);
        }
    }

    public function addCategoria(){
        $isAdmin = AuthHelper::isAdmin();

        // Agarro lo que viene del form y lo guardo en variables
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $imagen = $_POST['img'];
        
        // Inserto

        $id = $this->model->insertCategoria($nombre, $descripcion, $imagen);

        if ($id){ // Si es cero se va por el false
            header('Location: ' . BASE_URL . 'categorias'); // Esto hace redireccion a la BASE_URL q esta como constante apuntando al home
        } else {
            $this->view->showError('Error al ingresar el producto', $isAdmin);
        }
    }

    public function removeCategoria($id){
        
        $isAdmin = AuthHelper::isAdmin();

        $tieneProductos = $this->model->deleteCategoria($id);

        if ($tieneProductos === 1) {
            $this->view->showError('La categoría tiene productos, eliminelos antes de eliminarla', $isAdmin);
        } else {
            header('Location: ' . BASE_URL . 'categorias');
        }
        
    }

    public function modificarCategoria($id){
        $isAdmin = AuthHelper::isAdmin();

        $categoria = $this->model->getCategoriaById($id); // Me quedo con EL objeto

        $this->view->showModificarCategoria($categoria, $isAdmin);

        if(isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $img = $_POST['img'];

            $this->model->updateCategoria($id, $nombre, $descripcion, $img);
            header('Location: ' . BASE_URL . 'categorias');
        }
    }

}