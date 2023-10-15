<?php

class AuthView {
    public function showLogin($error = null, $isAdmin) {
        require './templates/login.phtml';
    }
}