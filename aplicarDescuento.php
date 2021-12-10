<?php
    include("include/funciones.php");
    autenticado();
    if(!isset($_GET["idprod"]) || !isset($_GET["iddesc"]) ){
        header($ruta."seleccionarDescuento.php?err=1&id=".$_GET["idprod"]."");
    }
    extract($_GET);
    $conexion = conectarBD();

    $conexion->query("UPDATE `productos` SET `modified_at`=now(),`iddiscount`='$iddesc' WHERE `idprod` = '$idprod'");

    regresarUltimaUbi($ubi);
?>