<?php
require_once './app/models/producto.model.php';
require_once './app/views/producto.view.php';
require_once './app/models/categoria.model.php';

class ProductoController {
    private $model;
    private $view;
    private $catModel;

    public function __construct() {
        $this->model = new ProductoModel();
        $this->view = new ProductoView();
        $this->catModel = new CategoriaModel();
    }

    public function showProductos(){
        //le pido los productos al controller

        $isAdmin = AuthHelper::isAdmin();

        $productos = $this->model->getProductos();

        $categorias = $this->catModel->getCategorias();

        $this->view->showProductos($productos, $categorias, $isAdmin);
    }

    public function verProducto($id){

        $isAdmin = AuthHelper::isAdmin();

        $producto = $this->model->getProductoById($id);
        $this->view->showProducto($producto, $isAdmin);
    }


    public function addProducto(){

        // Agarro lo que viene del form y lo guardo en variables
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $img = $_POST['img'];
        
        // Inserto

        $id = $this->model->insertProducto($nombre, $categoria, $precio, $stock, $img);

        if ($id){ // Si es cero se va por el false
            header('Location: ' . BASE_URL . 'productos'); // Esto hace redireccion a la BASE_URL q esta como constante apuntando al home
        } else {
            $this->view->showError('Error al ingresar el producto');
        }
    }

    public function removeProducto($id){
        $this->model->deleteProducto($id);
        header('Location: ' . BASE_URL . 'productos');
    }

    public function modificarProducto($id){

        $isAdmin = AuthHelper::isAdmin();

        $producto = $this->model->getProductoById($id); // Me quedo con EL objeto
        $categorias = $this->catModel->getCategorias();

        $this->view->showModificarProducto($producto, $categorias, $isAdmin);

        if(isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $id_categoria = $_POST['categoria'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $img = $_POST['img'];

            $this->model->updateProducto($id, $nombre, $id_categoria, $precio, $stock, $img);

            //header('Location: ' . BASE_URL . 'productos'); Este header por alguna razon que no comprendo no anda
        }
    }
}