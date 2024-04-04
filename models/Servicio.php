<?php

namespace Model;

class Servicio extends ActiveRecord
{
    protected static $tabla = 'servicios';
    protected static $columnasDB = [
        'id',
        'nombre',
        'descripcion',
        'precio',
        'createdAt',
        'updatedAt'
    ];

    public $id;
    public $nombre;
    public $descripcion;
    public $precio;
    public $createdAt;
    public $updatedAt;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->precio = $args['precio'] ?? 0;
        $this->createdAt = $args['createdAt'] ?? null;
        $this->updatedAt = $args['updatedAt'] ?? null;
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if (!$this->descripcion) {
            self::$alertas['error'][] = 'La descripcion es obligatoria';
        }

        if (!$this->precio) {
            self::$alertas['error'][] = 'El precio es obligatorio';
        }

        if (!empty($this->precio) && !is_numeric($this->precio) || $this->precio <= 0) {
            self::$alertas['error'][] = 'El precio no es valido';
        }

        return self::$alertas;
    }
}
