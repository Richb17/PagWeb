<?php
    include("include/funciones.php");
    autenticado();
    //Se verifica que los datos enviados sean correctos
    if( !isset($_GET['album']) || !isset($_GET['artista'])|| 
        !isset($_GET['stock']) || !isset($_GET['descripcion'])||
        !isset($_GET['idprod'])){
            header($ruta."verProducto.php?id=".$_GET['idprod']."&err=1&ubi=".$_GET['ubi']);
    }
    else if( $_GET['album'] == "" || $_GET['artista'] == "" || 
        $_GET['precio'] == "" || $_GET['stock'] == ""){
        header($ruta."verProducto.php?id=".$_GET['idprod']."&err=2&ubi=".$_GET['ubi']);
    }
    else{
        extract($_GET);
        $conexion = conectarBD();
        //ejecución de la consulta en la BD
        $qry = $conexion->query("SELECT `idstock` FROM `productos` WHERE `idprod`=$idprod;");
        $idStock = $qry->fetch_array(MYSQLI_ASSOC);
        $stockQry = "UPDATE `stock` SET `quantity`='$stock' WHERE `id` = '".$idStock['idstock']."';";
        mysqli_query($conexion, $stockQry);
        
        $consulta = "UPDATE `productos` SET `albumname`='$album',`prices`='$precio',`description`='$descripcion',
                    `modified_at`=now(),`artistname`='$artista' WHERE `idprod`='$idprod'";
        mysqli_query($conexion, $consulta);
        
        mysqli_close($conexion);
        
        header($ruta."verProducto.php?id=".$_GET['idprod']."&err=0&ubi=".$_GET['ubi']);
    }
?>
