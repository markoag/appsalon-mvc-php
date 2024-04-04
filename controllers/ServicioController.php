<?php

namespace Controllers;

use MVC\Router;
use Model\Servicio;

class ServicioController
{
    public static function index(Router $router)
    {
        session_start();
        isAdmin();
        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'servicios' => $servicios,
            'nombre' => $_SESSION['nombre']
        ]);
    }

    public static function crear(Router $router)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        isAdmin();
        $servicio = new Servicio();
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $servicio->sincronizar($_POST);
            //debuguear($servicio);

            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->createdAt = date('Y-m-d H:i:s');
                $servicio->guardar();
                header('Location: /servicios');
            }
        }


        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        isAdmin();
        if(!is_numeric($_GET['id'])) return;

        $servicio = Servicio::find($_GET['id']);
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            
            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->updatedAt = date('Y-m-d H:i:s');
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            isAdmin();
            $servicio = Servicio::find($_POST['id']);
            $servicio->eliminar();
            header('Location: /servicios');
        }
    }
}