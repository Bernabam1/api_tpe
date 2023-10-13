<?php

class ProductoView {
    public function showProductos($productos, $categorias) {
        require 'templates/listaProductos.phtml';
    }

    public function showError($error) {
        require 'templates/error.phtml';
    }

    public function showModificarProducto($producto, $categorias){
        require 'templates/form_modificar_producto.phtml';
    }
}