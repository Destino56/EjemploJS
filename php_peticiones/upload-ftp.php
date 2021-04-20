<?php

    $cref = $_POST["inp_CREFS"];

    //echo $cref;

    $connection = ftp_connect("hosting.ftpcomputers.info");
    $login = ftp_login($connection, "antonioalonso_ftpagentes_u", "bzbMtbMDS5#");
    if( (!$connection) || (!$login)){
        echo 'No se pudo conectar';
    }else{
        echo 'Conectado correctamente <br>';
        $temp = explode(".", $_FILES['upload']['name']);
        $source_file = $_FILES['upload']['tmp_name'];
        $destino_nombre = "web/imgs/producto/" . $cref . ".jpg";
        //$nombre=$_FILES['upload']['name'];
        $upload = ftp_put($connection, $destino_nombre, $source_file, FTP_BINARY);

        if ($upload){
            echo "          Imagen subida correctamente";
        }else{
            echo "          No se ha podido subir la imágen";
        }
    }

?>
