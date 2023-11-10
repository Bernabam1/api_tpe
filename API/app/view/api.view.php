<?php

class APIView {

    public function response($data, $status) { // es la que va a llamar el controller para enviar la respuesta
        header("Content-Type: application/json");
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        echo json_encode($data);
    }

 	private function _requestStatus($code){ // codigo de respuesta (privada)
        $status = array(
            200 => "OK",
            201 => "Created",
            404 => "Not found",
            500 => "Internal Server Error"
          );
          return (isset($status[$code]))? $status[$code] : $status[500]; // Si existe el mensaje le doy el estado, sino el 500    
    }
}