<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    /**Almacena una url especifica get o post [/, /admin, /citas]
     *Y un controlador estático [\controller::class, 'funcion a ejecutar del controlador']*/
    public function get($url, $fn)
    {
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    
    public function comprobarRutas()
    {
        
        // Proteger Rutas...
        // session_start();

        // Arreglo de rutas protegidas...
        // $rutas_protegidas = ['/admin', '/propiedades/crear', '/propiedades/actualizar', '/propiedades/eliminar', '/vendedores/crear', '/vendedores/actualizar', '/vendedores/eliminar'];

        // $auth = $_SESSION['login'] ?? null;

        /**Almacena la url actual */
        $currentUrl = $_SERVER['REQUEST_URI'] === '' ? '/' : $_SERVER['REQUEST_URI'];
        $queryStringPos = strpos($currentUrl, '?');
        if(is_numeric($queryStringPos)){
            $currentUrl = substr($currentUrl, 0, $queryStringPos);
        }    

        /**Verifica el metodo http requerido GET o POST*/
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            //Extrae el controlador y su funcion asociada de la url actual, \controller::class, 'funcion'
            $fn = $this->getRoutes[$currentUrl] ?? null; 
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }


        if ( $fn ) {
            // Call user fn va a llamar una función estática de un clase  cuando no sabemos cual sera
            call_user_func($fn, $this); // This es para pasar argumentos de la clase actual
        } else {
            echo "Página No Encontrada o Ruta no válida";
        }
    }

    /**Renderiza las vista
     * Se la pasa un url de una vista definida en views /carpeta/vista no la url actual
     * Se le pueden pasar datos de mi controlador por medio de un arreglo asociativo ['errores' => $errores]
     */
    public function render($view, $datos = [])
    {

        // Leer lo que le pasamos  a la vista
        foreach ($datos as $key => $value) {
            $$key = $value;  // Doble signo de dolar significa: variable variable, básicamente nuestra variable sigue siendo la original, pero al asignarla a otra no la reescribe, mantiene su valor, de esta forma el nombre de la variable se asigna dinamicamente
        }

        ob_start(); // Almacenamiento en memoria durante un momento...

        // entonces incluimos la vista en el layout
        include_once __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean(); // Obtiene el buffer actual y elimina el buffer de salida

        /**Se incluye la vista principal o main
         * Automaticamente le pasamos la variable contenido que contiene la vista
         */
        include_once __DIR__ . '/views/layout.php';
    }
}
