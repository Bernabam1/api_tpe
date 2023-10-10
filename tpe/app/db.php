<?php


//ESTE HACE CONEXION A LA BASE DE DATOS

function getConection(){
    return new PDO('mysql:host=localhost;dbname=db_productos;charset=utf8', 'root', '');
}

function getCategorias(){

    $db = getConection();

    // 2. Ejecuto consulta SQL --> 'SELECT * FROM producto'
    // Para PDO --> Dos pasos: prepare y execute

    $query = $db->prepare('SELECT * FROM categorias');
    $query->execute();

    // 3. Obtener los datos para procesarlos
    $categorias = $query->fetchAll(PDO::FETCH_OBJ); // Devuelve un arreglo con todos los productos (para uno especifico uso un fetch q devuelve un solo registro)

    return $categorias; 
}	

function getProductos(){

    $db = getConection();

    // 2. Ejecuto consulta SQL --> 'SELECT * FROM producto'
    // Para PDO --> Dos pasos: prepare y execute

    $query = $db->prepare('SELECT * FROM producto');
    $query->execute();

    // 3. Obtener los datos para procesarlos
    $productos = $query->fetchAll(PDO::FETCH_OBJ); // Devuelve un arreglo con todos los productos (para uno especifico uso un fetch q devuelve un solo registro)

    return $productos; 
}

function insertProducto($nombre, $categoria, $precio, $stock, $img){

    $db = getConection();

    $query = $db->prepare('INSERT INTO producto (nombre, id_categoria, precio, stock, imagen) VALUES(?,?,?,?,?)'); // No va id_producto (lo carga autoincremental) - Van los ? para prevenir inyeccion SQL
    $query->execute([$nombre, $categoria, $precio, $stock, $img]);

    return $db->lastInsertId();
}

function deleteProducto($id){
    $db = getConection();

    $query = $db->prepare('DELETE FROM producto WHERE producto.id_producto = ?');
    $query->execute([$id]);
}

function updateProducto($id, $nombre, $id_categoria, $precio, $stock, $img){
    $db = getConection();

    $query = $db->prepare('UPDATE producto SET nombre = ?, id_categoria = ?, precio = ?, stock = ?, imagen = ? WHERE id_producto = ?');
    $query->execute([$nombre, $id_categoria, $precio, $stock, $img, $id]);
}

// function getProductById($id){

//     // DESDE ACA CHAT GPT
//     $db = getConection();
    
//     // Prepare a SQL query to retrieve a product by ID
//     $query = $db->prepare('SELECT * FROM producto WHERE id_producto = ?');
//     $query->execute([$id]);
    
//     // Fetch the product data
//     $product = $query->fetch(PDO::FETCH_ASSOC);
    
//     return $product;

//     //HASTA ACA
// }