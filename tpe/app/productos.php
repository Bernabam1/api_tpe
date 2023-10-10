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
            <li class="list-group-item producto-acciones">
                <div>
                <?php echo $producto->nombre ?> | $<?php echo $producto->precio ?> </li>
                </div>
                <div class="actions">
                    <a href="modificar/<?php echo $producto->id_producto ?>?nombre=<?php echo $producto->nombre ?>&?id_categoria=<?php echo $producto->id_categoria ?>" type = "button" class="btn btn-success ml-auto">Modificar</a>
                    <a href="eliminar/<?php echo $producto->id_producto ?>" type = "button" class="btn btn-danger ml-auto">Eliminar</a>
                </div>
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

        $id = insertProducto($nombre, $categoria, $precio, $stock, $img);

        if ($id){ // Si es cero se va por el false -- ESTE CHEQUEO NO ANDA, NO VA NUNCA AL ELSE
            header('Location: ' . BASE_URL); // Esto hace redireccion a la BASE_URL q esta como constante apuntando al home
        } else {
            echo "Error al ingresar el producto";
        }
      

    }

    function removeProducto($id){
        deleteProducto($id);
        header('Location: ' . BASE_URL);
    }

    function modificarProducto($id){

        require 'templates/header.phtml';
        require 'templates/form_modificar.phtml';
        require 'templates/footer.phtml';

        if(isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $id_categoria = $_POST['categoria'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $img = $_POST['img'];

            $id = updateProducto($id, $nombre, $id_categoria, $precio, $stock, $img);
            header('Location: ' . '//'.$_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT']);
        }
    }