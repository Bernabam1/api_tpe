<?php

class ProductoView {
    public function showProductos($productos, $categorias) {

        // NOTA: el template va a poder acceder a todas las variables y constantes que tienen alcance en esta funcion

        // mostrar el template
        require 'templates/listaProductos.phtml';
    }

    public function showError($error) {
        require 'templates/error.phtml';
    }

}