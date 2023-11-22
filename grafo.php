<?php
include("vertice.php");

class Grafo
{

    private $matrizA; // aristar [].[].[]
    private $vectorV; // nodos A
    private $dirigido; // -> vertice
    private $cola = null; // cola de adyacentes

    public function __construct($dir = true){

        $this->matrizA = null; // matriz de aristas || Array de 2 posiciones [A][B],[]
        $this->vectorV = null; // vector de nodos || Array de 1 posicion [B],[C],[D]
        $this->dirigido = $dir; // dirigido o no dirigido
    }

    /// vertices igual nodos
    public function agregarVertice($v)
    {
        // si el vector de nodos no tiene el nodo asociado (ejemplo ["B"=10])
        // "si no existe"
        if (!isset($this->vectorV[$v->getId()])) {
            $this->matrizA[$v->getId()] = null;
            $this->vectorV[$v->getId()] = $v; // se agrega el objeto al vector de nodos
        } else {
            return false;
        }
        // sin la validacion del if se remplazaria el nodo ya existente.
        return true;
    }
    /// vertices igual nodos
    public function getVertice($v)
    {
        return $this->vectorV[$v];
    }

    public function getCola()
    {
        return $this->cola;
    }
    // agregar aristas a las matriz de aristas
    // - origen
    // - destino
    // - peso
    public function agregarArista($o, $d, $p = null)
    {
        // si el origen y el destino se encuentran asociados a un nodo entonces, se asocia una arista a estos nodos
        // $matrizA["A"]["D"] = 10
        if (isset($this->vectorV[$o]) && isset($this->vectorV[$d])) {
            $this->matrizA[$o][$d] = $p;
        } else {
            return false;
        }

        return true;
    }

    //recibe id de nodo y retorna en un arreglo sus adyacentes.
    public function getAdyacentes($v)
    {
        return $this->matrizA[$v];
    }

    public function getMatrizA()
    {
        return $this->matrizA;
    }

    public function getVectorV()
    {
        return $this->vectorV;
    }

    //recibe el id del vertice y retorna grado de salida del mismo
    public function gradoSalida($v)
    {
        $array = $this->matrizA[$v];
        if ($array != null) {
            $num = count($this->matrizA[$v]);
            if ($num != null) {
                return $num;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
    public function gradoEntrada($v)
    {
        $gr = 0;
        if ($this->matrizA != null) {
            foreach ($this->matrizA as $vp => $adya) {
                if ($adya != null) {
                    foreach ($adya as $de => $pe) {
                        if ($de == $v) {
                            $gr++;
                        }
                    }
                }
            }
        }

        return $gr;
    }

    //recibe el id del vertice y retorna grado del mismo
    public function grado($v)
    {

        return $this->gradoSalida($v) + $this->gradoEntrada($v);
    }

    //recibe id de vertice origen y destino
    public function eliminarArista($o, $d)
    {
        if (isset($this->matrizA[$o][$d])) {
            unset($this->matrizA[$o][$d]);
        } else {
            return false;
        }

        return true;
    }

    //recibe id de vertice a eliminar, elimina aristas relacionadas
    public function eliminarVertice($v)
    {
        if (isset($this->vectorV[$v])) {
            foreach ($this->matrizA as $vp => $adya) {
                if ($adya != null) {
                    foreach ($adya as $de => $pe) {
                        if ($de == $v) {
                            unset($this->matrizA[$vp][$de]);
                        }
                    }
                }
            }
            unset($this->matrizA[$v]);
            unset($this->vectorV[$v]);
        } else {
            return false;
        }
        return true;
    }

    // COLA
    public function recorrerAnchura($v)
    {
        $cola=array();
        $visitados=array();
        // nodo inicial = nodo A
        if ($v != null) {

            $cola[] = $v;
            $visitados[$v]=1;

           for ($i=0; $i < count($cola); $i++) { 
            $nodo = $cola[$i];
            //   echo "nodo:".$nodo;
               // si el nodo esta en al matriz de adyacentes
               if (isset($this->matrizA[$nodo])){
                    foreach ($this->matrizA[$nodo] as $k => $v){
                       // print_r($v);
                        if(!isset($visitados[$k])){
                            $cola[]=$k;
                            $visitados[$k]=1;

                        }
                    }
               }
            }
               return $cola;
        }else{
        return false;

        }
        
    }



    public function RecorrerProfundidad($v){

        if(isset($this->vectorV[$v])){
            $cola =array();
            $visitados=array();

            if(!isset($visitados[$v])){
                $cola[]=$v;
                $visitados[$v]=1;
            }

            if(isset($this->matrizA[$v])){
                foreach($this->matrizA[$v] as $key => $value){

                    if(!isset($visitados[$key])){
                        $cola[]=$key;
                        $visitados[$key]=1;
                        $cola[]=$this->RecorrerProfundidad($key);
                    }

                }//End for*/
            }
            return $cola;

        }else{
            return false;
        }
    }

  
    public function CaminoMasCorto($a,$b){
        //Validmos si existe los vertice
        if(isset($this->vectorV[$a]) AND isset($this->vectorV[$b])){
            $S = array();
            $Q = array();
            foreach(array_keys($this->matrizA) as $val) $Q[$val] = 99999;
            $Q[$a] = 0;
            //inicio calculo
            while(!empty($Q)){
                $min = array_search(min($Q), $Q);
                if($min == $b) break;
                foreach($this->matrizA[$min] as $key=>$val) if(!empty($Q[$key]) && $Q[$min] + $val < $Q[$key]) {
                    $Q[$key] = $Q[$min] + $val;
                    $S[$key] = array($min, $Q[$key]);
                }
                unset($Q[$min]);
            }//End WHile
            $path = array();
            $pos = $b;
            while($pos != $a){
                $path[] = $pos;
                $pos = $S[$pos][0];
            }
            $path[] = $a;
            $path = array_reverse($path);
            return $path;
        }else{
            return false;
        }

    }

  


}