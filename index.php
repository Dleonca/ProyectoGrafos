<?php
include ("grafo.php");

session_start();

if (isset($_SESSION["grafo"]) == false) {
    $_SESSION["grafo"] = new Grafo();
}

function phpAlert($msg)
{
    echo '<script type="text/javascript">alert("' . $msg . '")</script>';
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grafos</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js"></script>
</head>

<body>
    <h1>Proyecto Grafos</h1>
  <!– Agregar vertice –> 
    <div class="row">
      <div class="col-12">
        <form method="post">
          <input type="submit" name="btn-add-vert" value="AGREGAR" class="button-add">
          <h5 style="display: inline;">Agregar vertice </h5>
          <label>Id Vertice:</label>
          <input type="text" name="id_vertice" style="width: 20%;">
          </form>
      </div>
    </div>
  <?php
    //Boton agregar vertice
    if (isset($_POST["btn-add-vert"])) {
       $txt_vertice = $_POST["id_vertice"];
       if ($txt_vertice != null || $txt_vertice != "") {
         $_SESSION["grafo"]->agregarVertice(new Vertice($txt_vertice));
         $create = "se creo vertice $txt_vertice";
         phpAlert($create);
         $create = null;
      } else {
        phpAlert("Valor de vertice no puede ser nulo");
      }
    } 
  ?>
<!– Agregar arista –> 
  <div class="row">
    <div class="col-12">
    <form method="post">
      <div>
        <input type="submit" name="btn-add-aris" value="AGREGAR" class="button-add">
        <h5 style="display: inline;">Agregar Arista </h5>
        <p style="display: inline;">Vertice origen:</p>
        <input type="text" name="vertice_origen" style="width: 10%;">
        <p style="display: inline;">Vertice destino:</p>
        <input type="text" name="vertice_destino" style="width: 10%;">
        <p style="display: inline;">Peso:</p>
        <input type="text" name="vertice_peso" style="width: 10%;">
      </div>
    </form>
   </div>
  </div>
   <?php 
       //Boton agregar arista
      if (isset($_POST["btn-add-aris"])) {
         $txt_ari_o = $_POST["vertice_origen"];
         $txt_ari_d = $_POST["vertice_destino"];
         $txt_ari_peso = $_POST["vertice_peso"];
        if ($txt_ari_o != "" && $txt_ari_d != "") {
           $ret = $_SESSION["grafo"]->agregarArista($txt_ari_o, $txt_ari_d, $txt_ari_peso);
          if ($ret) {
            $create = 'Se agrego arista entre vertice ' . $txt_ari_o . ' y vertice ' . $txt_ari_d;
            phpAlert($create);
            $create = null;
          }
        } else {
          phpAlert("Debe digitar vertice de origen y destino no pueden ser nulo");
        }
      }
    ?>   


<!– Ver vertice –> 
    <div class="row">
      <div class="col-12">
        <form method="post">
          <input type="submit" name="ver-verti" value="AGREGAR" class="button-view">
          <h5 style="display: inline;">Ver vertice</h5>
          <p style="display: inline;">Id del vertice:</p>
          <input type="text" name="txt-ver-vert" id="txt-ver-vert" style="width: 10%;">
        </form>
      </div>
    </div>
<?php 
  //Boton ver vertice ---------------------------------------aqui da error cuando no encuentra vertice
  if (isset($_POST["ver-verti"])) {
    $txt_id_vert = $_POST["txt-ver-vert"];
    if ($txt_id_vert != "") {
      $d = $_SESSION["grafo"]->getVertice($txt_id_vert);
      if ($d === null || $d === "") {
        echo '<p>No se encontro vertice</p>';
      } else {
        echo "Se encontro el vertice " . $d->getId();
      }
    } else {
      phpAlert("El id del vertice no puede ser nulo");
    }
  }
?>
<!– Ver adyacentes –> 
    <div class="row">
      <div class="col-12">
        <form method="post">
          <input type="submit" name="ver-adya" class="button-adya" value="AGREGAR">
          <h5 style="display: inline;">Ver adyacentes</h5>
          <p style="display: inline;">Id del vertice:</p>
          <input type="text" name="txt-ver-ady" id="txt-ver-ady" style="width: 10%;">
        </form>
      </div>
    </div>
<?php
  //Boton ver adyacente
  if (isset($_POST["ver-adya"])) {
    $txt_id_ady = $_POST["txt-ver-ady"];
    if ($txt_id_ady != "") {
      $d = $_SESSION["grafo"]->getAdyacentes($txt_id_ady);
      if ($d === null || $d === "") {
        echo '<p>No se encontro adyacencia</p>';
      } else {
        echo "Vertices adyacentes de " . $txt_id_ady . "<br>";
        foreach ($d as $arr => $value) {
          echo "Vertice " . $arr . " <br>";
        }
      }
    } else {
      phpAlert("El id del vertice adyacente a buscar no puede ser nulo");
    }
  }
?>
<!– Ver grado –>
    <div class="row">
      <div class="col-12">
        <form method="post">
          <input type="submit" name="ver-grdos" value="AGREGAR" class="button-view">
          <h5 style="display: inline;">Ver grado</h5>
          <p style="display: inline;">Id del vertice:</p>
          <input type="text" name="txt-ver-grd" id="txt-ver-grd" style="width: 10%;">
        </form>
      </div>
    </div>
  <?php
    //boton ver grado
    if (isset($_POST["ver-grdos"])) {
      $txt_grds = $_POST["txt-ver-grd"];
      if ($txt_grds != "") {
        $d = $_SESSION["grafo"]->grado($txt_grds);
        if ($d === null || $d === "") {
          echo '<p>No tiene grados</p>';
        } else {
          echo "Grados: " . $d;
        }
      } else {
        phpAlert("Debe indicar el id de un vertice");
      }
    }
  ?>
<!– Eliminar vertice –>
    <div class="row">
      <div class="col-12">
        <form method="post">
          <input type="submit" name="delete-vert" class="button-delete" value="ELIMINAR">
          <h5 style="display: inline;">Eliminar vertice</h5>
          <p style="display: inline;">Id del vertice:</p>
          <input type="text" name="txt-delete-vert" id="txt-delete-vert" style="width: 10%;">
        </form>
      </div>
    </div>
<?php
  if (isset($_POST["delete-vert"])) {
    $txt_delver = $_POST["txt-delete-vert"];
    if ($txt_delver != "") {
      $_SESSION["grafo"]->eliminarVertice($txt_delver);
      phpAlert("Se elimino el vertice " . $txt_delver);
    } else {
      phpAlert("Debe indicar el id de un vertice");
    }
  }
?>
<!– Eliminar arista –>
    <div class="row">
      <div class="col-12">
        <form method="post">
          <input type="submit" name="delete-aris" class="button-delete" value="ELIMINAR">
          <h5 style="display: inline;">Eliminar arista</h5>
          <p style="display: inline;">Vertice origen</p>
          <input type="text" name="txt-delete-origen" id="txt-delete-origen" style="width: 10%;">
          <p style="display: inline;">Vertice destino</p>
          <input type="text" name="txt-delete-destino" id="txt-delete-destino" style="width: 10%;">
        </form>
      </div>
    </div>
  <div class="row">
    <div class="col-12">
      <form action="" method="post">
        <input type="text" name="txt-runway-inch" id="txt-runway-inch" style="width: 10%;">
        <input type="submit" name="recorrido-inch" value="recorrido de anchura">
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <form action="" method="post">
        <input type="text" name="txt-runway-prof" id="txt-runway-prof" style="width: 10%;">
        <input type="submit" name="recorrido-prof" value="recorrido de profundidad">
      </form>
    </div>
</div>
<?php
  //Boton agregar arista
  if (isset($_POST["delete-aris"])) {
    $txt_del_o = $_POST["txt-delete-origen"];
    $txt_del_d = $_POST["txt-delete-destino"];
    if ($txt_del_o != "" && $txt_del_d != "") {
      $_SESSION["grafo"]->eliminarArista($txt_del_o, $txt_del_d);
      deleteDialog("Se elimino la arista que va de " . $txt_del_o . " a " . $txt_del_d);
    } else {
      phpAlert("Debe digitar vertice origen y destino");
    }
  }
?>
<!– camino mas corto –>
    <div class="row">
      <div class="col-12">
        <form method="post">
          <input type="submit" name="caminoCorto" class="button-cmc" value="VER">
          <h5 style="display: inline;">camino mas corto:</h5>
           <p style="display: inline;">DE:</p>
          <input type="text" name="caminoDE" id="caminoDE" style="width: 10%;">
          <p style="display: inline;">A:</p>
          <input type="text" name="caminoA" id="caminoA" style="width: 10%;">
        </form>
      </div>
    </div>
<?php
  if (isset($_POST["caminoCorto"])) {
    $txt_cde= $_POST["caminoDE"];
    $txt_ca = $_POST["caminoA"];
    if ($txt_cde != "" and $txt_ca  != "" ) {
      $res = $_SESSION["grafo"]->CaminoMasCorto($txt_cde, $txt_ca);
       $str = "Recorrido camino mas corto: ";
        foreach ($res as $k => $val) {
        $str = $str . "->" . $val;}
     // phpAlert("La respuesta al camino mas corto es " .  $res);
       echo $str;
    } else {
      phpAlert("Debe indicar Recorrido");
    }
  }
?>
    
<!– Ver grafo –> 
    <div class="row">
      <div class="col-12">
        <form method="post">
          <input type="submit" name="ver-grafo" value="" style="display: inline;"             class="button-graph">
          <h5 style="display: inline;">Ver Grafo</h5>
        </form>
      </div>
    </div>
<?php
  //Boton ver grafo
  if (isset($_POST["ver-grafo"])) {
    ver_grafos();

  //Recorrer anchura
  }  elseif (isset($_POST["recorrido-inch"])) {
      if (($_POST["txt-runway-inch"] != "")) {
        $node_search = $_POST["txt-runway-inch"];
        $msgr = $_SESSION["grafo"]->recorrerAnchura($node_search);
        $str = "Recorrido por anchura : ";
        foreach ($msgr as $k => $val) {
        $str = $str . "->" . $val;
  }
      echo $str;
    }
    //Recorrer profundidad
  } elseif (isset($_POST["recorrido-prof"])) {
      if (($_POST["txt-runway-prof"] != "")) {
        $node_searchw = $_POST["txt-runway-prof"];
        $msgrw = $_SESSION["grafo"]->RecorrerProfundidad($node_searchw);
        //print_r($msgrw);
        php_alert($msgrw);
        
    }
  }


        
//Funcion Ver Grafos
  function ver_grafos(){
    $string_generate_aristas = null;
    $mA = $_SESSION["grafo"]->getMatrizA();
    foreach ($mA as $a => $adya) {
      if ($adya != null) {
        foreach ($adya as $de => $val) {
          $string_generate_aristas = $string_generate_aristas . '{from:"' . $a . '",to:"' . $de . '",label:"' . $val . '"},';
        }
      }
    }
     echo "<br>";
     $mV = $_SESSION["grafo"]->getVectorV();
     $string_generate_nodes = null;
     $numc = 0;
     $arr_color = ["#F76262", "#FFFE9E", "#C0FF9E", "#9EFFED", "#DD9EFF", "#FFD79E", "#5070FF", "#D9D7D7", "#A5FFDD", "#FFA5ED"];
    foreach ($mV as $v => $valuev) {
      $str = $valuev->getId();
      $numc = $numc + 1;
      $add_color = $arr_color[rand(0, 9)];
      if ($numc == count($mV)) {
         $string_generate_nodes = $string_generate_nodes . "{id: '$str', label: '$str',color:{background:'$add_color'} }";
      } else {
        $string_generate_nodes = $string_generate_nodes . "{id: '$str', label: '$str',color:{background:'$add_color'} },";
      }
    }
    
    $split_string_generate_arista = substr($string_generate_aristas, 0, -1);
    echo ' <div class="row"> <div class="col-12"> <div id="content-grafo" style="width:90%;height:400px;"> </div></div></div>';
    generateGrafo($string_generate_nodes, $split_string_generate_arista);
  } 
  $yen = $_SESSION["grafo"]->getVectorV();
  if (isset($yen)) {
    ver_grafos();
  }
?>
  
<?php
function generateGrafo($string_node_complete, $split_string_generate_arista)
  {
    echo '<script type="text/javascript">
      var nodos = new vis.DataSet([' . $string_node_complete . ']);
      var aristas = new vis.DataSet([' . $split_string_generate_arista . ']);
      var contenedores = document.getElementById("content-grafo");
      var datos = {
        nodes: nodos,
        edges: aristas
      };    
      var opciones = {
        edges: {
          arrows: {
          to: {
           enabled: true
           }
          }
        }
      };
    var grafo = new vis.Network(contenedores, datos, opciones);
    </script>';
    }
?>

</body>
</html>