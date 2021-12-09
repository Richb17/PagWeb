<?php
include("include/funciones.php");

autenticado();
if(!isset($_GET["id"])  ){
    header($ruta."Portada.php");
}
extract($_GET);
$conexion = conectarBD();

$conexion->query("UPDATE `productos` SET `modified_at`=now(),`iddiscount`=NULL WHERE `idprod` = '$id'");

regresarUltimaUbi($ubi)
?>