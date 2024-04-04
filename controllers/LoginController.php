<?php

namespace Controllers;

use Classes\Email;
use MVC\Router;
use Model\Usuario;

class LoginController
{
    public static function login(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    // Revisar si el password es correcto
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        // Autenticar el usuario
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionar
                        if ($usuario->admin === '1') {
                            $_SESSION['admin'] = $usuario->admin ?? null;

                            header('Location: /admin');
                        } else {
                            header('Location: /cita');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }
    public static function logout()
    {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }
    public static function olvidar(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario && $usuario->confirmado === '1') {
                    // Generar un token
                    $usuario->generarToken();

                    // Enviar un correo
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    // Guardar el usuario en la BD
                    $usuario->updatedAt = date('Y-m-d H:i:s');
                    $usuario->guardar();

                    Usuario::setAlerta('exito', 'Revisa tu email para cambiar tu contraseña');

                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado o no confirmado');

                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }
    public static function recuperar(Router $router)
    {
        $alertas = [];
        $error = false;
        $token = s($_GET['token']);

        // Buscar el usuario con el token
        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if (empty($alertas)) {
                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;
                $usuario->updatedAt = date('Y-m-d H:i:s');
                $resultado = $usuario->guardar();
                if ($resultado) {
                    Usuario::setAlerta('exito', 'Contraseña actualizada');
                }
            }
        }


        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error,
            'resultado' => $resultado
        ]);
    }
    public static function crear(Router $router)
    {
        $usuario = new Usuario;

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if (empty($alertas)) {
                // Verificar si el usuario existe
                $resultado = $usuario->existeUsuario();

                if (!$resultado) {
                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear el password
                    $usuario->hashPassword();

                    // Generar un token
                    $usuario->generarToken();

                    // Enviar un correo
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarEmail();

                    // Guardar el usuario en la BD
                    $usuario->createdAt = date('Y-m-d H:i:s');
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
        }

        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router)
    {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            // Mensaje de error
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            // Modificar a usuario confirmado
            $usuario->confirmado = '1';
            $usuario->token = null;
            $usuario->updatedAt = date('Y-m-d H:i:s');
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada');
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    }
}
