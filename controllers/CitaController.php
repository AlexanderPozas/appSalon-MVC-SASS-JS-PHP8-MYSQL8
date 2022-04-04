<?php

namespace Controllers;

use MVC\Router;

class CitaController
{
    public static function index(Router $router){
        session_start();

        /**Verificar si está autenticado o no */
        isAuth();

        $router->render('/cita/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }
}
