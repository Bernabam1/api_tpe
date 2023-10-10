<?php
require_once './app/db.php';

    function mostrarProductos(){
        require 'templates/header.phtml';

        //Obtengo productos
        $productos = getProductos();

        require 'templates/form_alta.phtml'
        
        ?>

        <ul class="list-group">
        
        <?php foreach($productos as $producto){ ?>
            <li class="list-group-item">
                <?php echo $producto->nombre ?> | $<?php echo $producto->precio ?> </li>
        <?php } ?>
        </ul>
        
        <?php
        require 'templates/footer.phtml';
    }

    function addProducto(){

        // Falta validacion

        // Agarro lo que viene del form y lo guardo en variables
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $precio = $_POST['precio'];
        $stock = $_POST['stock'];
        $img = $_POST['img'];
        
        // Inserto

        insertProducto($nombre, $categoria, $precio, $stock, $img);

        echo "Se insertó";

    }