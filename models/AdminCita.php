<?php

namespace Model;

class AdminCita extends ActiveRecord {

    protected static $tabla = 'citas_servicios';
    protected static $columnasDB = ['id','nombre','telefono','fecha','hora','servicio','precio'];

    public $id;
    public $nombre;
    public $telefono;
    public $fecha;
    public $hora;
    public $servicio;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->servicio = $args['servicio'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }
}