<?php

class CategoriaView {
    public function showCategorias($categorias, $isAdmin) {
        
        // NOTA: el template va a poder acceder a todas las variables y constantes que tienen alcance en esta funcion

        // mostrar el template
        require 'templates/listaCategorias.phtml';
    }

    public function showError($error) {
        require 'templates/error.phtml';
    }

    public function showModificarCategoria($categoria, $isAdmin){
        require 'templates/form_modificar_categoria.phtml';
    }

    public function showCategoria($id, $categoria, $productos, $isAdmin){
        require 'templates/productosPorCategoria.phtml';
    }
}