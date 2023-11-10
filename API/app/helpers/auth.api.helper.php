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

}