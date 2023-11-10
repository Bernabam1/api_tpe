<?php
require_once 'model.php';

class CategoriaModel extends Model{
    

    function getCategorias(){
    
        $query = $this->db->prepare('SELECT * FROM categorias');
        $query->execute();
    
        $categorias = $query->fetchAll(PDO::FETCH_OBJ); // Devuelve un arreglo con todos los productos (para uno especifico uso un fetch q devuelve un solo registro)
    
        return $categorias; 
    }

    function getCategoriaById($id){

        $query = $this->db->prepare('SELECT * FROM categorias WHERE id_categoria = ?');
        $query->execute([$id]);

        $categoria = $query->fetch(PDO::FETCH_OBJ); // Aca hago fetch en vez de fetch all

        return $categoria;
    }

    function insertCategoria($nombre, $descripcion, $imagen){
    
        $query = $this->db->prepare('INSERT INTO categorias (nombre, descripcion, imagen) VALUES(?,?,?)'); // No va id (lo carga autoincremental) - Van los ? para prevenir inyeccion SQL
        $query->execute([$nombre, $descripcion, $imagen]);
    
        return $this->db->lastInsertId();
    }
    
    function deleteCategoria($id){
        // chequear que no exista un producto que tenga esta categoria a eliminar

        $queryProducto = $this->db->prepare('SELECT * FROM producto WHERE id_categoria = ?');
        $queryProducto->execute([$id]);

        $queryProductos = $queryProducto->fetchAll(PDO::FETCH_OBJ);

        if(sizeof($queryProductos)>0){
            return 1;
        } else{
            $query = $this->db->prepare('DELETE FROM categorias WHERE id_categoria = ?');
            $query->execute([$id]);
        }

        
    }

    function updateCategoria($id, $nombre, $descripcion, $img){
    
        $query = $this->db->prepare('UPDATE categorias SET nombre = ?, descripcion = ?, imagen = ? WHERE id_categoria = ?');
        $query->execute([$nombre, $descripcion, $img, $id]);
    }
}