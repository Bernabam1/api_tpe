<?php
    require_once 'app/view/api.view.php';

    abstract class ApiController{
        protected $view;
        private $data;

        function __construct(){
            $this->view = new APIView();
            $this->data = file_get_contents('php://input'); // Lee
        }

        function getData(){
            return json_decode($this->data); // Hace un json de lo que leyó
        }
    }