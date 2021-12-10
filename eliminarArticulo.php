<?php
include("include/funciones.php");

autenticado();

if($_SESSION['role'] > 1){
    extract($_GET);
    $conexion = conectarBD();
    $conexion->query("DELETE FROM `imagenes` WHERE `idprod` = $id");
    $conexion->query("DELETE FROM `reseña` WHERE `idprod` = $id");
    $res = $conexion->query("SELECT `idstock` FROM `productos` WHERE `idprod` = $id");
    $row = $res->fetch_array(MYSQLI_ASSOC);
    $conexion->query("DELETE FROM `stock` WHERE `stock`.`id` = ".$row['idstock']."");
    $conexion->query("DELETE FROM `productos` WHERE `idprod`= $id");
}


header($ruta."Portada.php");
?>