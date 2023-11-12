<?php
require_once 'model.php';

class ProductoModel extends Model {

    function getProductos($sortField, $sortOrder, $page, $perPage){
        // Paginación
        $offset = ($page - 1) * $perPage; // Esto hace que la página 1 empiece en 0, la página 2 en $perPage, la página 3 desde 2*$perPage, y así sucesivamente.

        $query = $this->db->prepare("SELECT * FROM producto ORDER BY $sortField $sortOrder LIMIT $perPage; OFFSET $offset"); // Le paso los valores a la query
        $query->execute();

        // Obtener los datos para procesarlos
        $productos = $query->fetchAll(PDO::FETCH_OBJ); // Devuelve un arreglo con todos los productos

        return $productos; 
    }

    function getProductoById($id){

        $query = $this->db->prepare('SELECT * FROM producto WHERE id_producto = ?');
        $query->execute([$id]);

        $producto = $query->fetch(PDO::FETCH_OBJ); // Devuelve un producto

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

    function getProductosByCategoria($categoria_id) {

        $query = $this->db->prepare("SELECT * FROM producto WHERE id_categoria = ?");
        $query->execute([$categoria_id]);
    
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}