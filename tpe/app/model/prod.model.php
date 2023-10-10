<?php

// ESTO HARIA COMO DE ABM DE LA TABLA PRODUCTO

class ProdModel{
    private $db;

    function __construct() {
        // 1. Abro la conexión con la DB
        $this->db = new PDO('mysql:host=localhost;dbname=db_productos;charset=utf8', 'root', '');
        //La creo acá en el objeto ProdModel para no tener que abrirla en cada método y la guardo en el atributo db

    }

    function getProductos(){

        // 2. Ejecuto consulta SQL --> 'SELECT * FROM producto'
        // Para PDO --> Dos pasos: prepare y execute
    
        $query = $this->db->prepare('SELECT * FROM producto');
        $query->execute();
    
        // 3. Obtener los datos para procesarlos
        $productos = $query->fetchAll(PDO::FETCH_OBJ); // Devuelve un arreglo con todos los productos (para uno especifico uso un fetch q devuelve un solo registro)
    
        return $productos;        
    }

    // Agrega Producto por id autoincremental

    function addProducto($nombre, $id_cat, $precio, $stock, $img) {
        $query = $this->db->prepare('INSERT INTO producto (nombre, id_cat, precio, img) VALUES(?,?,?,?)');
        $query->execute([$nombre, $id_cat, $precio, $stock, $img]);

        return $this->db->lastInsertId();
        /*
        La base de datos asigna automáticamente un nuevo valor a esa columna para cada inserción, y lastInsertId() recupera ese valor.
        */ 
    }

    // Borra producto por id

    function deleteProducto($id) {
        $query = $this->db->prepare('DELETE FROM producuto WHERE id_producto = ?');
        $query->execute([$id]); // Esto bindea el parametro q viene en el ? para que PDO haga la consulta de modo seguro
    }

    // Falta la funcion de modificacion

    // 4. PDO cierra la conexion cuando termina el Script
}