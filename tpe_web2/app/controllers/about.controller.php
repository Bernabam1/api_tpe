<?php
require_once './app/views/about.view.php';
require_once './app/helpers/auth.helper.php';

class AboutController {
    private $view;

    public function __construct() {
        $this->view = new AboutView();
    } 

    public function showAbout() {
        $isAdmin = AuthHelper::isAdmin();
        $this->view->showAbout($isAdmin);
    }
}