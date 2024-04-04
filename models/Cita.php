<?php

namespace Model;

class Cita extends ActiveRecord {
    // Base de Datos
    protected static $tabla = 'citas';
    protected static $columnasDB = ['id', 'fecha', 'hora', 'usuarioId', 'createdAt', 'updatedAt'];

    public $id;
    public $fecha;
    public $hora;
    public $usuarioId;
    public $createdAt;
    public $updatedAt;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora = $args['hora'] ?? '';
        $this->usuarioId = $args['usuarioId'] ?? '';
        $this->createdAt = $args['createdAt'] ?? null;
        $this->updatedAt = $args['updatedAt'] ?? null;
    }

}