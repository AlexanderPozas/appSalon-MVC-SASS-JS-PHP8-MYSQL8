<?php 
require __DIR__ . '/../vendor/autoload.php';
/**Importar php dotenv */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();


require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
use Models\ActiveRecord;
ActiveRecord::setDB($db);