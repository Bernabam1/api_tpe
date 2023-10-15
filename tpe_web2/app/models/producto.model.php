<?php

class ProductoModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=db_productos;charset=utf8', 'root', '');
    }

    function getProductos(){

        $query = $this->db->prepare('SELECT * FROM producto');
        $query->execute();

        // 3. Obtener los datos para procesarlos
        $productos = $query->fetchAll(PDO::FETCH_OBJ); // Devuelve un arreglo con todos los productos (para uno especifico uso un fetch q devuelve un solo registro)

        return $productos; 
    }

    function getProductoById($id){

        $query = $this->db->prepare('SELECT * FROM producto WHERE id_producto = ?');
        $query->execute([$id]);

        // 3. Obtener los datos para procesarlos
        $producto = $query->fetch(PDO::FETCH_OBJ); // Devuelve un arreglo con todos los productos (para uno especifico uso un fetch q devuelve un solo registro)

        return $producto;
    }

    function insertProducto($nombre, $categoria, $precio, $stock, $img){

        $query = $this->db->prepare('INSERT INTO producto (nombre, id_categoria, precio, stock, imagen) VALUES(?,?,?,?,?)'); // No va id_producto (lo carga autoincremental) - Van los ? para prevenir inyeccion SQL
        $query->execute([$nombre, $categoria, $precio, $stock, $img]);
    
        return $this->db->lastInsertId();
    }    
    
    function deleteProducto($id){
           
        $query = $this->db->prepare('DELETE FROM producto WHERE id_producto = ?');
        $query->execute([$id]);
    }
    
    function updateProducto($id, $nombre, $id_categoria, $precio, $stock, $img){
    
        $query = $this->db->prepare('UPDATE producto SET nombre = ?, id_categoria = ?, precio = ?, stock = ?, imagen = ? WHERE id_producto = ?');
        $query->execute([$nombre, $id_categoria, $precio, $stock, $img, $id]);
    }
}