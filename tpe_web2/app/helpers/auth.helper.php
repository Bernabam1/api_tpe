<?php

class AuthHelper {

    public static function init() {
        if (session_status() != PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public static function login($user) {
        AuthHelper::init();
        $_SESSION['id'] = $user->id;
        $_SESSION['username'] = $user->username; 
    }

    public static function isAdmin(){
        return !empty($_SESSION['id']);
    }

    public static function logout() {
        AuthHelper::init();
        session_destroy();
        header('Location: ' . BASE_URL);
        die();
    }

    public static function verify() {
        AuthHelper::init();
        if (!isset($_SESSION['id'])) {
            header('Location: ' . BASE_URL . '/login');
            die();
        }
    }
}