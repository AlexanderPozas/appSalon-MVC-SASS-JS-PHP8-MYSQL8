<?php

namespace Controllers;

use Classes\Email;
use Models\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {

        $alertas = [];

        /**Crear una instancia vacía del usuario */
        $auth = new Usuario;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            /**Pasar argumentos al modelo Usuario */
            $auth = new Usuario($_POST);

            /**Validar datos del usuario */
            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                /**Reviso si el usuario existe en la bd y regreso el objeto */
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    /**Verificar password */
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        /**Autenticar al usuario
                         * Crear la sesión
                         */
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        if ($usuario->admin === '1') {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('location: /admin');
                        } else {
                            header('location: /cita');
                        }
                    }
                } else {
                    /**No existe el usuario */
                    Usuario::setAlerta('error', 'Usuario no Encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('/auth/login', [
            'alertas' => $alertas,
            'auth' => $auth
        ]);
    }

    public static function logout()
    {
        /**Cerrar la sesion */
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function forgot(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            /**Valida entradas */
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                /**Verificar que esxita en la bd y este confirmado */
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario && $usuario->confirmado === '1') {
                    /**Generar un token único */
                    $usuario->generarToken();
                    $usuario->guardar();

                    /**Enviar correo al email */
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'Revisa tu Email');
                } else {
                    Usuario::setAlerta('error', 'El usuario no Existe o no está Confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('/auth/olvido-password', [
            'alertas' => $alertas

        ]);
    }

    public static function recover(Router $router)
    {
        $alertas = [];
        $error = false; //Variable para ocultar la vista en caso de que haya un token no válido

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no Válido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            /**Leer el nuevo Password y guardarlo */
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)){
                $usuario->password = null;
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado){
                    header('location: /');
                }
            }
        }


        $alertas = Usuario::getAlertas();
        $router->render('/auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    }

    public static function crear(Router $router)
    {
        $usuario = new Usuario;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            /*Sincroniza lo que ingresa el usuario con el objeto en memoria*/
            $usuario->sincronizar($_POST);
            /**Se validan los datos que ingresa el usuario */
            $alertas = $usuario->validarCuentaNueva();

            /**Una vez que los datos son correctos*/
            if (empty($alertas)) {
                /**Verificar que el usuario no esté registrado
                 * Se utiliza la propiedad num_rows del objeto mysql
                 */
                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {
                    /**Crear un nuevo usuario 
                     * Hasehar el password
                     */
                    $usuario->hashPassword();

                    /**Generar un token unico para confirmar cuenta */
                    $usuario->generarToken();

                    /**General un email de confirmacion con phpMailer */
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();

                    $resultado  = $usuario->guardar();
                    if ($resultado) {
                        header('location: /mensaje');
                    }
                }
            }
        }

        $router->render('/auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('/auth/mensaje');
    }

    public static function confirmar(Router $router)
    {

        $alertas = [];

        /* Se obtiene el token desde la url */
        $token = s($_GET['token']);

        /**Se utiliza el método where que busca en la bd por una columna y valor específico */
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token No Válido');
        } else {
            $usuario->confirmado = 1;
            $usuario->token = '';
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Usuario Confirmado');
        }

        $alertas = Usuario::getAlertas();
        $router->render('/auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
