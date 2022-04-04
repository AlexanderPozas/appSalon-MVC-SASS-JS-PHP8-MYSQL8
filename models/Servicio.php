<?php

namespace Models;

class Servicio extends ActiveRecord {
    public static $tabla = 'servicios';
    public static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

    public function validar(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->precio){
            self::$alertas['error'][] = 'El Precio es Obligatorio';
        }
        if(!is_numeric($this->precio)){
            self::$alertas['error'][] = 'El Precio no es Válido';
        }
        return self::$alertas;
    }
}