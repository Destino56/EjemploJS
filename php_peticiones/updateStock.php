<?php

foreach ($_POST as $nombre_campo => $valor) {
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
    eval($asignacion);
}
include('../includes/conexionmysqli.php'); //Conecta a la base de datos

$idCREF = "idCREF";
$idColor = "idColor";
$idTalla = "idTalla";
$idStock = "idStock";
$contador = 0;

$CREF_Completo = $idCREF . $contador;

echo $_POST[$CREF_Completo];
do {
    $CREF_Completo = $idCREF . $contador;
    $color_Completo = $idColor . $contador;
    $talla_Completo = $idTalla . $contador;
    $stock_Completo = $idStock . $contador;

    $updateStock = "UPDATE STOCKS SET NSTOCK = '$_POST[$stock_Completo]' WHERE CREF = '$_POST[$CREF_Completo]'
AND COLOR = '$_POST[$color_Completo]' AND TALLA = '$_POST[$talla_Completo]'";
    $execute = mysqli_query($DB, $updateStock);
    $updateStock = "UPDATE STOCKS_DEV SET NSTOCKS = '$_POST[$stock_Completo]' WHERE CREF = '$_POST[$CREF_Completo]'
AND COLOR = '$_POST[$color_Completo]' AND TALLA = '$_POST[$talla_Completo]'";
    $execute = mysqli_query($DB, $updateStock);
    $contador++;
    $siguienteArticulo = $idCREF . $contador;
} while (isset($_POST[$siguienteArticulo]));
