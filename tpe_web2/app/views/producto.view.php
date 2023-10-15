<?php

class ProductoView {
    public function showProductos($productos, $categorias, $isAdmin) {
        require 'templates/listaProductos.phtml';
    }

    public function showError($error) {
        require 'templates/error.phtml';
    }

    public function showModificarProducto($producto, $categorias, $isAdmin){
        require 'templates/form_modificar_producto.phtml';
    }

    public function showProducto($producto, $isAdmin){
        require 'templates/producto.phtml';
    }
}