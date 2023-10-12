<?php

class CategoriaModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=db_productos;charset=utf8', 'root', '');
    }

    function getCategorias(){
    
        // 2. Ejecuto consulta SQL --> 'SELECT * FROM categorias'
        // Para PDO --> Dos pasos: prepare y execute
    
        $query = $this->db->prepare('SELECT * FROM categorias');
        $query->execute();
    
        // 3. Obtener los datos para procesarlos
        $categorias = $query->fetchAll(PDO::FETCH_OBJ); // Devuelve un arreglo con todos los productos (para uno especifico uso un fetch q devuelve un solo registro)
    
        return $categorias; 
    }

    function insertCategoria($nombre, $descripcion, $imagen){
    
        $query = $this->db->prepare('INSERT INTO categorias (nombre, descripcion, imagen) VALUES(?,?,?)'); // No va id (lo carga autoincremental) - Van los ? para prevenir inyeccion SQL
        $query->execute([$nombre, $descripcion, $imagen]);
    
        return $this->db->lastInsertId();
    }
    
    function deleteCategoria($id){
           
        $query = $this->db->prepare('DELETE FROM producto WHERE categoria.id_categoria = ?');
        $query->execute([$id]);
    }
}