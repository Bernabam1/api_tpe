<?php
    require_once 'app/controllers/api.controller.php';
    require_once 'app/helpers/auth.api.helper.php';
    require_once 'app/models/user.model.php';

    class UserApiController extends ApiController{
        private $model;
        private $authHelper;

        function __construct(){
            parent::__construct();
            $this->model = new UserModel();
            $this->authHelper = new AuthHelper();
        }

        function getToken($params = []){
            $basic = $this->authHelper->getAuthHeaders();

            if(empty($basic)){
                $this->view->response("No envió encabezados de autenticacion", 401);
                return;
            }

            $basic = explode(" ", $basic); // ["Basic", "base64(user:pass)"]

            if($basic[0]!="Basic"){
                $this->view->response("Los encabezados de autenticacion son incorrectos", 401);
                return;
            }

            // Validar que el user y la contraseña existan

            $userpass = base64_decode($basic[1]);
            $userpass = explode(":",$userpass); // ["user" , "pass"]

            $user = $userpass[0];
            $pass = $userpass[1];

            $user = $this->model->getByUsername($user);

            // En la db = id - username - password
            $userdata = ["id" => $user->id, "username" => $user->username];

            if(isset($user)){
                if((password_verify($pass, $user->password))) {
                    // Usuario es válido
                    $token = $this->authHelper->createToken($userdata);
                    $this->view->response($token, 200);
                    return;
                }
                else{
                    $this->view->response("El usuario o la contraseña son incorrectos", 401);
                }
            }
        }

    }