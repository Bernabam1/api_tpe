<?php
require_once 'app/controllers/api.controller.php';

class NotFoundController extends ApiController
{
  public function notFound()
  {
    $this->view->response("La ruta no existe", 404);
  }
}