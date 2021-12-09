<?php
include("include/funciones.php");
autenticado();

$conexion = conectarBD();

if(!isset($_GET['id']) || !isset($_GET['ubi']) || !isset($_GET['comentario'])){
    header($ruta."portada.php");
    echo "Aqui";
}else if($_GET['comentario']!=''){
    echo "Todo Correcto";
    if(isset($_GET['rec'])){
       $conexion->query("INSERT INTO `reseña`(`idreview`, `idprod`, `username`, `vote`, `reviewtext`, `modified_at`, `created_at`) VALUES 
                                (NULL,'".$_GET['id']."','".$_SESSION['username']."','1','".$_GET['comentario']."',now(),now())");
    }else{
        $conexion->query("INSERT INTO `reseña`(`idreview`, `idprod`, `username`, `vote`, `reviewtext`, `modified_at`, `created_at`) VALUES 
                                (NULL,'".$_GET['id']."','".$_SESSION['username']."','0','".$_GET['comentario']."',now(),now())");
    }
    regresarUltimaUbi($_GET['ubi']);
}

?>
