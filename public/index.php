<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\ApiController;
use Controllers\CitaController;
use Controllers\LoginController;
use Controllers\ServicioController;
use MVC\Router;

$router = new Router();

/**Login del usuario */
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);

/**Logout del usuario */
$router->get('/logout', [LoginController::class, 'logout']);

/**Recuperar password */
$router->get('/forgot', [LoginController::class, 'forgot']);
$router->post('/forgot', [LoginController::class, 'forgot']);
$router->get('/recover', [LoginController::class, 'recover']);
$router->post('/recover', [LoginController::class, 'recover']);

/**Crear cuenta */
$router->get('/crear-cuenta', [LoginController::class, 'crear']);
$router->post('/crear-cuenta', [LoginController::class, 'crear']);

/**Confirmar cuenta */
$router->get('/confirmar-cuenta', [LoginController::class, 'confirmar']);
$router->get('/mensaje', [LoginController::class, 'mensaje']); //Solo muestra el mensaje que se envio la confirmacion al email

/**Area Privada */
$router->get('/cita',[CitaController::class, 'index']);
$router->get('/admin',[AdminController::class, 'index']);


/**Servicios 
 * API Servicios, Leer datos desde el Servidor
*/
$router->get('/api/servicios', [ApiController::class, 'index']);
/**API Citas, Leer Enviar datos via POST al Servidor y regresar una respuesta */
$router->post('/api/citas', [ApiController::class, 'guardar']);
/*API Cutas, eliminar un registro */
$router->post('/api/eliminar', [ApiController::class, 'eliminar']);

/**Servicios Admin 
 * CRUD Servicios
*/
$router->get('/servicios', [ServicioController::class, 'index']);
$router->get('/servicios/crear', [ServicioController::class, 'crear']);
$router->post('/servicios/crear', [ServicioController::class, 'crear']);
$router->get('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/actualizar', [ServicioController::class, 'actualizar']);
$router->post('/servicios/eliminar', [ServicioController::class, 'eliminar']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();