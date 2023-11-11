<?php
require_once 'database/config.php';

function base64url_encode($data){
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); // Se codifica la data que se le pasa y se reemplazan símbolos
}

class AuthHelper {

    function getAuthHeaders(){
        $header = "";
        if(isset($_SERVER['HTTP_AUTHORIZATION'])){ // Si esta seteada, se mandó un header
            $header = ($_SERVER['HTTP_AUTHORIZATION']); // Lo guardo acá
        }
        if(isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])){ // Si está seteada, se guardó un header en otro lado
            $header = ($_SERVER['REDIRECT_HTTP_AUTHORIZATION']); // Lo guardo acá
        }
        return $header; // Si este devuelve vacío da el 401 cuando se va por el if del getToken (empty($basic))
    }

    function createToken($payload){
        // El token tiene encabezado - carga util - firma

        $header = array(
            'alg' => 'HS256',
            'typ' => 'JWT'
        );

        $header = base64url_encode(json_encode($header)); // Los hacemos json y despues base64encode
        $payload = base64url_encode(json_encode($payload)); // Esto es para transferir por http

        $signature = hash_hmac('SHA256', "$header.$payload", JWT_KEY, true);
        $signature = base64url_encode($signature);

        $token = "$header.$payload.$signature"; // aca creo el token encabezado - carga util - firma

        return $token;
    }

    function verify($token){
        // Token = $header.$payload.$signature todo en un string largo separado por puntos

        $token = explode(".", $token); // Lo separo

        $header = $token[0];
        $payload = $token[1];
        $signature = $token[2];

        $new_signature = hash_hmac('SHA256', "$header.$payload", JWT_KEY, true);
        $new_signature = base64url_encode($new_signature);

        if($signature != $new_signature){
            return false; // Si la firma esta mal, ya salgo
        }

        $payload = json_encode(base64_decode($payload));

        return $payload; // Si llego hasta acá la firma fué correcta y le devuelvo el payload al controller
    }

    function currentUser(){
        $auth = $this->getAuthHeaders();

        $auth = explode(" ", $auth); // ["Bearer", $token]

        if ($auth[0] != "Bearer"){
            return false;
        }

        return $this->verify($auth[1]); // Si está bien devuelve el payload

    }
}