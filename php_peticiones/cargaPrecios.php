<?php
    //recoge los precios de un articulo y su foto

    //este foreach sirve para recoger todas las variables que se le pasen desde otro archivo javascript
    foreach($_POST as $nombre_campo => $valor){
        $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
        eval($asignacion);
    }
    include('../includes/conexionmysqli.php'); //Conecta a la base de datos

    if(!empty($inp_CREFS)){
        $cargaPrecios = "SELECT NPCONIVA, NPREMAYOR, CIMAGEN, CCODFAM, NCODCAT FROM ARTICULOS
        WHERE CREF = '$inp_CREFS'";
        $execute = mysqli_query($DB,$cargaPrecios);

        while($fila=mysqli_fetch_array($execute)){
        $data[]=$fila;
        }
        $jsonData=json_encode($data);
        echo $jsonData;

        
    }
    

?>