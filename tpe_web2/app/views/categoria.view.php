<?php

class CategoriaView {
    public function showCategorias($categorias, $isAdmin) {
        require 'templates/listaCategorias.phtml';
    }

    public function showError($error, $isAdmin) {
        require 'templates/error.phtml';
    }

    public function showModificarCategoria($categoria, $isAdmin){
        require 'templates/form_modificar_categoria.phtml';
    }

    public function showCategoria($id, $categoria, $productos, $isAdmin){
        require 'templates/productosPorCategoria.phtml';
    }
}