<?php
/* DATOS DE UNA PELICULA */

class Usuario implements JsonSerializable
{
    private $id;
    private $nombre;
    private $contraseña;
    private $correo;
    private $plan;

    public function JsonSerialize()
    {
        return [
            'nombre' => $this->nombre,
            'contraseña' => $this->contraseña
        ];
    }

    // Getter con método mágico
    public function __get($atributo)
    {
        $class = get_class($this);
        if (property_exists($class, $atributo)) {
            return $this->$atributo;
        }
    }

    // Set con método mágico
    public function __set($atributo, $valor)
    {
        $class = get_class($this);
        if (property_exists($class, $atributo)) {
            $this->$atributo = $valor;
        }
    }
}
