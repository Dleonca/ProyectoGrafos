<?php

class nodo
{

    private $info;
    private $derecho;
    private $izquierdo;

    public function __construct($info)
    {
        $this->info = $info;
        $this->derecho = null;
        $this->izquierdo = null;
    }


    public function getInfo()
    {
        return $this->info;
    }

    public function getDerecho()
    {
        return $this->derecho;
    }

    public function getIzquierdo()
    {
        return $this->izquierdo;
    }


    public function setInfo($info)
    {
        $this->info = $info;
    }

    public function setDerecho($derecho)
    {
        $this->derecho = $derecho;
    }

    public function setIzquierdo($izquierdo)
    {

        $this->izquierdo = $izquierdo;
    }
}