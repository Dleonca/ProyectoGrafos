<?php 
class Vertice{
    private $id;
    private $visitado;


    public function __construct( $id)
    {
        $this->id = $id;
        $this->visitado = false;
    }

    public function getId(){

        return $this->id;
    }

    public function getVisitado(){

        return $this->visitado;
    }

    public function setId($id){

        $this->id = $id;
    }

    public function setVisitado($v){

        $this->visitado = $v;
    }

}
?>