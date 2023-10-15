<?php
require_once './app/views/auth.view.php';
require_once './app/models/user.model.php';
require_once './app/helpers/auth.helper.php';

class AuthController {
    private $view;
    private $model;

    function __construct() {
        $this->model = new UserModel();
        $this->view = new AuthView();
    }

    public function showLogin() {
        $isAdmin = AuthHelper::isAdmin();
        $error=null;
        $this->view->showLogin($error, $isAdmin);
    }

    public function auth() {
        $isAdmin = AuthHelper::isAdmin();
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $this->view->showLogin('Faltan completar datos',$isAdmin);
            return;
        }

        // busco el usuario
        $user = $this->model->getByUsername($username);

        if ($user && password_verify($password, $user->password)) {
            // ACA LO AUTENTIQUE
            
            AuthHelper::login($user);
            
            header('Location: ' . BASE_URL);
        } else {
            $this->view->showLogin('Usuario o contraseña incorrectos', $isAdmin);
        }
    }

    public function logout() {
        AuthHelper::logout();
        header('Location: ' . BASE_URL);    
    }
}