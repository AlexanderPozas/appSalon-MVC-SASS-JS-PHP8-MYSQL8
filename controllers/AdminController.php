<?php

namespace Controllers;

use Models\AdminCita;
use MVC\Router;

class AdminController
{
    public static function index(Router $router)
    {
        session_start();
        isAdmin();
        date_default_timezone_set('America/Mexico_City');
        $fecha = $_GET['fecha'] ?? date('Y-m-d');

        $fechas = explode('-', $fecha); //Split a un string y crea un arrgelo con los valores

        /**Verificar que sea una fecha válida
         * checkdate(month, year, day) : bool
         */
        if(!checkdate($fechas[1], $fechas[2], $fechas[0])){
            header('Location: /404'); //Redireccionamos a la pagina de error 404
        }

        //Consulta para la base de datos
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE fecha =  '${fecha}' ";

        $citas = AdminCita::SQL($consulta);
        // echo json_encode($query);

        $router->render('/admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha,
        ]);
    }
}
