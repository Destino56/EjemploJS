<?php
    //clase para cargar todos los colores de un CREF
    foreach($_POST as $nombre_campo => $valor){
        $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
        eval($asignacion);
    }

    include('../includes/conexionmysqli.php'); //Conecta a la base de datos

    //comprueba que se le pase algun CREF y carga sus colores
   if(!empty($inp_CREFS)){
        $cargaColores="SELECT COLORES.COLOR, COLORES.CIMAGEN, COLORES.DESCRIPCION, STOCKS.TALLA, STOCKS.NSTOCK FROM COLORES 
        INNER JOIN STOCKS ON COLORES.COLOR = STOCKS.COLOR 
        WHERE STOCKS.CREF = '$inp_CREFS' ORDER BY STOCKS.COLOR, STOCKS.TALLA ";
        $execute = mysqli_query($DB,$cargaColores);
    
        header('Content-Type: text/txt; charset=utf-8');
        while($fila=mysqli_fetch_array($execute)){
            $data[]=$fila;
        }
        $jsonData=json_encode($data);
        echo $jsonData;
    }
    

   /*ORDEN DE LA QUERY:
        2XL
        3XL
        L
        M
        S
        XL
    */
?>














