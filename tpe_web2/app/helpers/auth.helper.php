<?php

class AuthHelper {

    public static function init() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login($user) {
        AuthHelper::init();
        $_SESSION['USER_ID'] = $user->id;
        $_SESSION['USER_NAME'] = $user->username; 
    }

    public static function isAdmin(){
        return !empty($_SESSION['id_usuario']);
    }

    public static function logout() {
        AuthHelper::init();
        session_destroy();
        header('Location: ' . BASE_URL);
        die();
    }

    public static function verify() {
        AuthHelper::init();
        if (!isset($_SESSION['USER_ID'])) {
            header('Location: ' . BASE_URL . '/login');
            die();
        }
    }
}