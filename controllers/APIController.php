<?php

namespace Controllers;

use Model\Servicio;
use Model\Cita;
use Model\CitaServicio;

class APIController
{
    public static function index()
    {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar()
    {
        // Almacena la cita y devuelve el ID
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        // Almacena los servicios de la cita
        $serviciosID = explode(',', $_POST['servicios']);

        foreach($serviciosID as $servicioID) {
            $args = [
                'citaId' => $id,
                'servicioId' => $servicioID
            ];
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        // Devuelve el resultado
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cita = Cita::find($_POST['id']);
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}
