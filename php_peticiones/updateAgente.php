<?php
    include('../includes/conexionmysqli.php'); //Conecta a la base de datos

    $idAgente = $_POST['idAgente'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $clave = $_POST['clave'];
    $email = $_POST['email'];
    

    //cargta todos los CREFS de la base de datos para el combobox
    $query="UPDATE AGENTES SET CNBRAGE = '$nombre', CAPEAGE = '$apellidos', CCLVAGE = '$clave', EMAIL = '$email'  WHERE CCODAGE = '$idAgente'";
    $execute = mysqli_query($DB,$query);

    header('Content-Type: text/txt; charset=utf-8');
    