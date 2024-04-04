<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController
{
    public static function index(Router $router)
    {
        session_start();
        isAdmin();

        $fechaini = $_GET['fechaini'] ?? date('Y-m-d');
        $fechainicio = explode('-', $fechaini);
        
        if (!checkdate( $fechainicio[1], $fechainicio[2], $fechainicio[0] )) {
            header('Location: /404');
        }

        // Consultar la base de datos
        $consulta = "SELECT citas.id, citas.fecha, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as nombre, ";
        $consulta .= " usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citas_servicios ";
        $consulta .= " ON citas_servicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citas_servicios.servicioId ";
        $consulta .= " WHERE fecha = '$fechaini'";

        $citas = AdminCita::SQL($consulta);

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fechaini' => $fechaini
            // 'fechafin' => $fechafin
        ]);
    }
}