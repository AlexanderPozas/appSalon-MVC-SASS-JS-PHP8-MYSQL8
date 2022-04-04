<?php

namespace Models;

class Cita extends ActiveRecord {
    public static $tabla = 'citas';
    public static $columnasDB = ['id', 'fecha', 'hora', 'usuarioId'];

    public $id;
    public $fecha;
    public $hora;
    public $usuarioId;

    public function __construct($args = [])
    {
        $this->id = $agrs['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? 'null';
        $this->usuarioId = $args['usuarioId'];
    }
}