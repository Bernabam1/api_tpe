<?php

class UserModel {
    private $db;

    public function __construct(){
        require_once './config/config.php';
        $conn = new db();
        $this->db = $conn->connection();
    }

    public function getByUsername($username) {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE username = ?');
        $query->execute([$username]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}