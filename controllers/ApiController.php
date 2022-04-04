<?php

namespace Controllers;

use Models\Cita;
use Models\CitaServicio;
use MVC\Router;
use Models\Servicio;

class ApiController {
    public static function index() {
        $servicios = Servicio::all();
        echo json_encode($servicios);

    }
    public static function guardar() {
        /**Almacena la cita y devuelve el ultimo id */
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        /**Almacena el id de la cita y los servicios con ese id */
        $idServicios = explode(',', $_POST['servicios']);
        $citaId = $resultado['id'];

        foreach($idServicios as $idServicio){
            $args = [
                'citaId' => $citaId,
                'servicioId' => $idServicio
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        $respuesta = [
            'resultado' => $resultado
        ];
        echo json_encode($respuesta);
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];

            $cita = Cita::find($id);
            $resultado = $cita->eliminar();

            if($resultado){
                /**$_SERVER['HTTP_REFERER'] 
                 * Devuelve la url previo al cambio de url
                */
                header('Location:' . $_SERVER['HTTP_REFERER']);
            }

        }
    }
}